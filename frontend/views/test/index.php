<?php

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Быстрый старт. Размещение интерактивной карты на странице</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="https://api-maps.yandex.ru/2.1/?apikey=<?= $api ?>&lang=ru_RU" type="text/javascript">
    </script>
    <style>

    </style>
</head>

<body>

<div id="map" class="content-view__map mt-5" style="width: 600px; height: 400px"></div>

<script type="text/javascript">
    ymaps.ready(init);

    function init() {

        var myMap = new ymaps.Map("map", {
                center: <?= $points ?>,
                zoom: 18,
                controls: []

            }, {
                searchControlProvider: 'yandex#search'
            }),

            myPieChart = new ymaps.Placemark([
                <?= $points ?>
            ], );

        myMap.geoObjects
            // .add(myGeoObject)

            .add(new ymaps.Placemark(<?= $points ?>, {
                balloonContent: '<?= $task ?>'
            }, {
                preset: 'islands#icon',
                iconColor: '#1e90fe'
            }));
    }

</script>
</body>

</html>