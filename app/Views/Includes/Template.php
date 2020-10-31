<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('css/Navbar.css') ?>">
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="<?= base_url('js/moment.js')?>"></script>
    <script src="<?= base_url('js/moment-with-locales.min.js')?>"></script>
    <title> <?= $this->renderSection('title'); ?> </title>
    <?= $this->renderSection('customCSS'); ?>
    <?= $this->renderSection('customJS'); ?>
    <?= $this->include('Includes/Navbar'); ?>
</head>
<body>
<?= $this->renderSection('content'); ?>
</body>
<?= $this->renderSection('additionalScript'); ?>
<script>
//emulate active white border and black font on active pages navbar
$('document').ready(function(){
    var li_active = '<?php echo("li-".$title) ?>' ;
    var a_active = '<?php echo("a-".$title) ?>' ;
    document.getElementById(li_active).classList.add("active");
    document.getElementById(a_active).classList.add("active");
    document.getElementById(a_active).classList.add("font-black");
});
</script>