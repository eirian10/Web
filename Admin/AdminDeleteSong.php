<?php
include '../DAO/AdminSongDAO.php';
$song = new AdminSongDAO();
if (isset($_GET['id'])) {
    $id = $_GET['id']; 

        // Lấy thông tin để biết đường dẫn file
    $songData = $song->GetSongById($id);
    if ($songData) {
        $albumPath = 'C:/xampp/htdocs/myweb/album/' . $songData['album'];
        $audioPath = 'C:/xampp/htdocs/myweb/audio/' . $songData['linknhac'];

        // Xóa file vật lý
        if (file_exists($albumPath)) {
            unlink($albumPath);
        }
        if (file_exists($audioPath)) {
            unlink($audioPath);
        }

    $deleteResult = $song->DeleteSongById($id);

    if ($deleteResult) {
        header("Location: AdminShowSong.php"); // quay lại danh sách bài hát
        exit();
    } else {
        echo "Xóa bài hát không thành công.";
    }
}
} else {
    echo "Không tìm thấy ID bài hát để xóa.";

}
?>