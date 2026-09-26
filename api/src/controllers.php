<?php 
//Função principal: interpretar a requisição e devolver a resposta.
// O controller é, portanto, uma camada que recebe a requisição e coordena o que precisa ser feito, chamando os services e preparando a resposta HTTP.
// Controller recebe a requisição, pega os dados necessários, chama o Service responsável pela operação e devolve a resposta ao cliente.
// carrega um arquivo apenas uma vez. Recebe → pega os dados → chama o Service → responde.
require_once __DIR__ . '/services.php';

function respond(array $result): void //recebe o resultado do Service e monta a resposta HTTP
{
    http_response_code($result['status']); //define o status da resposta http

    if (isset($result['error'])) {
        echo json_encode(['error' => $result['error']]);
    } else {
        echo json_encode($result['data']);
    }
}

function respondServerError(\Throwable $e): void //\Throwable é o tipo usado pelo PHP para representar erros/exceções que podem ser capturados.
{
    // O detalhe do erro vai para o log do servidor, nunca para o cliente.
    error_log((string) $e);

    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}

function readJsonBody(): ?array //lê o JSON do body da requisição, converte para array PHP e retorna o array. Se não for possível obter um array, retorna null.
{
    $input = json_decode(file_get_contents('php://input'), true); //Leia o conteúdo bruto que veio no body dessa requisição.

    return is_array($input) ? $input : null;
}

function handleGet(): void
{
    try {
        respond(getAllUsers());
    } catch (\Throwable $e) {
        respondServerError($e);
    }
}

function handlePost(): void //Pega os dados → cria o usuário → responde ao cliente.
{
    try {
        respond(createUser(readJsonBody()));
    } catch (\Throwable $e) {
        respondServerError($e);
    }
}

function handlePut(): void
{
    try { //$_GET é uma variável especial do PHP que guarda os parâmetros enviados na URL.
        respond(editUser($_GET['id'] ?? null, readJsonBody()));
    } catch (\Throwable $e) {
        respondServerError($e);
    }
}

function handlePatch(): void
{
    try {
        respond(editUser($_GET['id'] ?? null, readJsonBody(), partial: true));
    } catch (\Throwable $e) {
        respondServerError($e);
    }
}

function handleDelete(): void
{
    try {
        respond(removeUser($_GET['id'] ?? null));
    } catch (\Throwable $e) {
        respondServerError($e);
    }
}

function handleMethodNotAllowed(): void
{
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}