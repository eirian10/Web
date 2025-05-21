<?php
require_once __DIR__ . '/../DAO/AdminSongDAO.php';
require_once __DIR__ . '/../DAO/ShowCategoryDAO.php';

session_start();

$song = new AdminSongDAO();

// Kiểm tra và lấy thông báo từ session
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị


$result_song = null;


    $totalSongs = $song->getTotalSongs();
    $limit = 12;
     $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $total_page = ceil($totalSongs / $limit);
    if ($current_page > $total_page) {
        $current_page = $total_page;
    } elseif ($current_page < 1) {
        $current_page = 1;
    }
    $start = ($current_page - 1) * $limit;
    $result_song = $song->getAllMusic($start, $limit);
//  }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách bài hát</title>
    <link rel="stylesheet" type="text/css" href="../CSS/adminSong.css">

</head>
<body>

<h2>Danh sách bài hát</h2>

<!-- Thanh thông báo -->
<div class="notification" style="position: absolute; left: 10px; top: 20px; background-color: lightyellow; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
</div>


<a href="AdminSongAdd.php" class="add">
    <button>Thêm bài mới</button>
</a>

<div class="container">
<?php
if ($result_song && $result_song->num_rows > 0) {
    while ($row = $result_song->fetch_assoc()) {
        echo "<div class='song-card'>
                <h3>" . htmlspecialchars($row["tenbaihat"]) . "</h3>
                <p><strong>Ca Sĩ:</strong> " . htmlspecialchars($row["tenCaSi"]) . "</p>
                <p><strong>Thể Loại:</strong> " . htmlspecialchars($row["theloai"]) . "</p>
                <p><strong>Lượt Nghe:</strong> " . htmlspecialchars($row["luotnghe"]) . "</p>
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


</body>
</html>
