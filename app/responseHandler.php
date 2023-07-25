<?php
class ResponseHandler
{
    public static function sendErrorResponse($status, $message)
    {
        http_response_code($status);
        $response = ['error' => $status, 'message' => $message];
        echo json_encode($response);
        exit; // Encerrar a execução do script para evitar respostas duplicadas
    }
}