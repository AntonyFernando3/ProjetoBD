<?php
include_once "conexao.php"; 
session_start();

if(isset($_POST['login'])){
    $username = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM administrador WHERE username = '$username' AND senha = '$senha'";
    $resultado = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($resultado);

    if($row) {
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit;
    } else {
        echo "<h3>Credenciais inválidas</h3>";
    }
}

if(isset($_GET['erro'])){
    $erro = 'É necessário fazer login para acessar o sistema';
}
?>

<div style="background-color: coral;">
    <?php echo $erro ?? '' ?>
</div>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo.png" type="imagem/x-icon">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Login Administrador</title>
</head>
<body>
    <br><br><br>

    <div class="logoindex">
        <center>
            <img src="logo.png">
            <h1>Register Product</h1>
            <h3>LOGIN ADMINISTRADORES</h3>
        </center>
    </div>

    <div class="formulario">
        <form action="" method="post">
            <input type="text" name="usuario" placeholder="Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="submit" name="login" value="Login">
        </form>
    </div>


    <center>
        <h4>ADMINISTRADOR <br> Login: antonyfernando | Senha: 2023</h4>
    </center>

</body>
</html>
