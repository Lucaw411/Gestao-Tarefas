<?php
require_once 'conexao.php';
if (!empty($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}
$erro = '';
$nome = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $senha = $_POST['senha'] ?? '';
    $confirmacao = $_POST['confirmacao'] ?? '';

    if ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Informe um nome e um e-mail válido.';
    } elseif (strlen($senha) < 8) {
        $erro = 'A senha deve ter pelo menos 8 caracteres.';
    } elseif ($senha !== $confirmacao) {
        $erro = 'As senhas não coincidem.';
    } elseif (R::findOne('usuario', 'email = ?', [$email])) {
        $erro = 'Este e-mail já está cadastrado.';
    } else {
        $usuario = R::dispense('usuario');
        $usuario->nome = $nome;
        $usuario->email = $email;
        $usuario->senha = password_hash($senha, PASSWORD_DEFAULT);
        $id = R::store($usuario);

        session_regenerate_id(true);
        $_SESSION['usuario_id'] = (int) $id;
        $_SESSION['usuario_nome'] = $nome;

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar conta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
<div class="container">
    <header class="topo"><div><h1>Criar conta</h1><p class="resumo">Cadastre-se para organizar suas tarefas.</p></div></header>
    <?php if ($erro): ?><p class="erro" role="alert"><?php echo htmlspecialchars($erro); ?></p><?php endif; ?>
    <form method="POST" class="formulario">
        <div class="campo">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" maxlength="100" value="<?php echo htmlspecialchars($nome); ?>" required>
        </div>
        <div class="campo">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" maxlength="190" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div class="campo">
            <label for="senha">Senha (mínimo 8 caracteres)</label>
            <input type="password" id="senha" name="senha" minlength="8" required>
        </div>
        <div class="campo">
            <label for="confirmacao">Confirme a senha</label>
            <input type="password" id="confirmacao" name="confirmacao" minlength="8" required>
        </div>
        <div class="acoes">
            <button type="submit" class="btn">Criar conta</button>
            <a class="btn btn-claro" href="login.php">Já tenho uma conta</a>
        </div>
    </form>
</div>
</body>
</html>
