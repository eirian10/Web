<?php 
require_once __DIR__ . '/../Util/database.php';

?>
<?php
class AdminSongDAO {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function ShowListSong() {
        $query = "SELECT id_baihat, casi.tenCaSi, tenbaihat, theloai, luotnghe, album, linknhac, ngheSi, moTa FROM `baihat`, `casi` WHERE baihat.id_casi = casi.id_casi;";
        $result = $this->db->select($query);
        return $result;
    }

    public function GetSongById($id_song) {
        $query = "SELECT * FROM `baihat` WHERE id_baihat = $id_song";
        $result = $this->db->select($query);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
    }

    public function UpdateSongById($tenbaihat, $theloai, $album, $linknhac, $ngheSi, $moTa, $id_casi, $id_song) {
        $query = "UPDATE `baihat` SET 
        tenbaihat='$tenbaihat', 
        theloai='$theloai', 
        album='$album', 
        linknhac='$linknhac', 
        ngheSi='$ngheSi', 
        moTa='$moTa',
        id_casi='$id_casi' 
        WHERE id_baihat=$id_song";

        $result = $this->db->update($query);
        return $result > 0;
    }

    public function DeleteSongById($id_song) {
        $query = "DELETE FROM `baihat` WHERE id_baihat = $id_song";
        $result = $this->db->delete($query);
        return $result > 0;
    }

    public function GetAllArtists() {
        $query = "SELECT id_casi, tenCaSi FROM `casi`";
        return $this->db->select($query);
    }

public function AddSong($tenbaihat, $id_casi, $theloai, $album, $linknhac, $ngheSi, $moTa) {
    $query = "INSERT INTO `baihat` (tenbaihat, id_casi, theloai, album, linknhac, ngheSi, moTa) VALUES ('$tenbaihat', '$id_casi', '$theloai', '$album', '$linknhac', '$ngheSi', '$moTa')";
    $result = $this->db->insert($query);
    return $result > 0;
}

public function getAllMusic($start, $limit) {
    $query = "SELECT * FROM baihat JOIN casi ON casi.id_casi = baihat.id_casi LIMIT $start, $limit";
    return $this->db->select($query);
}
public function getTotalSongs() {
    $query = "SELECT COUNT(*) as total FROM baihat";
    $result = $this->db->select($query);
    return $result->fetch_assoc()['total'];
}
    
}
?>
