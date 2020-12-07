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
             <span style="cursor: pointer" id="seeHistoryText"> <u> See History</u></span>

             <div class="modal" id="showAttendanceHistory" tabindex="-1" role="dialog">
                 <div class="modal-dialog" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title">History Attendance</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                             </button>
                         </div>
                         <div class="modal-body">
                             <!--    div to contains all attendance history info-->
                             <div id="container-history-attendance" style="color: red"></div>
                             <br>
                         </div>
                             <!-- End of Change profile picture form -->
                         </div>
                     </div>
                 </div>
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
        $('#seeHistoryText').on('click',function (){
            $('#showAttendanceHistory').modal('show');
            var email = '<?= session()->get("Email") ?>' ;
            var url = '<?=base_url("/admin/fetchAttendanceHistoryByEmployee")?>?email='+email;
            // fetch data (send ajax request)
            fetch(url,{
                method: "GET",
                headers: {
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest"
                },
            })
                .then(response => response.json())
                .then(response => {
                    console.log(response)
                    var span = "";
                    if(response.length === 0){
                        span = "<span> no attendance history found </span><br>";
                        $('#container-history-attendance').append(span);
                    }
                    else {
                        for(var i = 0 ; i<response.length ; i++){
                            span = "<span>"+ response[i]['date'];
                            span += " | "+ moment(response[i]['check_in_time']).format('LT');
                            (response[i]['check_out_time'] === null) ? span += " | - "  : span += " | " + moment(response[i]['check_out_time']).format('LT');
                            span += "</span><br>";
                            $('#container-history-attendance').append(span);
                        }
                    }

                })
                .catch(function(err) {
                    console.log('Fetch Error :-S', err);
                });
        })
    </script>

<?= $this->endSection(); ?>
