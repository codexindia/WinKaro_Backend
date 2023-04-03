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
        Form::component('wtextbox', 'admin.components.textbox', ['name', 'value' => null, 'attributes' => []]);
        Form::component('wpassword', 'admin.components.password', ['name', 'value' => null, 'attributes' => []]);
        Form::component('wsubmit', 'admin.components.button', ['name','attributes' => []]);
        Form::component('wcheckbox', 'admin.components.checkbox', ['name','label','attributes' => []]);
    }
}
