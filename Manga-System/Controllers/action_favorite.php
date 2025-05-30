<?php
session_start();
include '../Model/favorite.php';

if (!isset($_SESSION['user_id'])) {
    header("location: ../View/login.php?error=Please login to manage favorites");
    exit();
}

$favorite = new Favorite();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comic_id'])) {
        $comic_id = intval($_POST['comic_id']);
        $from_page = $_POST['from_page'] ?? ''; // Optional source page

        // Toggle favorite
        if ($favorite->isFavorited($user_id, $comic_id)) {
            $favorite->removeFavorite($user_id, $comic_id);
        } else {
            $favorite->addFavorite($user_id, $comic_id);
        }

        // Redirect based on where the request came from
        if ($from_page === 'favorites') {
            header("location: ../View/favorites.php");
        } else {
            header("location: ../View/mangaInfo.php?id=$comic_id");
        }
        exit();
    }
}
