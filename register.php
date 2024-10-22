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
// Configuración del servidor de SQL Server
$serverName = "servidoriranomas.database.windows.net";
$connectionOptions = [
    "Database" => "videojuegos_db",
    "Uid" => "adminsql",
    "PWD" => "junioRyzen3200$"
];

// Conectar a SQL Server usando sqlsrv
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Verificar conexión
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Si se recibe un POST, procesar el registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Preparar la consulta para insertar en la tabla dbo.users
    $query = "INSERT INTO dbo.users (username, email, password) VALUES (?, ?, ?)";
    $params = [$username, $email, $password];

    // Ejecutar la consulta
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt) {
        // Redirigir al login después de un registro exitoso
        header('Location: login.php');
        exit();
    } else {
        echo "Error en la inserción: " . print_r(sqlsrv_errors(), true);
    }
}

// Cerrar la conexión
sqlsrv_close($conn);
?>
