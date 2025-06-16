<?php
session_start();
include 'conexão.php';

if (isset($_POST['cadastrar'])) {
    // 1. Recebe e limpa dados
    $nome  = trim($_POST['Nome']);
    $senha = trim($_POST['Senha']);

    // 2. Consulta preparada
    $sql = "SELECT Nome FROM usuario WHERE Nome = ? AND Senha = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ss', $nome, $senha);
        $stmt->execute();
        $stmt->store_result();

        // 3. Verifica existência
        if ($stmt->num_rows === 1) {
            // Regenera ID da sessão e salva dados
            session_regenerate_id(true);
            $_SESSION['Nome']            = $nome;
            $_SESSION['ULTIMA_ATIVIDADE']= time();

            header("Location: index.php");
            exit;
        }
        $stmt->close();
    }
    // Se falhar, volta ao login com erro
    header("Location: login.html?error=1");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GT Stats - Cadastro</title>
    <link rel="shortcut icon" href="IMG/logo.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Navbar com logo centralizada e fundo preto -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand" href="index.php">
                <img src="IMG/logo.jpg" alt="Logo" style="height: 50px; width: auto;">
            </a>
        </div>
    </nav>

    <!-- Seção com formulário centralizado -->
    <section class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 70px);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 border border-primary rounded p-4 bg-light">
                    <h2 class="text-center mb-4">Login</h2>
                    <form action="login.php" method="post">
                        <div class="mb-3">
                            <input type="text" class="form-control border-primary" placeholder="Nome" name="Nome" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control border-primary" placeholder="Senha" name="Senha" required>
                        </div>
                        <button type="submit" name="cadastrar" class="btn btn-primary w-100">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
