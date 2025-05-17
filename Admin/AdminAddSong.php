<?php
include '../DAO/AdminSongDAO.php';

$song = new AdminSongDAO();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenbaihat = $_POST['tenbaihat'];
    $id_casi = $_POST['id_casi'];
    $theloai = $_POST['theloai'];
    $ngheSi = $_POST['ngheSi'];
    $moTa = $_POST['moTa'];

    $linknhac = $_FILES['linknhac']['name'];
    $album = $_FILES['album']['name'];

    $audioDir = "../audio/";
    $albumDir = "../album/";

    $linknhacPath = $audioDir . basename($linknhac);
    $albumPath = $albumDir . basename($album);

    $uploadSuccess = true;

    if (!empty($linknhac) && !move_uploaded_file($_FILES['linknhac']['tmp_name'], $linknhacPath)) {
        echo "Lỗi khi tải lên file nhạc.";
        $uploadSuccess = false;
    }

    if (!empty($album) && !move_uploaded_file($_FILES['album']['tmp_name'], $albumPath)) {
        echo "Lỗi khi tải lên file album.";
        $uploadSuccess = false;
    }

    if ($uploadSuccess) {
        $linknhacDB = 'audio/' . basename($linknhac);
        $albumDB = 'album/' . basename($album);
        
        $addSong = $song->AddSong($tenbaihat, $id_casi, $theloai, $albumDB, $linknhacDB, $ngheSi, $moTa);

        if ($addSong) {
            header("Location: AdminShowSong.php");
            exit();
        } else {
            echo "Thêm bài hát không thành công.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Bài Hát Mới</title>
</head>
<style>
       <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            font-weight: bolder;
            color: #333;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            width: 100%;
        }

        input[type="text"],
        input[type="file"],
        textarea {
            width: 80%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 80%;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
    </style>
</style>
<body>
    <h2>Thêm Bài Hát Mới</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Tên Bài Hát:</label>
        <input type="text" name="tenbaihat" required>

        <label>Tên Ca Sĩ:</label>
        <select name="id_casi" required>
            <?php
            $artists = $song->GetAllArtists();
            while ($artist = $artists->fetch_assoc()): ?>
                <option value="<?php echo $artist['id_casi']; ?>"><?php echo htmlspecialchars($artist['tenCaSi']); ?></option>
            <?php endwhile; ?>
        </select>

        <label>Thể Loại:</label>
        <select name="theloai" required>
            <option value="Nhạc Trẻ">Nhạc Trẻ</option>
            <option value="Nhạc Đỏ">Nhạc Đỏ</option>
            <option value="Nhạc Rap">Nhạc Rap</option>
            <option value="Nhạc Trung">Nhạc Trung</option>
            <option value="Nhạc Âu">Nhạc Âu</option>
        </select>

        <label>Album (Hình ảnh):</label>
        <input type="file" name="album" accept="image/*">

        <label>Link Nhạc (File Audio):</label>
        <input type="file" name="linknhac" accept="audio/*">

        <label>Nghệ Sĩ:</label>
        <input type="text" name="ngheSi">

        <label>Mô Tả:</label>
        <textarea name="moTa"></textarea>

        <input type="submit" value="Thêm Bài Hát">
    </form>
</body>
</html>