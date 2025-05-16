<?php
include '../DAO\AdminSongDAO.php';
?>

<?php
$song = new AdminSongDAO();
$result_song = $song->ShowListSong();

if ($result_song->num_rows > 0) {
    // Bắt đầu bảng
    echo "<table border='1' style='width:100%; border-collapse:collapse;'>";
    echo "<tr>
            <th>ID Bài Hát</th>
            <th>ID Ca Sĩ</th>
            <th>Tên Bài Hát</th>
            <th>Thể Loại</th>
            <th>Lượt Nghe</th>
            <th>Album</th>
            <th>Link Nhạc</th>
            <th>Nghệ Sĩ</th>
            <th style='width:40%'>Mô Tả</th>
            <th>Tùy chỉnh</th>
          </tr>";

    // Hiển thị từng hàng dữ liệu
    while ($row = $result_song->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id_baihat"] . "</td>
                <td>" . $row["tenCaSi"] . "</td>
                <td>" . $row["tenbaihat"] . "</td>
                <td>" . $row["theloai"] . "</td>
                <td>" . $row["luotnghe"] . "</td>
                <td>" . $row["album"] . "</td>
                <td>" . $row["linknhac"] . "</td>
                <td>" . $row["ngheSi"] . "</td>
                <td>" . $row["moTa"] . "</td>
                <td>
                    <a href='edit_song.php?id=" . $row["id_baihat"] . "'>Sửa</a> | 
                    <a href='delete_song.php?id=" . $row["id_baihat"] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa bài hát này?');\">Xóa</a>
                </td>

              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$db->close();
?>
