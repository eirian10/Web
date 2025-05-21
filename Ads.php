<?php
include_once "DAO/AdsDAO.php";

$adsDAO = new AdsDAO();
$ad = $adsDAO->getActiveAd();

if ($ad && $ad->num_rows > 0):
    $row = $ad->fetch_assoc();
?>
<div id="ad-banner" style="position: fixed; top: 10px; right: 10px; z-index: 9999; background: #fff; padding: 10px; border: 1px solid #ccc;">
    <a href="<?= $row['target_url'] ?>" target="_blank">
        <img src="<?= $row['image_url'] ?>" alt="<?= $row['title'] ?>" style="max-width: 300px;">
    </a>
    <button onclick="document.getElementById('ad-banner').style.display='none'" style="position: absolute; top: 5px; right: 5px;">×</button>
</div>

<script>
    setTimeout(() => {
        const banner = document.getElementById('ad-banner');
        if (banner) banner.style.display = 'none';
    }, 5000);
</script>
<?php endif; ?>
