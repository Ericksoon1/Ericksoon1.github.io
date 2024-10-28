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
$connectionOptions = array(
    "Database" => "videojuegos_db",
    "Uid" => "adminsql",
    "PWD" => "junioRyzen3200$"
);


$conn = sqlsrv_connect($serverName, $connectionOptions);


if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $query = "SELECT * FROM dbo.users WHERE username = ?";
    $params = array($username);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; 
        header('Location: index.php');
        exit;
    } else {
        echo "Usuario o contraseña incorrectos.";
    }

    
    sqlsrv_free_stmt($stmt);
}


sqlsrv_close($conn);
?>
