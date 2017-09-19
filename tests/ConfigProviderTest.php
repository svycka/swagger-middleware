<?php

namespace SwaggerMiddlewareTest;

use SwaggerMiddleware\ConfigProvider;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    public function testCanReturnConfig()
    {
        $configProvider = new ConfigProvider();
        $config = $configProvider->__invoke();
        $this->assertArrayHasKey('dependencies', $config);
        $this->assertArrayHasKey('swagger-middleware', $config);
    }
}
