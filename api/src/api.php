<?php
// a api.php descobre qual método HTTP chegou e chama uma função do controller
// comando para carregar outro arquivo php
// O require indica que aquele arquivo é necessário para o funcionamento daquele código.
// __DIR__ representa o diretório onde está o arquivo PHP atual.
// Carregue uma única vez o arquivo controllers.php que está no mesmo diretório deste arquivo.
require_once __DIR__ . '/controllers.php';
//Superglobal que fornece informações sobre o servidor e a requisição HTTP atual
$method = $_SERVER['REQUEST_METHOD'];//Obtém o método HTTP da requisição atual, como GET, POST, PUT ou DELETE.

match ($method) {
    'GET' => handleGet(),//se method for get, execute handleget
    'POST' => handlePost(),
    'PUT' => handlePut(),
    'PATCH' => handlePatch(),
    'DELETE' => handleDelete(),
    default => handleMethodNotAllowed(),
};