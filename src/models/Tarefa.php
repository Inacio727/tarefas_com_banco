<?php

namespace App\models;

class Tarefa
{
    private ?int $id = null;
    private string $titulo = "";
    private string $descricao = "";
    private bool $status = false;
    private int $user_id = 0;
}