<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

class RedirectIfAuthenticatedCustom extends RedirectIfAuthenticated
{
    protected function defaultRedirectUri(): string
    {
        return route('item.list');
    }
}
