<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas de Videojuegos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Reseñas Disponibles</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="reviews.php">Reseñas</a></li>
                <li><a href="login.php">Iniciar Sesión</a></li>
                <li><a href="register.php">Registrarse</a></li>
                <li><a href="upload_review.php">Subir reseña</a></li>
            </ul>
        </nav>
    </header>
 
    <section id="reviews-section">
<?php

include 'conexion.php';  

// Preparar la consulta
$query = "SELECT title, review_text, imagen FROM dbo.reviews";
$stmt = sqlsrv_query($conexion, $query);

if ($stmt === false) {
    // Si hay un error, mostrar el mensaje correspondiente
    die(print_r(sqlsrv_errors(), true));
}

// Recorrer los resultados de la consulta
if (sqlsrv_has_rows($stmt)) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $titulo = $row['title'];
        $contenido = $row['review_text'];
        $imagen = $row['imagen'];

        echo "<div class='review-container'>";

        echo "<div class='review-text'>";
        echo "<h1>" . htmlspecialchars($titulo) . "</h1>";
        echo "<p>" . nl2br(htmlspecialchars($contenido)) . "</p>";
        echo "</div>";

        // Mostrar la imagen si existe
        if ($imagen) {
            // Ruta completa para las imágenes almacenadas en Azure
            $ruta_imagen = "https://iranomas-b7grghffdfbxd0ap.scm.canadacentral-01.azurewebsites.net/wwwroot/images/" . htmlspecialchars($imagen);
            echo "<div class='review-image'>";
            echo "<img src='" . $ruta_imagen . "' alt='" . htmlspecialchars($titulo) . "' style='width:300px; height:auto;'>";
            echo "</div>";
        }

        echo "</div>"; 
    }
} else {
    echo "<p>No hay reseñas disponibles.</p>";
}

// Cerrar el recurso de la consulta
sqlsrv_free_stmt($stmt);
?>
    </section>
 
    <footer>
        <p>&copy; 2024 Reseñas de Videojuegos</p>
    </footer>
</body>
</html>
