<?php
// Conectar a la base de datos
include 'conexion.php';
 
// Consultar todas las reseñas de la base de datos
$query = "SELECT title, review_text, imagen FROM reviews";
$result = mysqli_query($conexion, $query);
?>
 
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
        // Verificar si hay reseñas disponibles
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $titulo = $row['title'];
                $contenido = $row['review_text'];
                $imagen = $row['imagen'];
 
                echo "<div class='review-container'>";
                // Sección del texto
                echo "<div class='review-text'>";
                echo "<h1>" . htmlspecialchars($titulo) . "</h1>";
                echo "<p>" . nl2br(htmlspecialchars($contenido)) . "</p>";
                echo "</div>";
 
                // Sección de la imagen
                if ($imagen) {
                    echo "<div class='review-image'>";
                    echo "<img src='" . htmlspecialchars($imagen) . "' alt='" . htmlspecialchars($titulo) . "' style='width:300px; height:auto;'>";
                    echo "</div>";
                }
 
                echo "</div>"; // Cierra review-container
            }
        } else {
            echo "<p>No hay reseñas disponibles.</p>";
        }
        ?>
    </section>
 
    <footer>
        <p>&copy; 2024 Reseñas de Videojuegos</p>
    </footer>
</body>
</html>
 