<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Get Steam REVIEW PHP</title>
</head>

<?php
// чтобы не было Hack на github
?>

<body>
    <div class="logo">
        <a href="https://store.steampowered.com/" target="_blank" rel="noopener noreferrer">
            <img width="200px" src="https://store.akamai.steamstatic.com/public/shared/images/header/logo_steam.svg" alt="">
        </a>
        <h3>Получить свежие негативные обзоры PHP</h3>
    </div>
    <form>
        <label for="game-id">Steam Game ID:</label>
        <input type="text" id="game-id" name="game-id" placeholder="275850">
        <input type="submit" value="Получить" onclick="openID(event)">
        <input type="button" value="Очистить" onclick="clearInput('game-id')">
        <input type="button" value="test" onclick="testPost()">
    </form>
    <div class="info" id="game-id-info"></div>
    <form>
        <label for="game-link">Steam Game Link <a href="./clipboard.php">(из буфера)</a>:</label>
        <input type="text" id="game-link" name="game-link" placeholder="https://store.steampowered.com/app/275850/No_Mans_Sky/">
        <input type="submit" value="Получить" onclick="openLink(event)">
        <input type="button" value="Очистить" onclick="clearInput('game-link')">
        <!-- <input type="button" value="Вставить" onclick="paste(event)"> -->
    </form>
    <div class="info" id="game-link-info"></div>
    <form>
        <label for="game-search">Искать игру:</label>
        <input type="text" id="game-search" name="game-search" placeholder="The Riftbreaker">
        <input type="submit" value="Поиск" onclick="searchGame(event)">
        <input type="button" value="Очистить" onclick="clearInput('game-search')">
        <a href="./downloadgamelist.php">Обновить</a>
        <!-- <input type="button" value="Вставить" onclick="paste(event)"> -->
    </form>
    <div id="games-list"></div>
    <hr>
    <div class="title">Минимальное время игры (playtime_filter_min)</div>
    <input type="number" id="playtime_filter_min" value="10" size="4">

    <script>
        function searchMessage(text, classM) {
            const e = document.createElement('span')
            e.textContent = text
            e.className = classM
            document.getElementById('games-list').append(e)
        }

        function searchGame(e) {
            e.preventDefault()
            const list = document.getElementById('games-list')
            list.textContent = ''
            let gameSearch = document.getElementById('game-search').value.trim()
            if (!gameSearch) {
                console.log('Пусто');
                searchMessage('Введите название игры', 'info')
                return
            }
            gameSearch = gameSearch.toLowerCase()
            fetch("api.steampowered.com.json")
                .then(response => response.json())
                .then(games => {
                    // console.log(games.applist.apps)
                    games = games.applist.apps

                    // games = games.slice(0, 50)
                    const newAr = games.filter(item => {
                        const name = item.name.toLowerCase()
                        return name.includes(gameSearch)
                    })
                    // console.log(newAr);

                    // list.textContent = ''
                    if (newAr.length) {
                        newAr.forEach(element => {
                            const e = document.createElement('div')
                            e.classList.add('games-list-item')
                            e.textContent = `${element.name} - ${element.appid}`
                            list.append(e)
                            e.addEventListener('click', () => gameIDtoInput(element.appid))
                        });
                    } else {
                        // const e = document.createElement('span')
                        // e.textContent = ''
                        // e.className = 'info'
                        // document.getElementById('games-list').append(e)
                        searchMessage('Не найдено', 'info')
                    }
                })
        }

        function gameIDtoInput(id) {
            console.log(id);
            goToLink(id)
        }

        function openID(e) {
            e.preventDefault()
            const gameID = document.getElementById('game-id').value.trim()
            if (gameID) {
                goToLink(gameID)
            } else {
                document.getElementById('game-id-info').textContent = 'Пустой ID'
            }
        }

        function goToLink(gameID, playtime_filter_min) {
            playtime_filter_min = document.getElementById('playtime_filter_min').value.trim()
            window.location.href = `./gamereview.php?gameid=${gameID}&playtimemin=${playtime_filter_min}`
        }

        function openLink(e) {
            e.preventDefault()
            const gameLink = document.getElementById('game-link').value.trim()
            if (gameLink) {
                const gameID = getIDFromLink(gameLink)
                document.getElementById('game-link-info').textContent = gameID
                goToLink(gameID)
            } else {
                document.getElementById('game-link-info').textContent = 'Пустая ссылка'
            }
        }

        function getIDFromLink(link) {
            link = link.replace('https://store.steampowered.com/app/', '')
            const slash = link.indexOf('/')
            const id = link.slice(0, slash)
            return id
        }

        function clearInput(id) {
            document.getElementById(id).value = ''
        }

        function testPost() {
            (async () => {
                const rawResponse = await fetch('http://127.0.0.1:3000/', {
                    method: 'POST',
                    headers: {
                        // 'Accept': 'application/json',
                        // 'Accept': 'text/plain',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        a: 1,
                        b: 'Textual content'
                    })
                });
                const content = await rawResponse.text();
                console.log("RESPONSE", content);
                document.getElementById('game-id-info').textContent = content
            })();
        }
        // function paste(e) {
        //     navigator.clipboard.readText().then(
        //         clipText => e.target.innerText = clipText );
        // }
    </script>
    <!-- <script src="./1.js"></script> -->
</body>

</html>