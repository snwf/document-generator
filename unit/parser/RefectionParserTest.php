<?php

declare(strict_types = 1);

namespace unit;

use ReflectionClass;
use PHPUnit\Framework\TestCase;
use DocumentGenerator\parser\RefectionParser;

/**
 * test case for RefectionParser
 *
 * @author wolf
 */
class RefectionParserTest extends TestCase
{
    /** this is a test message. @var int $e_int */
    public int $e_int = 1;

    /**
     * this is a test description.
     *
     * @var float $e_float
     */
    public float $e_float = 0.1;

    /**
     * keep out!
     *
     * @var string
     */
    private string $deny = 'not read';

    /**
     * class string parse case.
     */
    public function testClassParse ()
    {
        $parser = new RefectionParser();
        $data = $parser->parse(__CLASS__);
        self::assertIsArray($data);
        self::assertArrayHasKey('traits', $data);
        self::assertArrayHasKey('parent', $data);
        self::assertArrayHasKey('another', $data);
        self::assertArrayHasKey('methods', $data);
        self::assertArrayHasKey('constants', $data);
        self::assertArrayHasKey('attributes', $data);
        self::assertArrayHasKey('interfaces', $data);
        self::assertArrayHasKey('properties', $data);
        self::assertArrayHasKey('description', $data);
        self::assertArrayHasKey('static_properties', $data);


        // TODO more detail
        self::assertEquals(get_parent_class($this), $data['parent']->getName());

        $ref_class = new ReflectionClass($this);
        $parser_interfaces = array_map(function ($class) { return $class->getName(); }, $data['interfaces']);
        $interfaces = array_map(function ($class) { return $class->getName(); }, $ref_class->getInterfaces());
        foreach ($interfaces as $interface) {
            self::assertContains($interface, $parser_interfaces);
        }
    }
}