<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'interview/*/start',
        'interview/*/verify',
        'interview/*/signaling/*',
        'interview/log-error',
    ];
}
