<?php
// Todo request entra por aqui. Este arquivo faz três coisas, nesta ordem: (1) aplica os headers de CORS, (2) responde ao preflight OPTIONS, e (3) roteia pela URL.
require_once __DIR__ . '/../config/config.php';
//array superglobal contem inf sobre a requisicao e servidor
$origin = $_SERVER['HTTP_ORIGIN'] ?? ''; //pega o valor do header Origin da requisição

in_array($origin, $allowedOrigins) ? //verifica se $origin está dentro da lista de origens permitidas
    header("Access-Control-Allow-Origin: $origin") : null; //Se $origin estiver na lista → manda o header Access-Control-Allow-Origin liberando especificamente aquela origem.
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS'); //Define quais métodos HTTP são permitidos pelo CORS para essa API.
header('Access-Control-Allow-Headers: Content-Type'); //Permite que a requisição envie o header Content-Type.
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { //checagem de permniçao OPTIONS = método HTTP usado pelo navegador para verificar permissões antes de certas requisições
    http_response_code(204);
    exit;
}

$uri = strtok($_SERVER['REQUEST_URI'], '?'); //corta a string no primeiro caractere ? que encontrar, e devolve só a parte antes dele, uri é o caminho /api/users

match ($uri) { //Se $uri for exatamente /api/users → carrega o arquivo api.php (que trata GET/POST/etc.)
    '/api/users' => require __DIR__ . '/../src/api.php',
    default => notFound(),
};

function notFound(): void
{
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
}
