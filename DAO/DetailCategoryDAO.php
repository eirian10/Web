<?php
include_once 'Uitl/database.php';
?>

<?php
    class DetailCategoryDAO {
        private $db;

        public function __construct() {
            $this -> db = new Database();
        }

        function getAllMusicOfGenger($Category, $id_baihat) {
            $query = "SELECT * FROM `baihat` JOIN casi ON casi.id_casi = baihat.id_casi 
            WHERE theloai = '$Category' AND id_baihat != '$id_baihat' ORDER BY RAND();";
            $resutl = $this -> db -> select($query);
            return $resutl;
        }

        function getMusicOfId($id_baihat) {
            $query = "SELECT * FROM `baihat` JOIN casi ON casi.id_casi = baihat.id_casi 
            WHERE id_baihat = '$id_baihat' ";
            $resutl = $this -> db -> select($query);
            return $resutl;
        }
    }

?>

