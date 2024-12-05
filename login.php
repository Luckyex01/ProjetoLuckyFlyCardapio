<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Senha incorreta.";
        }
    } else {
        $error = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - LuckyFly</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="">
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Senha:</label>
        <input type="password" name="password" required>
        <button type="submit">Entrar</button>
    </form>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <p><a href="register.php">Cadastre-se</a></p>
</body>
</html>
