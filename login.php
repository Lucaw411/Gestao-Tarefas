<?php
require_once 'conexao.php';

if (!empty($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$erro = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = $_POST['senha'] ?? '';
    $usuario = R::findOne('usuario', 'email = ?', [$email]);

    if ($usuario && password_verify($senha, $usuario->senha)) {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = (int) $usuario->id;
        $_SESSION['usuario_nome'] = $usuario->nome;
        header('Location: index.php');
        exit;
    }

    $erro = 'E-mail ou senha incorretos.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
<div class="container">
    <header class="topo"><div><h1>Entrar</h1><p class="resumo">Acesse sua lista pessoal de tarefas.</p></div></header>
    <?php if ($erro): ?><p class="erro" role="alert"><?php echo htmlspecialchars($erro); ?></p><?php endif; ?>
    <form method="POST" class="formulario">
        <div class="campo">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required autofocus>
        </div>
        <div class="campo">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <div class="acoes">
            <button type="submit" class="btn">Entrar</button>
            <a class="btn btn-claro" href="cadastro.php">Criar conta</a>
        </div>
    </form>
</div>
</body>
</html>
