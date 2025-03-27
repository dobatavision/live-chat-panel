<?php

class Kernel
{
    protected $routeMiddleware = [
        // ...existing middleware...
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];
}
