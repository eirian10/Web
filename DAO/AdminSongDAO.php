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
}


?>