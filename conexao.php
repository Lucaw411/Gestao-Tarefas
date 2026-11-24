<?php
require_once __DIR__ . '/assets/class/rb.php';
R::setup(
    'mysql:host=127.0.0.1;dbname=gestao_tarefas;charset=utf8mb4',
    'root',
    'aluno'
);

if (!R::testConnection()) {
    die('Não foi possível conectar ao banco de dados. Verifique o MySQL e as credenciais em conexao.php.');
}

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax'
    ]);
    session_start();
}
