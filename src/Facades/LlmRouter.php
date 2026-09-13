<?php

namespace Seotarek\LlmRouter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array generate(string $prompt, array $options = [])
 */
class LlmRouter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'llm-router';
    }
}
