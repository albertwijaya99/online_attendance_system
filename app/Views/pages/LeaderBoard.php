<?= $this->extend('includes/Template'); ?>

<?= $this->section('customCSS');?>
<!-- Custom CSS goes Here-->

<!-- Custom Profile CSS -->
<link rel="stylesheet" type = "text/css"  href="<?php echo base_url('css/Profile.css'); ?>">
<?= $this->endSection(); ?>

<?= $this->section('customJS');?>
<!-- Custom JS goes Here-->
<?= $this->endSection(); ?>

<!-- Titles Come From Controller -->
<?= $this->section('title');?>
<?php echo(strtoupper($title)); ?>
<?= $this->endSection(); ?>

<?= $this->section('content');?>
<!-- All Content goes Here without <body></body> -->
    <br><br><br><br><br>
    <ul>

        <?php foreach ($points as $point) : ?>

            <li><?= $point['email'] ?> - <?= $point['point'] ?> point</li>

        <?php endforeach ?>

    </ul>
<?= $this->endSection(); ?>

<?= $this->section('additionalScript');?>
<!--Additional JS goes Here-->
<?= $this->endSection(); ?>
