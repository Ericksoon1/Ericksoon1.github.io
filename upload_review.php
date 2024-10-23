<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Reseña</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="upload_review">
    <header>
        <h1>Subir Nueva Reseña</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="reviews.php">Reseñas</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <form method="POST" action="upload_review.php" enctype="multipart/form-data">
            <label for="title">Título del Juego:</label>
            <input type="text" name="title" required>
            
            <label for="review_text">Reseña:</label>
            <textarea name="review_text" required></textarea>
            
            <label for="image">Imagen del Juego:</label>
            <input type="file" name="image" required accept="image/*">
            
            <button type="submit">Subir Reseña</button>
        </form>
    </section>
</body>
</html>

<?php
session_start();
include 'conexion.php'; 

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que los campos requeridos no estén vacíos
    if (!empty($_POST['title']) && !empty($_POST['review_text']) && !empty($_FILES['image']['name'])) {
        
        // Capturar los datos del formulario
        $title = $_POST['title'];
        $review_text = $_POST['review_text'];
        $image = $_FILES['image']['name'];
        $target_dir = "images/";
        $target_file = $target_dir . basename($image);

        // Mover la imagen a la carpeta indicada
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            echo "La imagen se cargó correctamente en " . $target_file . "<br>";
        } else {
            echo "Error al subir la imagen.";
        }

        // Capturar el ID del usuario desde la sesión
        $user_id = $_SESSION['user_id'];
        
        // Insertar los datos en la base de datos
        $query = "INSERT INTO dbo.reviews (title, review_text, imagen, user_id) VALUES (?, ?, ?, ?)";
        $params = array($title, $review_text, $image, $user_id);

        // Ejecutar la consulta
        $stmt = sqlsrv_query($conexion, $query, $params);

        if ($stmt === false) {
            // Mostrar el error si falla la inserción
            echo "Error al subir la reseña: ";
            die(print_r(sqlsrv_errors(), true)); // Mostrar errores de SQL Server
        } else {
            echo "Reseña subida correctamente.";
            // Redireccionar a la página de reseñas
            header('Location: reviews.php');
            exit();
        }
    } else {
        // Si alguno de los campos está vacío, mostrar un mensaje
        echo "Por favor, rellena todos los campos.";
    }
}
?>
