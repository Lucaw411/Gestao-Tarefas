<?php
require_once __DIR__ . '/conexao.php';
function exigirLogin(): void
{
    if (empty($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }
}

function usuarioAtualId(): int
{
    return (int) ($_SESSION['usuario_id'] ?? 0);
}
