<?= $this->extend('Includes/Template') ?>

<?= $this->section('customCSS') ?>
<!-- Custom CSS goes Here-->

<!-- Custom Profile CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/Leaderboard.css'); ?>" />
<?= $this->endSection() ?>

<?= $this->section('customJS') ?>
<!-- Custom JS goes Here-->
<?= $this->endSection() ?>

<!-- Titles Come From Controller -->
<?= $this->section('title') ?>
<?php echo strtoupper($title); ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- All Content goes Here without <body></body> -->
<br /><br /><br /><br /><br /><br />
<div class="center">
    <!-- This for display position, picture, email, score  -->
    <?php foreach ($points as $index => $point): ?>

    <!-- Display for top 3 position  -->
    <?php if ($index < 3): ?>
    <div class="top3">
        <!-- First position  -->
        <?php if ($index === 0): ?>
        <div class="one item">
            <div class="crown"></div>
            <div class="position"><?= $index + 1 ?></div>
            <div class="pic"></div>
            <div class="name">
                <b><?= $point['email'] ?></b>
            </div>
            <div class="score"><?= $point['point'] ?></div>
        </div>
        <?php endif; ?>

        <!-- Second position  -->
        <?php if ($index === 1): ?>
        <div class="two item">
            <div class="position"><?= $index + 1 ?></div>
            <div class="pic"></div>
            <div class="name">
                <b><?= $point['email'] ?></b>
            </div>
            <div class="score"><?= $point['point'] ?></div>
        </div>
        <?php endif; ?>

        <!-- Third position  -->
        <?php if ($index === 2): ?>
        <div class="three item">
            <div class="position"><?= $index + 1 ?></div>
            <div class="pic"></div>
            <div class="name">
                <b><?= $point['email'] ?></b>
            </div>
            <div class="score"><?= $point['point'] ?></div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Display for under top 3   -->
    <?php else: ?>
    <div class="list">
        <br />
        <div class="item">
            <div class="position"><?= $index + 1 ?></div>
            <div class="pic"></div>
            <div class="name">
                <b><?= $point['email'] ?></b>
            </div>
            <div class="score"><?= $point['point'] ?></div>
        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('additionalScript') ?>
<!--Additional JS goes Here-->
<?= $this->endSection() ?>
