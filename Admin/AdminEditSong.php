<?php
include '../DAO/AdminSongDAO.php';

$song = new AdminSongDAO();

// Kiểm tra nếu có ID được truyền vào
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy thông tin bài hát
    $result_song = $song->GetSongById($id);
    // if (!$result_song) {
    //     echo "Không tìm thấy bài hát.";
    //     exit();
    // }
}

// Kiểm tra nếu có dữ liệu được gửi đi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenbaihat = $_POST['tenbaihat'];
    $tencasi = $_POST['tenCaSi'];
    $theloai = $_POST['theloai'];
    $ngheSi = $_POST['ngheSi'];
    $moTa = $_POST['moTa'];

    // Tên file nếu không upload mới thì giữ nguyên
    $linknhac = !empty($_FILES['linknhac']['name']) ? $_FILES['linknhac']['name'] : basename($result_song['linknhac']);
    $album = !empty($_FILES['album']['name']) ? $_FILES['album']['name'] : basename($result_song['album']);

    // Thư mục upload
    $audioDir = "../audio/";
    $albumDir = "../album/";


// Tạo đường dẫn tuyệt đối để di chuyển file:
    $linknhacPath = $audioDir . basename($linknhac);
    var_dump($linknhacPath);
    $albumPath = $albumDir . basename($album);

    // Đường dẫn lưu vào DB (tương đối)
    $linknhacDB = 'audio/' . basename($linknhac);
    $albumDB = 'album/' . basename($album);

    // Upload file nếu có
    $uploadSuccess = true;

    if (!empty($_FILES['linknhac']['name']) && !move_uploaded_file($_FILES['linknhac']['tmp_name'], $linknhacPath)) {
        $uploadSuccess = false;
    }

    if (!empty($_FILES['album']['name']) && !move_uploaded_file($_FILES['album']['tmp_name'], $albumPath)) {
        $uploadSuccess = false;
    }

    if ($uploadSuccess) {
        // Cập nhật CSDL
        $update_Song = $song->UpdateSongById($tenbaihat, $theloai, $albumDB, $linknhacDB, $ngheSi, $moTa, $id);

        if ($update_Song) {
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
</head>
<body>
   
    <h2>Sửa Bài Hát</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Tên Bài Hát:</label>
        <input type="text" name="tenbaihat" value="<?php echo htmlspecialchars($result_song['tenbaihat']); ?>" required>

        <label>Tên Ca Sĩ:</label>
        <input type="text" name="tencasi" value="<?php echo htmlspecialchars($result_song['tenCaSi']); ?>" required>

        <label>Thể Loại:</label>
        <input type="text" name="theloai" value="<?php echo htmlspecialchars($result_song['theloai']); ?>">

        <label>Album (Hình ảnh):</label>
        <input type="file" name="album" accept="image/*">

        <label>Link Nhạc (File Audio):</label>
        <input type="file" name="linknhac" accept="audio/*">

        <label>Nghệ Sĩ:</label>
        <input type="text" name="ngheSi" value="<?php echo htmlspecialchars($result_song['ngheSi']); ?>">

        <label>Mô Tả:</label>
        <textarea name="moTa"><?php echo htmlspecialchars($result_song['moTa']); ?></textarea>

        <input type="submit" value="Cập Nhật">
    </form>
</body>
</html>
