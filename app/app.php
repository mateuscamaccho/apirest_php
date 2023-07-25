<?php
// app/App.php

require_once 'responseHandler.php';
class App
{
    public function __construct()
    {
        // Defina a conexão com o banco de dados aqui
        // $db = new PDO('mysql:host=seu_host;dbname=seu_banco_de_dados', 'seu_usuario', 'sua_senha');

        // Roteamento
        $url = isset($_GET['url']) ? $_GET['url'] : '/';
        $url = explode('/', trim($url, '/'));

        if (empty($url[0])) {
            http_response_code(200);
            echo json_encode(['status' => 200, 'message' => 'API is running!']);
            return;
        }

        $controllerName = ucfirst(array_shift($url)) . 'Controller';
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        // Se a URL tiver mais segmentos, o primeiro é considerado o ID do usuário
        $userId = null;
        if (!empty($url[0])) {
            $userId = intval($url[0]);
        }

        $controllerFile = 'app/controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerName();

            if (method_exists($controller, $method)) {
                $data = json_decode(file_get_contents('php://input'), true);

                // Se a URL tiver um ID de usuário, passe-o como parâmetro para o método
                $response = ($userId !== null) ? $controller->$method($userId, $data) : $controller->$method($data);

                echo json_encode($response);
            } else {
                http_response_code(405); // Método não permitido
            }
        } else {
            ResponseHandler::sendErrorResponse(404, 'Route not found. The endpoint you are looking for does not exist.');
        }
    }
}