<?php

class LoggerMiddleware extends \Slim\Middleware {

  public function call() {
    $env = $this->app->environment;
    $env['slim.errors'] = fopen(dirname(__FILE__) . '/../www-logs/slim' . date('Y-m-d') . '.log', 'a');
    $this->next->call();
  }

}