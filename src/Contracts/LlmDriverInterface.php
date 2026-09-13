<?php

namespace Seotarek\LlmRouter\Contracts;

interface LlmDriverInterface
{
    public function generateText(string $prompt, array $options = []): array;
}
