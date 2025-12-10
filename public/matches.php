<?php
?>
<h1>Deine Matches</h1>

<div class="matches">
    <?php  foreach ($matches as $m):?>
    <div class="match-entry">
        <img src="/uploads/<?= $m['myDogImg'] ?>" class="mydog">
        <img src="/uploads/<?= $m['otherDogImg'] ?>" class="otherdog">
        <p><?= $m['myDogName'] ?> & <?= $m['otherDogName'] ?></p>
    </div>
    <?php endforeach; ?>
</div>
