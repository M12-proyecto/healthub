<?php

namespace App\Http\Middleware;

use Closure;

class VerifyIfAuthenticated
{
    /**
     * Handle session user.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }
    }
}