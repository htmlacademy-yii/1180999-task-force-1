<?php

/**
 * @var int|null $score
 * @var string|null $style
 */

?>

<div class="card__review-rate">
    <p class="<?= $style ?> big-rate">
        <?= $score ? $score . '<span></span>' : '-'?>
    </p>

</div>