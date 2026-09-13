<?php

namespace Seotarek\LlmRouter\Services;

use Seotarek\LlmRouter\Drivers\GeminiDriver;
use Seotarek\LlmRouter\Drivers\OpenAiDriver;
use Illuminate\Support\Facades\Log;
use Exception;

class RouterService
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function generate(string $prompt, array $options = []): array
    {
        $providers = $this->config['providers_priority'] ?? ['gemini', 'openai'];
        $lastException = null;

        foreach ($providers as $providerName) {
            try {
                $driverConfig = $this->config['providers'][$providerName] ?? [];
                if (empty($driverConfig['api_key'])) {
                    continue;
                }

                $driver = match ($providerName) {
                    'gemini' => new GeminiDriver($driverConfig),
                    'openai' => new OpenAiDriver($driverConfig),
                    default => throw new Exception("Unsupported driver: {$providerName}")
                };

                return $driver->generateText($prompt, $options);
            } catch (Exception $e) {
                Log::warning("LlmRouter: Provider '{$providerName}' failed. Trying next...", ['error' => $e->getMessage()]);
                $lastException = $e;
            }
        }

        throw new Exception("All configured LLM providers failed. Last error: " . ($lastException?->getMessage() ?? 'Unknown'));
    }
}
