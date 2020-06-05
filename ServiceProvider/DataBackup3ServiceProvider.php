<?php

namespace Plugin\DataBackup3\ServiceProvider;

use Eccube\Application;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;
use Plugin\DataBackup3\Form\Type\DataBackup3ConfigType;
use Plugin\DataBackup3\Service\DataBackup3Service;
use Symfony\Component\Yaml\Yaml;

class DataBackup3ServiceProvider implements ServiceProviderInterface
{
    public function register(BaseApplication $app)
    {
        $app['eccube.service.databackup3'] = $app->share(function () use ($app) {
            return new DataBackup3Service($app);
        });
        $admin = $app['controllers_factory'];
        $admin->match('/plugin/DataBackup3/config', '\\Plugin\\DataBackup3\\Controller\\ConfigController::index')
            ->bind('plugin_DataBackup3_config');
        $admin->post('/plugin/DataBackup3/config/doBackup', '\\Plugin\\DataBackup3\\Controller\\ConfigController::doBackup')
            ->bind('plugin_DataBackup3_config_dobackup');
        $app->mount('/'.trim($app['config']['admin_route'], '/').'/', $admin);

        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $types[] = new DataBackup3ConfigType($app['config']);
            return $types;
        }));

    }

    public function boot(BaseApplication $app)
    {
    }
}
