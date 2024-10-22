<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="login">
    <header>
        <h1>Iniciar Sesión</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="register.php">Registrarse</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <form method="POST" action="login.php">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" name="username" required>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </section>
</body>
</html>

<?php
session_start();


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
    $password = $_POST['password'];

    
    $query = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php'); 
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
    
    $stmt->close();
}


$conn->close();
?>
