Plates Template Engine for Silex
================================

This project aims to provide integration of the [Plates](http://platesphp.com/)
template engine into the [Silex micro-framework](http://silex.sensiolabs.org/).
It's in the very early stages, so don't be surprised if the integration is less
than optimal.

The project is based very heavily on the default `TwigServiceProvider` and
some of the Symfony-Twig bridge extensions.

Usage
-----

Add the provider to your `composer.json` file:

```json
{
    "require": {
        "rych/silex-plates-provider": "1.0.*"
    }
}
```

Enable it in your application:

```php
<?php

/* @var $app Silex\Application */
$app->register(new \Rych\Silex\Provider\PlatesServiceProvider(), array (
    'plates.path' => '/path/to/templates', // Required
    'plates.folders' => array (            // Optional
        'email' => '/path/to/email/templates';
    ),
));

$app->get('/', function () use ($app) {
    return $app['plates']->render('mytemplate');
});

```

Extensions
----------

This provider also registers common extensions which work very similar to
those found in the Symfony-Twig bridge. I hope to add more in the future, but
right now I've only included the big ones I use regularly.

### Routing Extension ###

Provides the `url` and `path` functions for generating URIs. This extension is
only available if `UrlGeneratorServiceProvider` is registered.

### Security Extension ###

Provides the `is_granted` function. This extension is only available if
`SecurityServiceProvider` is registered.

Custom Extensions
-----------------

You may choose to register your own Plates extensions. This can be accomplished
easily by extending the `plates.engine` service.

```php
<?php

/* @var $app Silex\Application */
$app['plates.engine'] = $app->share($app->extend('plates.engine', function($engine, $app) {
    $engine->addExtension(new \My_Plates_Extension());

    return $engine;
}));

```
