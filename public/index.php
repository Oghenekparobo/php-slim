<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$container->set('templating', function() {
    return new Mustache_Engine([
        'loader' => new Mustache_Loader_FilesystemLoader(
            __DIR__ . '/../templates',
            ['extension' => '']
        )
    ]);
});

$container->set('session', function() {
    return new \SlimSession\Helper();
  });

AppFactory::setContainer($container);

$app = AppFactory::create();
$app->add(new \Slim\Middleware\Session);


$app->any('/', '\App\Controller\AuthController:login');
$app->get('/logout', '\App\Controller\AuthController:logout');
// $app->get('/secure', '\App\Controller\SecureController:default')->add(new \App\Middleware\Authenticate($app->getContainer()->get('session')));
// $app->get('/', '\App\Controller\SearchController:default');
// $app->get('/search', '\App\Controller\SearchController:search');
// $app->any('/form', '\App\Controller\SearchController:form');
// $app->get('/api', '\App\Controller\ApiController:search');
// $app->get('/bikes', '\App\Controller\ShopController:default');
// $app->get('/details/{id:[0-9]+}', '\App\Controller\ShopController:details');

$app->group('/secure', function($app) {
    $app->get('', '\App\Controller\SecureController:default');
    $app->get('/status', '\App\Controller\SecureController:status');
})->add(new \App\Middleware\Authenticate($app->getContainer()->get('session')));


$app->run();