<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->get('/orders', function (Request $request, Response $response) {
        $response->getBody()->write('All Orders');
        return $response;
    });

    // $app->get('/orders/{id}', function (Request $request, Response $response, $args) {
    //     $id = $args['id'];
    //     $response->getBody()->write("Order No: $id");
    //     return $response;
    // });

    $app->get('/orders/multiple', function (Request $request, Response $response) {
        $ids = $request->getParsedBody();
        $response->getBody()->write("".gettype($ids));
        // foreach ($ids as $id) {
        //     $response->getBody()->write("Order No: $id<br>");
        // }
        return $response;
    });

    $app->post('/orders', function (Request $request, Response $response) {
        $response->getBody()->write('New Order Created');
        return $response;
    });

    $app->post('/orders/multiple', function (Request $request, Response $response) {
        $response->getBody()->write('Multiple New Orders Created');
        return $response;
    });

    // $app->patch('/orders/{id}', function (Request $request, Response $response, $args) {
    //     $id = $args['id'];
    //     $response->getBody()->write("Order No: $id Updated");
    //     return $response;
    // });

    $app->patch('/orders/multiple', function (Request $request, Response $response) {
        $ids = $request->getBody();
        foreach ($ids as $id) {
            $response->getBody()->write("Order No: $id Updated<br>");
        }
        return $response;
    });

    // $app->delete('/orders/{id}', function (Request $request, Response $response, $args) {
    //     $id = $args['id'];
    //     $response->getBody()->write("Order No: $id Deleted");
    //     return $response;
    // });

    $app->delete('/orders/multiple', function (Request $request, Response $response) {
        $ids = $request->getBody();
        foreach ($ids as $id) {
            $response->getBody()->write("Order No: $id Deleted<br>");
        }
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
