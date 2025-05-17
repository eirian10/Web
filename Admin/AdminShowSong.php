<?php
include '../DAO\AdminSongDAO.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách bài hát</title>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        font-size: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    h2 {
        text-align: center;
        color: darkslateblue;
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        font-size: 50px;

    }
.add {
    display: inline-block; /* Để nút có thể căn giữa */
    width: 15%;
    height: 50px;
    margin-bottom: 10px;
    background-color: blue; /* Nền xanh */
    color: white; /* Chữ trắng */
    font-weight: bold;
    border: none; /* Xóa viền nút */
    cursor: pointer; /* Thay đổi con trỏ khi di chuột qua */
    text-align: center; /* Căn giữa chữ trong nút */
    line-height: 50px; /* Căn giữa chữ theo chiều dọc */
}
    .container {
        width: 100%;
        display: flex;
        justify-content: center;
    }

    table {
        width: 90%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin: 0 auto;
    }

    td, th {
    word-break: break-word;
}

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
        vertical-align: top;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    a {
        text-decoration: none;
        color: #007BFF;
        margin-right: 10px;
    }

    a:hover {
        text-decoration: underline;
    }

    .action-links {
        white-space: nowrap;
    }
</style>

</head>
<body>

<h2>Danh sách bài hát</h2>
<a href="AdminAddSong.php" class="add">
    <button>Thêm bài mới</button>
</a>
<div class="container">
<?php
$song = new AdminSongDAO();
$result_song = $song->ShowListSong();
if ($result_song->num_rows > 0) {
    // Bắt đầu bảng
    echo "<table border='1' >";
    echo "<tr>
            <th>ID Bài Hát</th>
            <th>Tên Ca Sĩ</th>
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
                    <a href='AdminEditSong.php?id=" . $row["id_baihat"] . "' >Sửa</a> 
                    <a href='AdminDeleteSong.php?id=" . $row["id_baihat"] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa bài hát này?');\">Xóa</a>
                </td>

              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

?>
</div>
</body>
</html>
