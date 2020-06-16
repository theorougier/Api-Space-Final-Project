<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
$app = AppFactory::create();
// Add Routing Middleware
$app->addRoutingMiddleware();

$conn = new PDO('mysql:host=spacemoonapi.mysql.eu2.frbit.com;dbname=spacemoonapi', 'spacemoonapi', '.BXC2dn_Q1+0=VfiXzXSMWWJ', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/webdocressources/{id}', function (Request $request, Response $response, $args) use ($conn) {
        $query = $conn->prepare("SELECT id, videoURL, videoName, descritpion FROM webdocressources WHERE id= :id");
        $query->bindValue(':id', $args['id']);
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode([$data]));
        return $response;
});