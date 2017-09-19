<?php

namespace SwaggerMiddlewareTest;

use SwaggerMiddleware\Generator;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
    public function testCanGenerate()
    {
        $config = [
            'scan' => [
                'paths' => [
                    __DIR__.'/Assets/Spec.php'
                ]
            ]
        ];
        $generator = new Generator($config);
        $swagger = $generator->generate();
        $this->assertInstanceOf(\Swagger\Annotations\Swagger::class, $swagger);
        $this->assertEquals('Test API', $swagger->info->title);
    }

    public function testCanGenerateUsingCustomConfig()
    {
        $config = [
            'scan' => [
                'paths' => [
                    __DIR__.'/Assets/Something.php'
                ]
            ]
        ];
        $generator = new Generator($config);
        $swagger = $generator->generate([
            'scan' => [
                'paths' => [
                    __DIR__.'/Assets/Spec.php'
                ]
            ]
        ]);
        $this->assertInstanceOf(\Swagger\Annotations\Swagger::class, $swagger);
        $this->assertEquals('Test API', $swagger->info->title);
    }

    public function testWillThrowExceptionWithInvalidConfig()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid scan \'paths\' config option. Please provide at least one path.');
        new Generator([]);
    }
}
