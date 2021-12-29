<?php
/**
 * @var Tasks $task Данные задачи
 * @var array $points Город, адрес, координаты
 */

use frontend\models\Tasks;

?>

<script type="text/javascript">
    ymaps.ready(init);

    function init() {

        new ymaps.Placemark([
            [<?= $points ?>]
        ], );
        var myMap = new ymaps.Map("map", {
                center: [<?= $points ?>],
                zoom: 17,
                controls: ['zoomControl']

            }, {
                searchControlProvider: 'yandex#search'
            });

        myMap.geoObjects
            // .add(myGeoObject)

            .add(new ymaps.Placemark([<?= $points ?>], {
                balloonContent:
                    "Место сделки"
            }, {
                preset: 'islands#icon',
                iconColor: '#1e90fe'
            }));
    }

</script>