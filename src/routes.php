<?php
declare(strict_types=1);

namespace App;

use App\Controllers\AuthController;
use App\Controllers\UsuarioController;
use App\Repository\BaseRepository;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

class Routes {

  private $app;

  public function __construct(&$app) {
    $this->app = $app;
  }

  public function addRoutes() {
    $container = $this->app->getContainer();

    $this->app->get('/', function(Request $request, Response $response) {
        return $response;
    });

    $this->app->options('/{routes:.+}', function ($request, $response, $args) {
      return $response;
    });

    $this->app->add(function ($request, $handler) {
      $response = $handler->handle($request);
      return $response
              ->withHeader('Access-Control-Allow-Origin', 'http://localhost')
              ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
              ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    /** AUTHENTICATION */
    $this->app->post('/auth', function(Request $request, Response $response, $args) use($container) {
      $body = json_decode($request->getBody()->getContents(), true);

      $auth = new AuthController();
      $auth->setSecret(getenv('JWT_SECRET'));
      $auth->setUsuario($body['usuario']);
      $auth->setSenha($body['senha']);
      if($oUsuario = $auth->login()) {
        $jwt = $auth->refreshToken();
        $auth->refreshTokenUsuario($oUsuario, $jwt);
        $response->getBody()->write(json_encode(['auth-jwt' => $jwt]));
        return $response->withHeader('Content-type', 'application/json');
      }
      $response->getBody()->write(json_encode(['msg' => 'Usuário ou senha inválidos']));
      return $response->withHeader('Content-type', 'application/json')->withStatus(401);
    });

    /** USERS */
    $this->app->get('/v1/usuarios', function(Request $request, Response $response, $args) {
      $usuarios = BaseRepository::getEntityManager()->getRepository('App\Models\Usuario')->findAll();
      $usuariosJson = array_map(function($usuario){
        return $usuario->jsonSerialize();
      }, $usuarios);
      $response->getBody()->write(json_encode($usuariosJson));
      return $response->withHeader('Content-type', 'application/json')->withStatus(200);
    });

    $this->app->get('/v1/usuarios/{id}', function(Request $request, Response $response, $args) {
      $usuario = BaseRepository::getEntityManager()->getRepository('App\Models\Usuario')->find($args['id']);
      $response->getBody()->write(json_encode($usuario->jsonSerialize()));
      return $response->withHeader('Content-type', 'application/json')->withStatus(200);
    });

    $this->app->post('/v1/usuarios', function(Request $request, Response $response, $args) {
      $body = json_decode($request->getBody()->getContents(), true);
      $usuarioController = new UsuarioController();
      
      return $response->withHeader('Content-type', 'application/json')->withStatus(200);
    });

    $this->app->delete('/v1/usuarios/{id}', function(Request $request, Response $response, $args) {
      $em = BaseRepository::getEntityManager();
      $usuario = $em->getRepository('App\Models\Usuario')->find($args['id']);
      try {
        $em->remove($usuario);
        $em->flush();
        $response->getBody()->write(json_encode(['msg' => 'Usuário removido com sucesso']));
        return $response->withHeader('Content-type', 'application/json')->withStatus(200);
      } catch(Exception $e) {
        return $response->withHeader('Content-type', 'application/json')->withStatus(500);
      }
      
    });
    
  }
}
