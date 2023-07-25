<?php

require_once __DIR__ . '/../ResponseHandler.php';

class UserController
{
    // GET
    public function get($userId = null)
    {
        // verificar se foi passado o parametro search via query params
        $search = isset($_GET['search']) ? $_GET['search'] : null;

        if($search !== null){
            $users = $this->searchUsersByName($search);
            return $users;
        }else{
            $users = $this->getAllUsers();
            return $users;
        }
    }

    private function searchUsersByName($name) {
        // Implementar a lógica de busca de usuários pelo nome no banco de dados
        // Exemplo de simulação:
        $allUsers = $this->getAllUsers();

        // Filtrar apenas os usuários cujo nome contenha a string fornecida
        $filteredUsers = array_filter($allUsers, function ($user) use ($name) {
            return stripos($user['name'], $name) !== false;
        });

        return array_values($filteredUsers); // Reindexar o array para evitar índices numéricos não sequenciais
    }


    private function getAllUsers() {
        $users = [
            ['id' => 1, 'name' => 'João', 'email' => 'joao@example.com'],
            ['id' => 2, 'name' => 'Maria', 'email' => 'maria@example.com'],
            ['id' => 3, 'name' => 'Pedro', 'email' => 'pedro@example.com'],
            ['id' => 4, 'name' => 'João da Silva', 'email' => 'joao.silva@example.com'],
        ];
        return $users;
    }

    // POST

    public function post($data)
    {
        // Aqui você implementaria a lógica para criar um novo usuário no banco de dados
        // $data conterá os dados enviados no corpo da requisição (formato JSON)
        // Após criar o usuário, retorne os dados do usuário criado em formato JSON\

        if (empty($data['name']) || empty($data['email'])) {
            ResponseHandler::sendErrorResponse(400, 'Parâmetros ausentes. Os campos "name" e "email" são obrigatórios.');
        }

        $newUser = ['id' => 4, 'name' => $data['name'], 'email' => $data['email']];
        return $newUser;
    }

    public function put($userId, $data)
    {
        // Aqui você implementaria a lógica para atualizar as informações do usuário com o ID fornecido
        // $data conterá os dados enviados no corpo da requisição (formato JSON)
        // Após atualizar o usuário, retorne os dados do usuário atualizado em formato JSON
        $updatedUser = ['id' => $userId, 'name' => $data['name'], 'email' => $data['email']];
        return json_encode($updatedUser);
    }

    public function delete($userId)
    {
        // Aqui você implementaria a lógica para excluir o usuário com o ID fornecido
        // Retorne uma resposta JSON informando se o usuário foi excluído com sucesso ou não
        $response = ['success' => true, 'message' => "Usuário com ID $userId excluído com sucesso."];
        return json_encode($response);
    }
}