<?php
class SingerDAO {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Kết nối đến cơ sở dữ liệu
    }

    public function getSingerBySongId($id_baihat) {
        $query = "
            SELECT casi.tenCaSi, albumcasi.linkAnh
            FROM baihat
            JOIN casi ON baihat.id_casi = casi.id_casi
            JOIN albumcasi ON baihat.id_casi = albumcasi.id_casi
            WHERE baihat.id_baihat = $id_baihat ";
             $result = $this -> db -> select($query);
            if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
    }
    }

?>