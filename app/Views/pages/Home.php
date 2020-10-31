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
<br><br><br><br>
    <form action='<?=base_url("/CheckTappedIn")?>' method="post">
        <?= csrf_field()?>
        <button name="TapButton" id="TapButton" type="submit" <?php if($disableButton) { echo("disabled"); } ?>  ><?= $buttonTitle ?></button>
    </form>
    <span id="currentTime"></span><br>
    <span id="employeeName"><?= $EmployeeName ?></span><br>
    <span id="currentDate"></span><br>
<?= $this->endSection(); ?>

<?= $this->section('additionalScript');?>
    <!--Additional JS goes Here-->
    <script>
        $('document').ready(function(){
            updateTime();
            currDate = moment().format("dddd, DD MMMM YYYY");;
            $('#currentDate').html(currDate);
        });
        function updateTime(){
            // un-comment one of the var currTime below,
            //var currTime = moment('07:31', 'HH:mm').toArray(); $('#currentTime').html(currTime['3']+":"+currTime['4']); // for testing only , u can decide the time by yourself
            var currTime = moment().format("HH:mm"); $('#currentTime').html(currTime); //real time

            if( moment(currTime, 'HH:mm') < moment('07:30', 'HH:mm') ){
                $('#TapButton').prop('disabled',true);
            }
        }
        $(function(){

            setInterval(updateTime, 1000*1);
        });
    </script>

<?= $this->endSection(); ?>
