<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="register">
    <header>
        <h1>Registrarse</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="login.php">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <form method="POST" action="register.php">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" name="username" required>
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <button type="submit">Registrarse</button>
        </form>
    </section>
</body>
</html>

<?php

$serverName = "servidoriranomas.database.windows.net";
$username = "adminsql";
$password = "junioRyzen3200$";
$database = "videojuegos_db";


$conn = new mysqli($serverName, $username, $password, $database);


if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    
    $query = "INSERT INTO dbo.users (username, email, password) VALUES ('$username', '$email', '$password')";
    
    if ($conn->query($query) === TRUE) {
        header('Location: login.php'); 
    } else {
        echo "Error: " . $conn->error;
    }
}


$conn->close();
?>
