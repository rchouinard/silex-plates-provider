Plates Template Engine for Silex
================================

This project aims to provide integration of the [Plates](http://platesphp.com/)
template engine into the [Silex micro-framework](http://silex.sensiolabs.org/).

This project is in the very early stages, so don't be surprised if the
integration is less than optimal.

This project is based very heavily on the default TwigServiceProvider and
the Symfony-Twig bridge Twig extensions.

Usage
-----

```php
<?php

/* @var $app Silex\Application */
$app->register(new \Rych\Silex\Provider\PlatesServiceProvider(), array (
    'plates.path' => '/path/to/templates', // Required
    'plates.folders' => array (            // Optional
        'email' => '/path/to/email/templates';
    ),
));

```

Extensions
----------

This provider also registers common extensions which work very similar to
those found in the Symfony-Twig bridge. I hope to add more in the future, but
right now I've only included the big ones I use regularly.

=== Routing Extension ===

Provides the `url` and `path` functions for generating URIs. This extension is
only available if the url_generator service is available.

=== Security Extension ===

Provides the `is_granted` function. This extension is only available if the
security service is available.

Custom Extensions
-----------------

You may choose to register your own Plates extensions. This can be accomplished
easily by extending the plates service.

```php
<?php

/* @var $app Silex\Application */
$app['plates'] = $app->share($app->extend('plates', function($plates, $app) {
    $plates->addExtension(new \My_Plates_Extension());

    return $plates;
}));

```
