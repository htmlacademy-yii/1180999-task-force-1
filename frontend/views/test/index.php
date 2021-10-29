<?php
/**
 * @var SingUpForm $model
 * @var \frontend\models\UsersMessages $data
 * @var \frontend\models\Tasks $task
 */

use frontend\models\forms\SingUpForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="container">
    <div id="chat-container">
        <!--                    добавьте сюда атрибут task с указанием в нем id текущего задания-->
        <chat class="connect-desk__chat" task="<?php echo $task->id?>"></chat>
    </div>
</div>



<?php $this->registerJsFile('/js/messenger.js'); ?>

