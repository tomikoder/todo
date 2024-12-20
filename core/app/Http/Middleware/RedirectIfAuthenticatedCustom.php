<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

class RedirectIfAuthenticatedCustom extends RedirectIfAuthenticated
{
    protected function defaultRedirectUri(): string
    {
        return route('item.list');
    }
}
