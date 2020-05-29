<?php
declare(strict_types=1);

use App\Controllers\AuthController;
use Slim\App;
use Tuupola\Http\Factory\ResponseFactory;
use Tuupola\Middleware\JwtAuthentication;

return function (App $app) {

  $app->add(new JwtAuthentication([
    'path' => ['/v1'],
    'passthrough' => ['/auth'],
    'secure' => false,
    'secret' => getenv('JWT_SECRET'),
    "error" => function ($response, $arguments) {
      $data["status"] = "error";
      $data["message"] = $arguments["message"];
      return $response
          ->withHeader("Content-Type", "application/json")
          ->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    },
    'after' => function($response, $params) {
      $oAuthController = new AuthController();
      if(!$oAuthController->tokenExists($params['token'])) {
        return (new ResponseFactory)->createResponse(401, 'Token Expired');
      };
    }
  ]));
};
