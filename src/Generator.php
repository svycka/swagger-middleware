<?php

namespace SwaggerMiddleware;

class Generator
{
    private $config;

    public function __construct(array $config)
    {
        if (empty($config['scan']['paths']) || !is_array($config['scan']['paths'])) {
            throw new \InvalidArgumentException(
                'Invalid scan \'paths\' config option. Please provide at least one path.'
            );
        }

        $this->config = $config;
    }

    public function generate(array $customConfig = null): \OpenApi\Annotations\OpenApi
    {
        $config = $customConfig ?? $this->config;

        return \OpenApi\scan($config['scan']['paths'], $config['scan']['options'] ?? []);
    }
}
