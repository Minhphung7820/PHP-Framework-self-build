<?php

namespace App\Providers;

interface BaseServiceProvider
{
    public function register();
    public function boot();
}
