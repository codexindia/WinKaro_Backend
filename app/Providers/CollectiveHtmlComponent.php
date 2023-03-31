<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;
class CollectiveHtmlComponent extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Form::component('TextBox', 'admin.components.textbox', ['name', 'value' => null, 'attributes' => []]);
    }
}
