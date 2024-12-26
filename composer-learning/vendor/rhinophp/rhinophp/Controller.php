<?php

/**
 */

namespace rhinophp\rhinophp;

use rhinophp\rhinophp\middlewares\BaseMiddleware;

/**
 * Class Controller
 *
 */
class Controller
{
  public string $layout = 'main';
  public string $action = '';

  /**
   * @var \rhinophp\rhinophp\BaseMiddleware[]
   */
  protected array $middlewares = [];

  public function setLayout($layout): void
  {
    $this->layout = $layout;
  }

  public function render($view, $params = []): string
  {
    return Application::$app->router->renderView($view, $params);
  }

  public function registerMiddleware(BaseMiddleware $middleware)
  {
    $this->middlewares[] = $middleware;
  }

  /**
   * @return \rhinophp\rhinophp\middlewares\BaseMiddleware[]
   */
  public function getMiddlewares(): array
  {
    return $this->middlewares;
  }
}