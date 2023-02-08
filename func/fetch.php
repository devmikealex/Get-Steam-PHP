<?php

// phpinfo();

$gameID = $_GET['gameid'];
$playtimemin = $_GET['playtimemin'];
$cursor = $_GET['cursor'];

// Получить данные игры для проверки существования success true
$urlGameInfo = "https://store.steampowered.com/api/appdetails?appids=$gameID";
$gameInfo = file_get_contents($urlGameInfo);
$gameInfo = json_decode($gameInfo);
// echo '<pre>';
// var_dump('success:', $gameInfo->$gameID->success);
// print_r($gameInfo);
// echo '</pre>';
if ($gameInfo->$gameID->success) {
    // Получить обзоры игры
    $title = $gameInfo->$gameID->data->name;
    // $title = "<a href=\"https://store.steampowered.com/app/$gameID\" target=\"_blank\" rel=\"noopener noreferrer\">$title - $gameID</a>";
    $title = <<<LINK
    <a href="https://store.steampowered.com/app/$gameID" target="_blank" rel="noopener noreferrer">$title - $gameID</a>
    LINK;
    $content = getReview();
} else {
    $title = 'Game not found';
}

function getReview()
{
    global $playtimemin, $gameID, $cursor;
    $playtimemin = $playtimemin ? $playtimemin : 10;
    $cursor = $cursor ? $cursor : '*';
    $cursor = urlencode($cursor);
    $url = "https://store.steampowered.com/appreviews/$gameID?cursor=$cursor&day_range=30&start_date=-1&end_date=-1&date_range_type=all&filter=recent&language=russian&l=russian&review_type=negative&purchase_type=all&playtime_filter_min=${playtimemin}&playtime_filter_max=0&filter_offtopic_activity=1";
    $gameReview = file_get_contents($url);
    file_put_contents("t:/gameReview-$gameID.txt", $gameReview);
    $gameReview = json_decode($gameReview);
    // print_r($gameReview);
    return $gameReview->html;
}
