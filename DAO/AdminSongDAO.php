<?php 
include_once '../Uitl/database.php';
?>

<?php 

class AdminSongDAO {
    private $db;

    public function __construct() {
        $this -> db = new Database();
    }

    public function ShowListSong() {
        $query = "SELECT id_baihat,casi.tenCaSi,tenbaihat,theloai,luotnghe,album,linknhac,ngheSi,moTa  FROM `baihat`,`casi` WHERE baihat.id_casi = casi.id_casi;";
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
    public function UpdateSongById($tenbaihat,$theloai,$album,$linknhac,$ngheSi,$moTa,$id_song) {
        $query = "UPDATE `baihat` SET 
        tenbaihat='$tenbaihat', 
        theloai='$theloai', 
        album='$album', 
        linknhac='$linknhac', 
        ngheSi='$ngheSi', 
        moTa='$moTa' 
        WHERE id_baihat=$id_song";

        $result = $this->db->update($query);
        return $result > 0;

    }

    public function DeleteSongById($id_song) {
        $query = "DELETE FROM `baihat` WHERE id_baihat = $id_song";
        $result = $this->db->delete($query);
        return $result > 0;
    }
}

?>
