<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyWebhookCsrf extends Middleware
{
    protected $except = [
        'webhooks/stakaba', // exclude your webhook route
    ];
}

