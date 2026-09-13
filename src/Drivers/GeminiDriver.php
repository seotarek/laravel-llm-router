<?php

namespace Seotarek\LlmRouter\Drivers;

use Seotarek\LlmRouter\Contracts\LlmDriverInterface;
use Illuminate\Support\Facades\Http;
use Exception;

class GeminiDriver implements LlmDriverInterface
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function generateText(string $prompt, array $options = []): array
    {
        $apiKey = $this->config['api_key'] ?? '';
        $model = $this->config['model'] ?? 'gemini-1.5-flash';
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $response = Http::timeout($this->config['timeout'] ?? 15)->post($endpoint, [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ]);

        if (!$response->successful()) {
            throw new Exception("Gemini API error: " . $response->body());
        }

        $data = $response->json();
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        return [
            'provider' => 'gemini',
            'model' => $model,
            'text' => $text,
            'status' => 'success'
        ];
    }
}
