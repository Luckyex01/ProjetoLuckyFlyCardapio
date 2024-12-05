<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Erro ao cadastrar. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - LuckyFly</title>
</head>
<body>
    <h1>Cadastro</h1>
    <form method="POST" action="" onsubmit="return validarFormulario();">
        <label>Nome:</label>
        <input type="text" name="name" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Senha:</label>
        <input type="password" name="password" required>
        <button type="submit">Cadastrar</button>
    </form>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <script>
    function validarFormulario() {
        const email = document.querySelector('[name="email"]').value;
        const senha = document.querySelector('[name="password"]').value;
        if (!email.includes('@')) {
            alert('Insira um e-mail válido.');
            return false;
        }
        if (senha.length < 6) {
            alert('A senha deve ter pelo menos 6 caracteres.');
            return false;
        }
        return true;
    }
    </script>
</body>
</html>
