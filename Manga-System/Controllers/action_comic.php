<?php
include "../Model/comic.php";
$comic = new Comic();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['add'])) {
        $title = $_POST['title'];
        $cover = $_POST['cover'];
        $status = $_POST['status'];
        $origination = $_POST['origination'];
        $published_year = $_POST['published_year'];
        $description = $_POST['description'];
        $chapters = $_POST['chapters'];
        $artists = $_POST['artists'];
        $genres = $_POST['genres'];
        $themes = $_POST['themes'];
        $format = $_POST['format'];
        $publishers = $_POST['publishers'];

        $result_add = $comic->addComic(
            $title,
            $cover,
            $status,
            $origination,
            $published_year,
            $description,
            $chapters,
            $artists,
            $genres,
            $themes,
            $format,
            $publishers
        );

        if ($result_add) {
            header("Location: ../View/AdminListComics.php");
            exit();
        }
    } else if (isset($_POST['edit'])) {
        $comic_id = $_POST['comic_id'];
        $title = $_POST['title'];
        $cover = $_POST['cover'];
        $status = $_POST['status'];
        $origination = $_POST['origination'];
        $published_year = $_POST['published_year'];
        $description = $_POST['description'];
        $chapters = $_POST['chapters'];
        $artists = $_POST['artists'];
        $genres = $_POST['genres'];
        $themes = $_POST['themes'];
        $format = $_POST['format'];
        $publishers = $_POST['publishers'];


        $result_add = $comic->editComic(
            $comic_id,
            $title,
            $cover,
            $status,
            $origination,
            $published_year,
            $description,
            $chapters,
            $artists,
            $genres,
            $themes,
            $format,
            $publishers
        );

        if ($result_add) {
            header("Location: ../View/adminListComics.php");
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['delete'])) {
        $get_id = $_GET['delete'];

        $result = $comic->deleteComic($get_id);

        if ($result) {
            header("Location: ../View/adminListComics.php");
            exit();
        }
    }
}
