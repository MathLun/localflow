<?php

namespace App\Core\Routing;

class Router
{
    private array $routes = [];
    private array $container = [];

    public function get(string $uri, array $action): void
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, array $action): void
    {
	$this->routes['POST'][$uri] = $action;
    }

    public function bind(
	    string $controller,
	    callable $factory
    ): void {
	    $this->container[$controller] = $factory;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $action = $this->routes[$method][$uri] ?? null;

        if (!$action) {
            http_response_code(404);
            echo 'Not Found';
            return;
        }

        [$controller, $method] = $action;

	if (!isset($this->container[$controller]))
	{
		$instance = new $controller();
	} else {
		$instance = $this->container[$controller]();
	}

	$body = json_decode(file_get_contents('php://input'), true) ?? [];

	$response = $instance->$method($body);

	echo json_encode($response);
    }
}
