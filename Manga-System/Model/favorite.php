<?php
require_once("database.php");

class Favorite
{
    public $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Add to favorites (Like)
    public function addFavorite($user_id, $comic_id)
    {
        $sql = "INSERT INTO tbl_favorites (user_id, comic_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $comic_id);
        return $stmt->execute();
    }

    // Remove from favorites (Unlike)
    public function removeFavorite($user_id, $comic_id)
    {
        $sql = "DELETE FROM tbl_favorites WHERE user_id = ? AND comic_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $comic_id);
        return $stmt->execute();
    }

    // Check if user has favorited a comic
    public function isFavorited($user_id, $comic_id)
    {
        $sql = "SELECT * FROM tbl_favorites WHERE user_id = ? AND comic_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $comic_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Optional: Get all favorites by a user
    public function getUserFavorites($user_id)
    {
        $sql = "SELECT c.* 
            FROM tbl_favorites f
            JOIN tbl_comics c ON f.comic_id = c.comic_id
            WHERE f.user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $comics = [];
        while ($row = $result->fetch_assoc()) {
            $comics[] = $row;
        }

        return $comics;
    }
}
