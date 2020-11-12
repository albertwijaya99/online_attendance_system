<?= $this->extend('Includes/Template'); ?>

<?= $this->section('customCSS');?>
<!-- Custom CSS goes Here-->

<!-- Custom Home CSS -->
<link rel="stylesheet" type = "text/css"  href="<?php echo base_url('css/Home.css'); ?>">
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
    <div class="container">
        <div class="row no-gutters">
        <div class="col">
        <br>
            <img src="<?php echo base_url('assets/images/home.svg'); ?>" class="img-vector">
        </div>
         <div class="col" style="padding-top: 55px; padding-left: 80px;">
            <div class="box">
                <b><span id="employeeName">Hi, <?= $EmployeeName ?>!</span></b><br>
                <h1><b id="currentTime"></b></h1><br>
                <span id="currentDate"></span><br>
                <form action='<?=base_url("/CheckTappedIn")?>' method="post">
                    <?= csrf_field()?>
                    <button name="TapButton" id="TapButton" type="submit" class="btn-checkin-checkout"
                    <?php if($disableButton) { echo("disabled"); } ?>  ><?= $buttonTitle ?></button>
                </form>
            </div>
         </div>
        </div>
    </div>
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
