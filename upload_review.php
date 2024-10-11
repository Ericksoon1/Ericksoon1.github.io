<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'videojuegos_db');
 
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $review_text = $_POST['review_text'];
    $image = $_FILES['image']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($image);
 
    move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file);
 
    $user_id = $_SESSION['user_id'];
    $query = "INSERT INTO reviews (title, review_text, imagen, user_id) VALUES ('$title', '$review_text', '$image', '$user_id')";
    $conn->query($query);
 
    header('Location: reviews.php');
}
?>
 
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
            <input type="file" name="image" required>
            <button type="submit">Subir Reseña</button>
        </form>
    </section>
</body>
</html>
 