<?php

namespace LaveroAdmin\Admin\LogViewer;

use Illuminate\Support\ServiceProvider;

class LogViewerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'lavero-admin-logs');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'lavero-admin-logs');

        LogViewer::boot();
    }
}
