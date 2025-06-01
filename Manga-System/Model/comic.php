<?php
require_once("database.php");

class Comic
{
    public $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllComics()
    {
        $sql = "SELECT * FROM tbl_comics";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getComicById($comic_id)
    {
        $sql = "SELECT * FROM tbl_comics WHERE comic_id = ?";
        $query = $this->conn->prepare($sql);
        $query->bind_param("i", $comic_id);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc();
    }

    public function addComic(
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
    ) {
        $sql = "INSERT INTO tbl_comics SET title = ?, cover = ?, status = ?, origination = ?, published_year = ?, description = ?, chapters = ?, artists = ?, genres = ?, themes = ?, format = ?, publishers = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param(
            "ssssisssssss",
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
        return $result->execute();
    }

    public function editComic(
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
    ) {
        $sql = "UPDATE tbl_comics SET title = ?, cover = ?, status = ?, origination = ?, published_year = ?, description = ?, chapters = ?, artists = ?, genres = ?, themes = ?, format = ?, publishers = ? WHERE comic_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param(
            "ssssisssssssi",

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
            $publishers,
            $comic_id
        );
        return $result->execute();
    }

    public function deleteComic($comic_id)
    {
        $sql = "DELETE FROM tbl_comics WHERE comic_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param("i", $comic_id);
        return $result->execute();
    }

    public function getComicsByPage($limit, $offset)
    {
        $sql = "SELECT * FROM tbl_comics LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Also add a method to count total comics for pagination calculation
    public function getTotalComicsCount()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_comics";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}