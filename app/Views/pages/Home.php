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
    <form action='<?=base_url("/CheckTappedIn")?>' method="post">
        <?= csrf_field()?>
        <button name="TapButton" id="TapButton" type="submit" <?php if($disableButton) echo("disabled") ?>  ><?= $buttonTitle ?></button>
    </form>
    <span id="currentTime"></span>
<?= $this->endSection(); ?>

<?= $this->section('additionalScript');?>
    <!--Additional JS goes Here-->
    <script>
        // function pressButton(){
        //     var today = new Date();
        //     var currTime = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        //     var button = document.getElementById('TapButton').innerText;
        //     if(button === 'CHECK-IN' && currTime>'08:30:00'  && currTime<'09:30:00' ){
        //
        //     }
        //     else{
        //         alert('gagal');
        //     }
        // }

        $('document').ready(function(){
            updateTime();
        });
        function updateTime(){
            var today = new Date();
            //var currTime = '8:31'; // for testing only
            //var currTime = today.getHours() + ":" + today.getMinutes(); //current real time
            $('#currentTime').html(currTime);
            //comment until ask SA about tapping  rules
            // if( currTime <= '8:30' ){
            //     console.log("gaboleh tap in")
            //     $('#TapButton').prop('disabled',true);
            // }
        }
        $(function(){
            setInterval(updateTime, 1000*1000);
        });
    </script>

<?= $this->endSection(); ?>
