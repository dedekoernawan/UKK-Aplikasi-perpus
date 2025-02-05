<?php
include "../db/koneksi.php";
session_start();

$books = $_SESSION['books'] ?? [
    ['id' => 1, 'title' => 'Belajar PHP', 'author' => 'John Doe'],
    ['id' => 2, 'title' => 'Dasar-Dasar MySQL', 'author' => 'Jane Smith'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $id = count($books) + 1;
        $title = $_POST['title'] ?? '';
        $author = $_POST['author'] ?? '';
        $books[] = ['id' => $id, 'title' => $title, 'author' => $author];

    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        foreach ($books as &$book) {
            if ($book['id'] === $id) {
                $book['title'] = $_POST['title'] ?? $book['title'];
                $book['author'] = $_POST['author'] ?? $book['author'];
                break;
            }
        }

    } elseif ($action === 'delete') {
        $id = (int)$_POST['id'];
        $books = array_filter($books, fn($book) => $book['id'] !== $id);
    }
    $_SESSION['books'] = $books;
    header("Location: manage_books.php");
    exit;
}
?>