<?php
require 'config.php';
require 'GoogleBooks.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$booksApi = new GoogleBooks();
$books = [];
$message = '';

// Manejo de la búsqueda de libros
if (isset($_GET['search'])) {
    $query = $_GET['search'];
    $books = $booksApi->searchBooks($query)['items'] ?? [];
}

// Manejo del guardado de libros
if (isset($_POST['save_book'])) {
    $bookId = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $thumbnail = $_POST['thumbnail'];
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO libros_guardados (user_id, google_books_id, titulo, autor, imagen_portada, fecha_guardado) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$userId, $bookId, $title, $author, $thumbnail]);
    $message = "Libro guardado en tus favoritos.";
}

//  eliminación de libros
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM libros_guardados WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    $message = "Libro eliminado de tus favoritos.";
}

// Obtener los libros guardados del usuario
$stmt = $pdo->prepare("SELECT * FROM libros_guardados WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$savedBooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Biblioteca</title>
</head>
<body>
    <h1>Bienvenido a tu Biblioteca</h1>
    <p><a href="logout.php">Cerrar sesión</a></p>

    <form method="GET" action="biblioteca.php">
        <input type="text" name="search" placeholder="Buscar libros">
        <button type="submit">Buscar</button>
    </form>

    <?php if ($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <?php if (!empty($books)): ?>
        <h2>Resultados de la búsqueda</h2>
        <ul>
            <?php foreach ($books as $book): 
                $volumeInfo = $book['volumeInfo'];
                $title = $volumeInfo['title'] ?? 'Título no disponible';
                $author = $volumeInfo['authors'][0] ?? 'Autor no disponible';
                $thumbnail = $volumeInfo['imageLinks']['thumbnail'] ?? '';
            ?>
            <li>
                <img src="<?= $thumbnail ?>" alt="Portada">
                <h3><?= $title ?></h3>
                <p><?= $author ?></p>
                <form method="POST" action="biblioteca.php">
                    <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                    <input type="hidden" name="title" value="<?= $title ?>">
                    <input type="hidden" name="author" value="<?= $author ?>">
                    <input type="hidden" name="thumbnail" value="<?= $thumbnail ?>">
                    <button type="submit" name="save_book">Guardar en favoritos</button>
                </form>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>Mis Libros Favoritos</h2>
    <ul>
        <?php foreach ($savedBooks as $savedBook): ?>
            <li>
                <img src="<?= $savedBook['imagen_portada'] ?>" alt="Portada">
                <h3><?= $savedBook['titulo'] ?></h3>
                <p><?= $savedBook['autor'] ?></p>
                <a href="biblioteca.php?delete=<?= $savedBook['id'] ?>">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
