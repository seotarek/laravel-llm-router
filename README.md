# Laravel LLM Router ⚡

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Laravel 11](https://img.shields.io/badge/Laravel-11-red.svg)](https://laravel.com)
[![PHP 8.2+](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)

**A production-ready Laravel 11 package for intelligent multi-provider LLM routing, cost optimization, and automated failover across Google Gemini, OpenAI, and Anthropic Claude.**

Developed by **Tarek Mohamed** ([@seotarek](https://github.com/seotarek))

---

## 📌 Why Laravel LLM Router?

In production SaaS applications, relying on a single AI provider causes downtime during rate-limits or service outages. **Laravel LLM Router** ensures 99.9% AI uptime by routing prompts through prioritized providers with automatic failover in milliseconds:

```
[ Laravel App ]
       │
       ▼
[ LlmRouter Facade ]
       │
       ├──► 1. Google Gemini (Fast & Cost-Efficient) ──► Success!
       │         │ (If rate limited or timeout)
       │         ▼
       ├──► 2. OpenAI GPT-4o-mini (Automatic Fallback)
       │         │ (If failure)
       │         ▼
       └──► 3. Anthropic Claude (Resilience Layer)
```

---

## 🚀 Installation

Install via Composer:
```bash
composer require seotarek/laravel-llm-router
```

Publish the configuration file:
```bash
php artisan vendor:publish --tag="llm-router-config"
```

Add your API keys to `.env`:
```env
LLM_ROUTER_STRATEGY=priority_fallback
GEMINI_API_KEY=your-gemini-key
OPENAI_API_KEY=your-openai-key
```

---

## 💻 Usage

### Basic Usage with Automatic Failover:
```php
use Seotarek\LlmRouter\Facades\LlmRouter;

$response = LlmRouter::generate("Summarize the customer request: ...");

echo $response['text'];
echo $response['provider']; // 'gemini' or 'openai'
```

---

## 📜 License
Open-sourced software licensed under the [MIT license](LICENSE).
