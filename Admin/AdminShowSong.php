<?php
require_once __DIR__ . '/../DAO/AdminSongDAO.php';
require_once __DIR__ . '/../DAO/ShowCategoryDAO.php';


$song = new AdminSongDAO();

$totalSongs = $song->getTotalSongs();
$limit = 12;
$current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$total_page = ceil($totalSongs / $limit);
if ($current_page > $total_page) {
    $current_page = $total_page;
} elseif ($current_page < 1) {
    $current_page = 1;
}
$start = ($current_page - 1) * $limit;
$result_song = $song->getAllMusic($start, $limit);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách bài hát</title>
    <!-- <link rel="stylesheet" type="text/css" href="../CSS/adminSong.css"> -->
    <link rel="stylesheet" href="../CSS/adminSong.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="../CSS/IndexAdmin.css?v=<?= time(); ?>">


</head>

<body>


    <?php include 'headerAdmin.php'; ?>
    <div class="container-admin-left">
        <?php include 'sidebarAdmin.php'; ?>
        <main>
            <div class="container">
                <?php
                if ($result_song && $result_song->num_rows > 0) {
                    while ($row = $result_song->fetch_assoc()) {
                        echo "<div class='song-card'>
                            <h3>" . $row["tenbaihat"] . "</h3>
                            <img src='" . "../" . $row["album"] . "' alt='Ảnh album'>
                            <p><strong>Ca Sĩ:</strong> " . $row["tenCaSi"] . "</p>
                            <p><strong>Thể Loại:</strong> " . $row["theloai"] . "</p>
                            <p><strong>Lượt Nghe:</strong> " . $row["luotnghe"] . "</p>
                            
                            <audio controls>
                                <source src='" . "../audio/" . basename($row["linknhac"]) . "' type='audio/mpeg'>
                            </audio>
                            <div class='action-links'>
                                <a href='AdminSongEdit.php?id=" . $row["id_baihat"] . "'>Sửa</a>
                                <a href='AdminSongDelete.php?id=" . $row["id_baihat"] . "' onclick=\"return confirm('Bạn có chắc chắn muốn xóa bài hát này?');\">Xóa</a>
                            </div>
      </div>";
                    }
                } else {
                    echo "<p>Không tìm thấy bài hát nào.</p>";
                }
                ?>
            </div>
            <div class="list-buttom">
                <ul class="pagination">
                    <?php
                    if ($current_page > 1 && $total_page > 1) {
                        echo '<a href="AdminSongShow.php?page=' . ($current_page - 1) . '">Prev</a> | ';
                    }
                    // Lặp qua các trang
                    for ($i = 1; $i <= $total_page; $i++) {
                        if ($i == $current_page) {
                            echo '<span>' . $i . '</span> | ';
                        } else {
                            echo '<a href="AdminSongShow.php?page=' . $i . '">' . $i . '</a> | ';
                        }
                    }
                    // Hiển thị nút Next
                    if ($current_page < $total_page && $total_page > 1) {
                        echo '<a href="AdminSongShow.php?page=' . ($current_page + 1) . '">Next</a>';
                    }
                    ?>
                </ul>
            </div>
        </main>
    </div>
    <?php include 'footerAdmin.php'; ?>
</body>

</html>
