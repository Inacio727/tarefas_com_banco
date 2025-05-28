<?php
namespace App\models;

Class Usuario
{
    public ?int $id = null;
    public string $nome = '';
    public string $login = '';
    public string $senha = '';
    public string $email = '';
    public string $foto_path = '';

    // criar a propriedade da conexão igual à classe tarefa
    // Criar o método construtor igual à tarefa
    // criar os métodos create findById, update e delete para gerenciar os usuários
}