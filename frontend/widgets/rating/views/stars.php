<?php
/**
 * @var $rating
 */
?>
<div class="stars">
<?php for ($i = 1; $i <= 5; $i++): ?>
    <span class="<?= $rating < $i ? 'star-disabled' : ''?>"></span>
<?php endfor; ?>

<b><?= sprintf('%01.2f',$rating) ?></b>
</div>