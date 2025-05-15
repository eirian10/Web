<?php
include 'DAO/DetailCategoryDAO.php';
include 'DAO/SingerDAO.php';

?>


<?php

$detaiCategory = new DetailCategoryDAO();
$singer = new SingerDAO();
$result_singer = null;
$result_idbaihat = null;

if (isset($_GET['id_baihat'])) {
    $id_baihat = $_GET['id_baihat'];
    $result_idbaihat = $detaiCategory->getMusicOfId($id_baihat);
    $result_singer = $singer->getSingerBySongId($id_baihat);
} else {
    echo "ID bài hát không được cung cấp.";
}

$row_idbaihat = $result_idbaihat->fetch_assoc();
$singerInfo = $result_singer;
$result = $detaiCategory->getAllMusicOfGenger($row_idbaihat['theloai'], $row_idbaihat['id_baihat']);

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolero Hay Nhất</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="CSS/playMusic.css">
    <link rel="stylesheet" href="CSS\DetailCategory.css">

</head>

<body>
    <div class="container">
        <!-- Bên trái: Bài nhạc chính -->
        <div class="main-song">
            <div class="song-card" data-audio="<?php echo $row_idbaihat['linknhac']; ?>">
                <div class="play-overlay">
                    <i class='bx bx-play-circle'></i>
                </div>
                <img src="<?php echo $row_idbaihat['album']; ?>" alt="Song">
                <!-- chỗ này viết để cho thanh nhạc có thể lấy và hiện thông tin -->
                <div class="song-info">
                    <p class="baihat"><?php echo $row_idbaihat['tenbaihat']; ?></p>
                    <p class="casi"> <?php echo $row_idbaihat['tenCaSi']; ?></p>
                </div>     
            </div>
            <!-- chỗ này viết để show ra người dùng thấy -->
            <div class="song-info show-main">
                    <p class="show-main-text "> <?php echo $row_idbaihat['tenbaihat']; ?></p>
                    <p class="show-main-text casi"> (<?php echo $row_idbaihat['tenCaSi']; ?>)</p>
                </div>
        </div>

        <!-- Bên phải: Danh sách nhạc và nghệ sĩ -->
        <div class="right-panel">
            <div class="song-list">
                <h3>Danh sách bài hát</h3>
                <?php
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="song-item">
                            <div class="song-card" data-audio="<?php echo $row['linknhac']; ?>">
                                <div class="play-overlay list-card">
                                    <i class='bx bx-play-circle'></i>
                                </div>
                                <img src="<?php echo $row['album']; ?>" alt="Song">
                                <div class="song-info">
                                    <p class="baihat"><?php echo $row['tenbaihat']; ?></p>
                                    <br>
                                    <p class="casi">(<?php echo $row['tenCaSi']; ?>)</p>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
                <!-- <img src="album/baica" alt=""> -->
            </div>
        </div>

    </div>
    <div class="container-singer">
        <?php if ($singerInfo): ?>
            <img src="<?php echo $singerInfo['linkAnh']; ?>" alt="<?php echo $singerInfo['tenCaSi']; ?>">
            <div class="container-singer-info">
                <h3>Thông tin ca sĩ</h3>
                <p><?php echo $singerInfo['tenCaSi']; ?></p>
            </div>
        <?php else: ?>
            <p>Không có thông tin ca sĩ.</p>
        <?php endif; ?>
    </div>

    <?php include 'player.php'; ?>

    <script>
        // sử lý cho phần hiện thanh nhạc khi bấm vào
        const audioPlayer = document.getElementById('audio');
        const songCards = document.querySelectorAll('.song-card');
        const imgScrThanhNhac = document.querySelector('.cover > img');
        const containerPlay = document.querySelector('.container-play');

        const playButtonCard = document.querySelector('.play-overlay');

        // sử lý riêng cho thanh nhạc
        const audio = document.getElementById("audio");
        const playButton = document.getElementById("play");
        const duration = document.getElementById("duration");
        const current = document.getElementById("current");
        const progress = document.getElementById("progress");
        const volume = document.getElementById("volume");
        const volumeIcon = document.getElementById("volume-icon");


        let currentAudioSrc = '';
        let currentTime = 0;
        let currentCard = null; // Thêm biến để theo dõi card hiện tại

        songCards.forEach(card => {
            card.addEventListener('click', () => {
                const audioSrc = card.getAttribute('data-audio');
                const currentImg = card.querySelector('img');
                const playButtonCard = card.querySelector('.play-overlay i');

                const songTitleBaiHat = card.querySelector('.baihat');
                const songTitleCaSi = card.querySelector('.casi'); // Lấy text từ thẻ p
                if (songTitleBaiHat && songTitleCaSi) {
                    const text = songTitleBaiHat.textContent;
                    const text2 = songTitleCaSi.textContent;
                    console.log(text);
                    console.log(text2);
                } else {
                    console.log('Không tìm thấy thẻ ');
                }


                // // Cập nhật tên bài hát trong thanh nhạc
                document.getElementById('song-name').textContent = songTitleBaiHat.textContent;
                document.getElementById('artist-name').textContent = songTitleCaSi.textContent;

                // Nếu click vào card khác
                if (currentCard && currentCard !== card) {
                    // Reset card cũ
                    const oldPlayButton = currentCard.querySelector('.play-overlay i');
                    oldPlayButton.className = 'bx bx-play-circle';
                    // Reset thời gian của bài cũ
                    currentTime = 0;
                }

                // Cập nhật card hiện tại
                currentCard = card;

                // hiện thanh nhạc
                containerPlay.classList.add('show');

                // hiện ảnh bài hát
                imgScrThanhNhac.src = currentImg.src;

                if (audioPlayer.src.includes(audioSrc)) {
                    if (audioPlayer.paused) {
                        audioPlayer.play();
                        // hiện ảnh bật pause
                        playButtonCard.className = 'bx bx-pause-circle'; // thay đổi toàn bộ class có trong thẻ thanh 1 class này
                        playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";
                    } else {
                        audioPlayer.pause();
                        // hiện ảnh bật play
                        playButtonCard.className = 'bx bx-play-circle';
                        playButton.innerHTML = "<i class='bx bx-play-circle'></i>";
                    }
                } else {
                    // Khi chọn bài mới
                    currentAudioSrc = audioSrc;
                    audioPlayer.src = audioSrc;
                    audioPlayer.currentTime = 0; // Reset thời gian về 0
                    audioPlayer.play();

                    // Cập nhật tất cả icon về play
                    document.querySelectorAll('.play-overlay i').forEach(icon => {
                        icon.className = 'bx bx-play-circle';
                    });

                    // Cập nhật icon play/pause cho bài hiện tại
                    playButtonCard.className = 'bx bx-pause-circle';
                    playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";
                }
            });
        });

        // Cập nhật event listener của playButton
        playButton.addEventListener('click', function() {
            if (!currentCard) return; // Nếu chưa có card nào được chọn

            const playButtonCard = currentCard.querySelector('.play-overlay i');

            if (audio.paused) {
                audio.play();
                playButtonCard.className = 'bx bx-pause-circle';
                playButton.innerHTML = "<i class='bx bx-pause-circle'></i>";
            } else {
                audio.pause();
                playButtonCard.className = 'bx bx-play-circle';
                playButton.innerHTML = "<i class='bx bx-play-circle'></i>";
            }
        });

        // Cập nhật event listener của audio
        audioPlayer.addEventListener('ended', () => {
            // Khi bài hát kết thúc
            if (currentCard) {
                const playButtonCard = currentCard.querySelector('.play-overlay i');
                playButtonCard.className = 'bx bx-play-circle';
                playButton.innerHTML = "<i class='bx bx-play-circle'></i>";
                currentTime = 0;
            }
        });

        // Lưu thời gian hiện tại khi tạm dừng
        audioPlayer.addEventListener('pause', () => {
            currentTime = audioPlayer.currentTime;
        });

        // Khôi phục thời gian khi play lại
        audioPlayer.addEventListener('play', () => {
            if (currentTime > 0) {
                audioPlayer.currentTime = currentTime;
            }
        });


        function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const secon = Math.floor(seconds % 60);
            return `${minutes < 10 ? '0' + minutes : minutes}:${secon < 10 ? '0' + secon : secon}`;
        };


        audio.addEventListener('loadedmetadata', function() {
            duration.textContent = formatTime(audio.duration);
            // console.log(formatTime(audio.duration));
        });

        audio.addEventListener('timeupdate', function() {
            current.textContent = formatTime(audio.currentTime);
            progress.value = (audio.currentTime / audio.duration) * 100;
        });

        progress.addEventListener("input", () => {
            audio.currentTime = (progress.value / 100) * audio.duration;
        })
        // giá trị của thanh âm lượng 0.0 - 1.0
        volume.addEventListener("input", function() {
            audio.volume = volume.value;
        });
    </script>
</body>

</html>