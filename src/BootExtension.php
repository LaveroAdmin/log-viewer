<?php

namespace LaveroAdmin\Admin\LogViewer;

use LaveroAdmin\Admin\Admin;

trait BootExtension
{
    /**
     * {@inheritdoc}
     */
    public static function boot()
    {
        static::registerRoutes();

        Admin::extend('log-viewer', __CLASS__);
    }

    /**
     * Register routes for LaveroAdmin.
     *
     * @return void
     */
    protected static function registerRoutes()
    {
        parent::routes(function ($router) {
            /* @var \Illuminate\Routing\Router $router */
            $router->get('logs', 'LaveroAdmin\Admin\LogViewer\LogController@index')->name('log-viewer-index');
            $router->get('logs/{file}', 'LaveroAdmin\Admin\LogViewer\LogController@index')->name('log-viewer-file');
            $router->get('logs/{file}/tail', 'LaveroAdmin\Admin\LogViewer\LogController@tail')->name('log-viewer-tail');
            $router->get('logs/{file}/download', 'LaveroAdmin\Admin\LogViewer\LogController@download')->name('log-viewer-download');
            $router->post('logs/{file}/clear', 'LaveroAdmin\Admin\LogViewer\LogController@clear')->name('log-viewer-clear');
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        parent::createMenu('Log viewer', 'logs', 'icon-exclamation-triangle');

        parent::createPermission('Logs', 'ext.log-viewer', 'logs*');
    }
}
