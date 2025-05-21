<?php
include '../DAO/AdminSongDAO.php';
session_start();

$song = new AdminSongDAO();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result_song = $song->GetSongById($id);
    if (!$result_song) {
        echo "Không tìm thấy bài hát.";
        exit();
    }
}

$artists = $song->GetAllArtists();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenbaihat = $_POST['tenbaihat'];
    $id_casi = $_POST['id_casi']; 
    $theloai = $_POST['theloai'];
    $ngheSi = $_POST['ngheSi'];
    $moTa = $_POST['moTa'];

    $linknhac = !empty($_FILES['linknhac']['name']) ? $_FILES['linknhac']['name'] : basename($result_song['linknhac']);
    $album = !empty($_FILES['album']['name']) ? $_FILES['album']['name'] : basename($result_song['album']);

    $audioDir = "../audio/";
    $albumDir = "../album/";

    $linknhacPath = $audioDir . basename($linknhac);
    $albumPath = $albumDir . basename($album);

    $uploadSuccess = true;

    if (!empty($_FILES['linknhac']['name']) && !move_uploaded_file($_FILES['linknhac']['tmp_name'], $linknhacPath)) {
        $uploadSuccess = false;
    }

    if (!empty($_FILES['album']['name']) && !move_uploaded_file($_FILES['album']['tmp_name'], $albumPath)) {
        $uploadSuccess = false;
    }

    if ($uploadSuccess) {
        $linknhacDB = 'audio/' . basename($linknhac);
        $albumDB = 'album/' . basename($album);
        
        $update_Song = $song->UpdateSongById($tenbaihat, $theloai, $albumDB, $linknhacDB, $ngheSi, $moTa, $id_casi, $id);

        if ($update_Song) {
            $_SESSION['message'] = "Đã sửa bài hát '$tenbaihat' thành công!";
            header("Location: AdminShowSong.php");
            exit();
        } else {
            echo "Cập nhật không thành công.";
        }
    } else {
        echo "Đã xảy ra lỗi khi tải file lên.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Bài Hát</title>
    <link rel="stylesheet" type="text/css" href="../CSS/formSong.css">

</head>
<body>

<h2>Sửa Bài Hát</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Tên Bài Hát:</label>
    <input type="text" name="tenbaihat" value="<?php echo htmlspecialchars($result_song['tenbaihat']); ?>" required>

    <label>Tên Ca Sĩ:</label>
    <select name="id_casi" required>
        <?php while ($artist = $artists->fetch_assoc()): ?>
            <option value="<?php echo $artist['id_casi']; ?>" <?php echo ($artist['id_casi'] == $result_song['id_casi']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($artist['tenCaSi']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Thể Loại:</label>
    <select name="theloai" required>
        <option value="Nhạc Trẻ" <?php echo ($result_song['theloai'] == 'Nhạc Trẻ') ? 'selected' : ''; ?>>Nhạc Trẻ</option>
        <option value="Nhạc Đỏ" <?php echo ($result_song['theloai'] == 'Nhạc Đỏ') ? 'selected' : ''; ?>>Nhạc Đỏ</option>
        <option value="Nhạc Rap" <?php echo ($result_song['theloai'] == 'Nhạc Rap') ? 'selected' : ''; ?>>Nhạc Rap</option>
        <option value="Nhạc Trung" <?php echo ($result_song['theloai'] == 'Nhạc Trung') ? 'selected' : ''; ?>>Nhạc Trung</option>
        <option value="Nhạc Âu" <?php echo ($result_song['theloai'] == 'Nhạc Âu') ? 'selected' : ''; ?>>Nhạc Âu</option>
    </select>

    <label>Album (Hình ảnh):</label>
    <input type="file" name="album" accept="image/*">

    <label>Link Nhạc (File Audio):</label>
    <input type="file" name="linknhac" accept="audio/*">

    <label>Nghệ Sĩ:</label>
    <input type="text" name="ngheSi" value="<?php echo htmlspecialchars($result_song['ngheSi']); ?>" required>

    <label>Mô Tả:</label>
    <textarea name="moTa" required><?php echo htmlspecialchars($result_song['moTa']); ?></textarea>

    <input type="submit" value="Cập Nhật">
</form>
</body>
</html>
