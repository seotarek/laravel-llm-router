<?php

namespace Seotarek\LlmRouter\Drivers;

use Seotarek\LlmRouter\Contracts\LlmDriverInterface;
use Illuminate\Support\Facades\Http;
use Exception;

class OpenAiDriver implements LlmDriverInterface
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function generateText(string $prompt, array $options = []): array
    {
        $apiKey = $this->config['api_key'] ?? '';
        $model = $this->config['model'] ?? 'gpt-4o-mini';

        $response = Http::withToken($apiKey)
            ->timeout($this->config['timeout'] ?? 15)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ]
            ]);

        if (!$response->successful()) {
            throw new Exception("OpenAI API error: " . $response->body());
        }

        $data = $response->json();
        $text = $data['choices'][0]['message']['content'] ?? '';

        return [
            'provider' => 'openai',
            'model' => $model,
            'text' => $text,
            'status' => 'success'
        ];
    }
}
