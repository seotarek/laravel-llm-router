<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Provider Strategy
    |--------------------------------------------------------------------------
    | Options: 'cost_optimized', 'speed_optimized', 'priority_fallback'
    */
    'strategy' => env('LLM_ROUTER_STRATEGY', 'priority_fallback'),

    /*
    |--------------------------------------------------------------------------
    | Priority Provider Order for Failover
    |--------------------------------------------------------------------------
    */
    'providers_priority' => ['gemini', 'openai', 'claude'],

    /*
    |--------------------------------------------------------------------------
    | Provider Credentials & Base Models
    |--------------------------------------------------------------------------
    */
    'providers' => [
        'gemini' => [
            'api_key' => env('GEMINI_API_KEY'),
            'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),
            'timeout' => 15,
        ],
        'openai' => [
            'api_key' => env('OPENAI_API_KEY'),
            'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
            'timeout' => 15,
        ],
        'claude' => [
            'api_key' => env('ANTHROPIC_API_KEY'),
            'model' => env('CLAUDE_MODEL', 'claude-3-5-haiku-latest'),
            'timeout' => 15,
        ],
    ],
];
