<?php
include 'Util/database.php';


class AdsDAO {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getActiveAd() {
        $query = "SELECT * FROM ads WHERE active = 1 ORDER BY created_at DESC LIMIT 1";
        return $this->db->select($query);
    }

    public function getAllAds() {
        $query = "SELECT * FROM ads ORDER BY id DESC";
        return $this->db->select($query);
    }

    public function addAd($title, $image_url, $target_url) {
        $title = mysqli_real_escape_string($this->db->link, $title);
        $image_url = mysqli_real_escape_string($this->db->link, $image_url);
        $target_url = mysqli_real_escape_string($this->db->link, $target_url);

        $query = "INSERT INTO ads (title, image_url, target_url) VALUES ('$title', '$image_url', '$target_url')";
        return $this->db->insert($query);
    }

    public function updateAd($id, $title, $image_url, $target_url, $active) {
        $query = "UPDATE ads SET title='$title', image_url='$image_url', target_url='$target_url', active=$active WHERE id=$id";
        return $this->db->update($query);
    }

    public function deleteAd($id) {
        $query = "DELETE FROM ads WHERE id = $id";
        return $this->db->delete($query);
    }
}
?>
