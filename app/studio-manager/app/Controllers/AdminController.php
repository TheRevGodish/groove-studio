<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\ClientModel;
use App\Helpers\Core\PDOService;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AdminController extends BaseController
{
    //NOTE: Passing the entire container violates the Dependency Inversion Principle and creates a service locator anti-pattern.
    // However, it is a simple and effective way to pass the container to the controller given the small scope of the application and the fact that this application is to be used in a classroom setting where students are not yet familiar with the Dependency Inversion Principle.
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $client_model = new ClientModel($this->container->get(PDOService::class));
        $clients = $client_model->findAll();

        $data = [
            'title' => 'Dashboard admin',
            'clients' => $clients,
        ];

        return $this->render($response, 'adminView.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {

        return $this->render($response, 'errorView.php');
    }
}
