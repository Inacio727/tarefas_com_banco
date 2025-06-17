<?php
 
use App\Database\Mariadb;
use App\Models\Tarefa;
use App\Models\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
 
require __DIR__ . './vendor/autoload.php'; // se der erro, use __DIR__ . '/vendor/autoload.php';
 
 
$app = AppFactory::create();
$banco = new Mariadb();
   
 
 
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (
    Request $request,
    Throwable $expection,
    bool $diplayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app) {
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write('{"error": "abacaxi com pimenta!"}');
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});
$app->addErrorMiddleware(true, true, true);
 
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('<a href="/hello/world">Try /hello/world</a>');
    return $response;
});
 
 
$app->get('/usuario/{id}/tarefas', function (Request $request, Response $response, $args) use ($banco) {
    $user_id = $args['id'];
    $tarefa = new Tarefa($banco->getConnection());
    $tarefas = $tarefa->getAllByUser($user_id);
    $response->getBody()->write(json_encode($tarefas));
    return $response;
});
 
 
$app->get('/usuario/{id}', function (Request $request, Response $response, $args) use ($banco) {
    $user_id = $args['id'];
    $usuario = new Usuario($banco->getConnection());
    $usuarios = $usuario->getByuserID($user_id) ?? [];
 
    $response->getBody()->write(json_encode($usuarios));
    return $response->withHeader('Content-Type','application/json');
});
 
 
$app->delete('/usuario/{id}', function (Request $request, Response $response, $args) use ($banco) {
  $user_id = $args['id'];
  $usuario = new Usuario($banco->getConnection());
  $usuarios = $usuario->deleteUser($user_id) ?? [];
 
  $response->getBody()->write(json_encode($usuarios));
  return $response->withHeader('Content-Type','application/json');
});
 
 
 
 
$app->post('/usuario',
  function (Request $request, Response $response, array $args) use ($banco){
    $campos_obrigatorios = ['nome',"login",'senha',"email"];
    $body = $request->getParsedBody();
    try{
      $usuario = new Usuario($banco->getConnection());
      $usuario->nome = $body["nome"] ?? '';
      $usuario->email = $body["email"] ?? '';
      $usuario->senha = $body["senha"] ?? '';
      $usuario->login = $body["login"] ?? '';
      $usuario->foto_path = $body["foto_path"] ?? '';
      foreach($campos_obrigatorios as $campo){
        if(empty($usuario->{$campo})){
          throw new \Exception("o campo {$campo} é obrigatório");
        };
      }
      $usuario->createUser();
    }catch(\Exception $e){
      $response->getBody()->write(json_encode(['massage' => $e->getMessage() ]));
      return $response->withHeader('Content-Type','application/json') ->withStatus(400);
    }
    $response->getBody()->write(json_encode([
      'message' => 'Usuario cadastrado com sucesso'
    ]));
    return $response->withHeader('Content-Type','application/json');
  });
 
 
 
 
 
$app->run();