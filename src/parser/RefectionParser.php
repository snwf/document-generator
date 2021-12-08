<?php

declare(strict_types = 1);

namespace DocumentGenerator\parser;

use Generator;
use Reflection;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;
use ReflectionFunction;
use ReflectionUnionType;
use DocumentGenerator\ParserInterface;

/**
 * parse file or string to array
 */
class RefectionParser implements ParserInterface
{

    /**
     * @inheritDoc
     */
    public function parse ($data): array
    {
        $parse_data = [];
        if (is_string($data)) {
            if (class_exists($data)) { // try to resolve to class.
                $class = new ReflectionClass($data);
                // TODO: parse class Traits
                $parse_data['traits'] = $class->getTraits();
                $parse_data['parent'] = $class->getParentClass();
                // TODO parse class another data
                $parse_data['another'] = [];
                // TODO: parse class constants
                $parse_data['constants'] = $class->getConstants();
                // TODO: parse class Attributes
                $parse_data['attributes'] = $class->getAttributes();
                // TODO: parse class description
                $parse_data['description'] = $class->getDocComment();
                $parse_data['interfaces'] = $class->getInterfaces();
                $parse_data['methods'] = $this->methods($class->getMethods());
                $parse_data['properties'] = $this->properties($class->getProperties());
                $parse_data['static_properties'] = $this->properties($class->getStaticProperties());
            } elseif (function_exists($data)) { // try to resolve to function
                $parse_data = $this->function(new ReflectionFunction($data));
            } else { // if not, try parse string.
                // TODO
            }

        }
        return $parse_data;
    }

    /**
     * parse methods comments.
     *
     * @param array $methods
     * @return array
     */
    protected function methods (array $methods): array
    {
        $data = [];
        /** @var ReflectionMethod $method */
        foreach ($methods as $i => $method) {
            // TODO: Attributes

            // others
            $data[$i] = $this->function($method);
        }

        return $data;
    }

    /**
     * parse function comments.
     *
     * @param ReflectionFunction|ReflectionMethod $fn
     * @return array
     */
    protected function function (ReflectionFunction|ReflectionMethod $fn): array
    {
        $comments = $fn->getDocComment();
        $return = $fn->getReturnType();
        $data = ['name' => $fn->getName(), 'description' => '', 'params' => [], 'another' => [], 'return' => '', 'throw' => null];
        if (is_null($return)) {
            $data['return'] = 'void';
        } elseif ($return instanceof ReflectionUnionType) {
            $data['return'] = implode('|', $return->getTypes());
        } else {
            $data['return'] = $return->getName();
        }

        if ($comments !== false) {
            $comments = trim($comments, "/* \n");
            $lines = $this->lines($comments);
            foreach ($lines as $line) {
                if (str_starts_with($line, '* @')) {
                    $param = $this->line($line);
                    if (isset($data[$param['flag']])) {
                        if ($param['flag'] === 'params') {
                            $data['params'][] = ['name' => $param['name'], 'type' => $param['type'], 'description' => $param['description']];
                        } elseif (isset($data[$param['flag']])) {
                            $data[$param['flag']] = $param['description'];
                        } else {
                            $data['another'][] = ['name' => $param['flag'], 'description' => $param['description']];
                        }
                    }
                } else {
                    $str = trim($line, '* ');
                    $str = array_filter(explode("\n", $str), function ($v) {
                        return !empty($v);
                    });
                    $data['description'] .= array_reduce($str, function ($carry, $item) {
                        return $carry . trim($item) . "\n";
                    }, '');
                }
            }
        }

        return $data;
    }

    /**
     * return effective line generator
     *
     * @param string $comments
     * @return Generator
     */
    protected function lines (string $comments): Generator
    {
        $flag = '* ';
        $flag_len = strlen($flag);
        $comments = trim($comments, "/* \n");
        $start = $offset = strpos($comments, $flag);
        if ($start === false) {
            yield $comments;
        } else {
            do {
                $ended = strpos($comments, $flag, $offset + 1);
                if ($comments[$ended + $flag_len] === '@' || $comments[$ended + $flag_len + 1] === '@') {
                    yield substr($comments, $start, $ended - $start);
                    $start = $ended;
                }
                $offset = $ended;
            } while ($offset !== false);

            yield substr($comments, $start);
        }
    }

    /**
     * return deal data.
     *
     * @param string $line
     * @return array
     */
    protected function line (string $line): array
    {
        $data = [];
        $line = trim($line, "* \n");
        $flag = strstr($line, '@');
        $flag = strstr($flag, ' ', true) ?: $flag;
        $line = ltrim(substr($line, strpos($line, $flag) + strlen($flag)));

        $data['flag'] = substr($flag, 1);
        if ($data['flag'] === 'param') {
            $items = array_filter(explode(' ', $line), function ($item) {
                return strlen(trim($item)) > 0;
            });
            $items_count = count($items);
            if ($items_count >= 3) {
                $data['type'] = array_shift($items);
                $data['name'] = array_shift($items);
                $data['description'] = implode('', $items);
            } elseif ($items_count === 2) {
                $data['type'] = array_shift($items);
                $data['name'] = array_shift($items);
            }
        } elseif ($data['flag'] === 'return' || $data['flag'] === 'throw' || $data['flag'] === 'throws') {
            $items = array_filter(explode(' ', $line), function ($item) {
                return strlen(trim($item)) > 0;
            });
            $items_count = count($items);
            $data['type'] = array_shift($items);
            $data['description'] = $items_count >= 2 ? implode('', $items) : '';
        } else {
            $data['description'] = $line;
        }
        return $data;
    }

    /**
     * parse properties comments.
     *
     * @param array $properties
     * @return array
     */
    protected function properties (array $properties): array
    {
        $data = [];
        /** @var ReflectionProperty $property */
        foreach ($properties as $i => $property) {
            $comments = trim($property->getDocComment(), "/* \n");
            if (str_contains($comments, "\n")) { // multi-line comments
                $variables = explode("\n", $comments);
                foreach ($variables as $index => &$variable) {
                    $variable = trim($variable, '/* ');
                    if (strlen($variable) === 0) {
                        unset($variables[$index]);
                    }
                }
                $description = count($variables) === 1 ? '' : array_shift($variables);
                $variables = explode(' ', array_pop($variables));
            } else { // single line comment
                $comments = trim($comments, '/*');
                $description = trim(strstr($comments, '@', true));
                $variables = explode(' ', mb_substr($comments, mb_strlen($description) + 1));
                $variables = array_values(array_filter($variables, function ($item) {
                    return strlen(trim($item)) > 0;
                }));
            }
            $data[$i] = ['auth' => Reflection::getModifierNames($property->getModifiers()), 'name' => $property->getName(), 'description' => $description];
            $data[$i]['type'] = $variables[1] === $data[$i]['name'] ? 'mixed' : $variables[1];
        }

        return $data;
    }
}