<?php

$movies = [];
$users = [];
$show = 1;

if ($_POST['gamers'] != false && strlen($_POST['gamers']) > 3) {
    $show = 2;
    $users = explode(' ', $_POST['gamers']);
    $winner = $users[array_rand($users)];
}

if ($_POST['go'] == 1) {
    if ($_POST['films'] != false && strlen($_POST['films']) > 3) {
        $show = 3;
        $movies = explode("\n", $_POST['films']);
        $film = $movies[array_rand($movies)];
        $url = "https://yandex.ru/search/?text=lordfilms+{$film}&lr=213";
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<title>Random</title>
<div class="container" style="box-shadow: 0 20px 10px lightgray; margin: 20px auto; padding-bottom: 20px">
    <div class="row">
        <div class="col-sm">
            <a href="/"><img src="https://yt3.ggpht.com/ytc/AAUvwng-YkLNL65sYGENjhW0GtH8CfBU3xMGZVDkjJtJPQ=s900-c-k-c0x00ffffff-no-rj"
                             width="200px" alt="" style="display: block; margin: 0 auto"></a>
        </div>
        <div class="col-sm">
            <h3>Рандомайзер фильмов PRO</h3>
            <?php if($show == 1): ?>
            <div class="list-group mt-3">
                <a href="#" class="list-group-item list-group-item-action active">
                    Правила игры просты:
                </a>
                <span class="list-group-item">В игре учавствуют сколько угодно игроков</span>
                <span class="list-group-item">Игроки вносят свои имена в поле  через "пробел"</span>
                <span class="list-group-item">На экране появится имя победителя</span>
                <span class="list-group-item">Победитель вносит свой список фильмов (1 фильм на 1 строке)</span>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($show === 1): ?>
        <div class="form-group" style=" margin: 10px auto">
            <form action="/" method="post" class="horizontal-form">
                <div class="form-control mb-3">
                    <label for="gamers">Введите имена игроков через "пробел"</label>
                    <input name="gamers" class="form-control" id="gamers" type="text">
                </div>
                <button class="btn btn-warning" name="run" value="1">Выбрать победителя</button>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($show === 2): ?>
    <div class="row mt-3">
        <div class="col-sm">
        <h4>Победитель:<b style="color: coral">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="coral" class="bi bi-trophy"
                     viewBox="0 0 16 16">
                    <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935zM3.504 1c.007.517.026 1.006.056 1.469.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.501.501 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667.03-.463.049-.952.056-1.469H3.504z"/>
                </svg> <?= $winner ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="coral" class="bi bi-trophy"
                     viewBox="0 0 16 16">
                    <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935zM3.504 1c.007.517.026 1.006.056 1.469.13 2.028.457 3.546.87 4.667C5.294 9.48 6.484 10 7 10a.5.5 0 0 1 .5.5v2.61a1 1 0 0 1-.757.97l-1.426.356a.5.5 0 0 0-.179.085L4.5 15h7l-.638-.479a.501.501 0 0 0-.18-.085l-1.425-.356a1 1 0 0 1-.757-.97V10.5A.5.5 0 0 1 9 10c.516 0 1.706-.52 2.57-2.864.413-1.12.74-2.64.87-4.667.03-.463.049-.952.056-1.469H3.504z"/>
                </svg>
            </b></h4>
            <hr>
        </div>
    </div>
        <div class="row">
            <div class="col-sm">
                <form action="/" method="post">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-camera-reels" viewBox="0 0 16 16">
                                <path d="M6 3a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM1 3a2 2 0 1 0 4 0 2 2 0 0 0-4 0z"/>
                                <path d="M9 6h.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 7.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 16H2a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h7zm6 8.73V7.27l-3.5 1.555v4.35l3.5 1.556zM1 8v6a1 1 0 0 0 1 1h7.5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1z"/>
                                <path d="M9 6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM7 3a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                            </svg>
                            Список фильмов:
                        </label>
                        <textarea class="form-control" name="films" id="exampleFormControlTextarea1"
                                  rows="7"></textarea>
                    </div>
                    <button type="submit" name="go" class="btn btn-success" value="1">Выбрать из этого списка</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($show === 3): ?>
    <div class="row mt-3">
        <div class="col-sm"></div>
        <div class="col-sm" style="text-align: center">
            <h4>Выиграл фильм:<br> <b><?= $film ?></b></h4>
    <a href="<?= $url ?>"><button type="button" class="btn btn-warning mt-3">Смотреть в онлайн</button></a>
        </div>
        <div class="col-sm"></div>
    </div>
    <?php endif; ?>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>

</body>
</html>

