<?php

$url = 'http://api.steampowered.com/ISteamApps/GetAppList/v0002/?format=json';
if (file_put_contents('api.steampowered.com.json', file_get_contents($url))) {
    echo "File downloaded successfully";
} else {
    echo "File downloading failed";
}

echo '<br><br><a href="./index.php">На главную</a>';