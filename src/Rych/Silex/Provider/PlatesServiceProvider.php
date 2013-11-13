<?php

namespace Rych\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Rych\Plates\Extension\RoutingExtension;
use Rych\Plates\Extension\SecurityExtension;

class PlatesServiceProvider implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $app['plates.path'] = null;
        $app['plates.folders'] = array ();

        $app['plates'] = $app->share(function ($app) {
            $plates = new \Plates\Engine($app['plates.path']);
            $plates->app = $app;
            foreach ($app['plates.folders'] as $name => $path) {
                $plates->addFolder($name, $path);
            }

            if (isset($app['url_generator'])) {
                $plates->loadExtension(new RoutingExtension($app['url_generator']));
            }

            if (isset($app['security'])) {
                $plates->loadExtension(new SecurityExtension($app['security']));
            }

            return $plates;
        });
    }

    public function boot(Application $app)
    {
    }

}

