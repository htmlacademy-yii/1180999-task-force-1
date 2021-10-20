<?php
/**
 * @var Tasks $task Данные задачи
 * @var array $address Город, адрес, координаты
 */

use frontend\models\Tasks;

$points = "{$address['points']['latitude']}, {$address['points']['longitude']}";

?>

<script type="text/javascript">
    ymaps.ready(init);

    function init() {

        var myMap = new ymaps.Map("map", {
                center: [<?=  $points ?>],
                zoom: 17,
                controls: ['zoomControl']

            }, {
                searchControlProvider: 'yandex#search'
            }),

            myPieChart = new ymaps.Placemark([
                [<?= $points ?>]
            ], );

        myMap.geoObjects
            // .add(myGeoObject)

            .add(new ymaps.Placemark([<?= $points ?>], {
                balloonContent:
                    "<?= $address['street'] ?>"
            }, {
                preset: 'islands#icon',
                iconColor: '#1e90fe'
            }));
    }

</script>