<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Steam REVIEW PHP</title>
</head>

<?php
require_once('./func/fetch.php');
$gameID = $_GET['gameid'];
// $title = 'asljgakljgsdkf';
// $content = 'jb sdljkf sldflsdg lsjdfgl sjdf glsjdf gsdfg';
?>

<body>
    <div class="sticky">
        <a href="./index.php">На главную</a>
        <!-- <form> -->
        <div class="review-header-inside">
            <input type="text" id="game-link" name="game-link"
                placeholder="https://store.steampowered.com/app/275850/No_Mans_Sky/">
            <input type="submit" value="Получить" onclick="openLink(event)">
        </div>
        <a href="./clipboard.php">Из буфера</a>
        <!-- </form> -->
    </div>
    <div id="root">
        <h1>
            <?= $title ?><br>Не рекомендую
        </h1>

        <?php
        // echo 'AAA' . $test;
        // echo '<br>';
        // echo '<br>';
        echo $content;
        ?>

    </div>
</body>
<script>
    function LoadMoreReviews(gameID, newCursor) {
        // console.log("🚀 newCursor =", newCursor)
        const urlParams = new URLSearchParams(window.location.search);
        const playtime_filter_min = urlParams.get('playtimemin') || 10
        newCursor = encodeURIComponent(newCursor)
        console.log("🚀 ~ file: gamereview.php:50 ~ LoadMoreReviews ~ newCursor", newCursor)
        window.location.href = `/gamereview.php?gameid=${gameID}&playtimemin=${playtime_filter_min}&cursor=${newCursor}`
    }
    function goToLink(gameID, playtime_filter_min) {
        window.location.href = `/gamereview.php?gameid=${gameID}&playtimemin=${playtime_filter_min}`
    }
    function openLink(e) {
        e.preventDefault()
        const gameLink = document.getElementById('game-link').value.trim()
        if (gameLink) {
            const gameID = getIDFromLink(gameLink)
            goToLink(gameID, 10)
        }
    }
    function getIDFromLink(link) {
        link = link.replace('https://store.steampowered.com/app/', '')
        const slash = link.indexOf('/')
        const id = link.slice(0, slash)
        return id
    }
</script>

</html>