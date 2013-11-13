<?php

namespace Rych\Tests\Silex\Provider;

use Silex\Application;
use Rych\Silex\Provider\PlatesServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class PlatesServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testRegisterAndRender()
    {
        $app = new Application();

        $app->register(new PlatesServiceProvider(), array(
            'plates.path'    => __DIR__ . '/../../../../Resources/views',
        ));

        $app->get('/hello/{name}', function ($name) use ($app) {
            return $app['plates']->render('hello', array ('name' => $name));
        });

        $request = Request::create('/hello/john');
        $response = $app->handle($request);
        $this->assertEquals('Hello john!', $response->getContent());
    }

    public function testRenderFolders()
    {
        $app = new Application();

        $app->register(new PlatesServiceProvider(), array(
            'plates.path'    => __DIR__ . '/../../../../Resources/views',
            'plates.folders' => array (
                'email' =>  __DIR__ . '/../../../../Resources/view-folders/email',
            ),
        ));

        $app->get('/email/{name}', function ($name) use ($app) {
            return $app['plates']->render('email::salutations', array ('name' => $name));
        });

        $request = Request::create('/email/john');
        $response = $app->handle($request);
        $this->assertEquals('Dear john,', $response->getContent());
    }

}

