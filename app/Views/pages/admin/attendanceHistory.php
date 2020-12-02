<?= $this->extend('Includes/Template'); ?>

<?= $this->section('customCSS');?>
<!-- Custom CSS goes Here-->

<!-- Custom Home CSS -->
<link rel="stylesheet" type = "text/css"  href="<?php echo base_url('css/Home.css'); ?>">

<!-- Custom Leaderboard CSS -->
<link rel="stylesheet" type = "text/css"  href="<?php echo base_url('css/Leaderboard.css'); ?>">

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

<!--    loop to show requester name-->
<br><br><br><br><br>
<?php foreach ($employee as $index => $currEmployee) :?>
    <div class="employee_name" name="<?= $index?>" employee_name="<?= $currEmployee['employee_name'] ?>" employee_email="<?= $currEmployee['employee_email']?> ">
        <?php echo $currEmployee['employee_name'] .' - '.  $currEmployee['division_name'] ?>
    </div>
    <br>
<?php endforeach;?>

<!--    div to contains all attendance history info-->
<div id="container-history-attendance" style="color: red"></div>

<br>

<div id="mdp-demo"></div> <!--calendar div-->-->
<button name="checkAttendanceHistory" id="checkAttendanceHistory" class="btn-checkin-checkout btn-check-history-by-date">Check</button>

<?= $this->endSection(); ?>

<?= $this->section('additionalScript');?>
<!--Additional JS goes Here-->
<script>
    var clickedEmployeeEmail = "";
    var clickedDates = "";
    $('#mdp-demo').multiDatesPicker({
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [(day != 0),  ''];
        },
        maxPicks: 1,
    });

    //send ajax after admin clicked on requester name, to get the requested attendance date and show attendance history
    $('.employee_name').on('click',function (){
        $('#container-history-attendance').empty();
        clickedEmployeeEmail = $(this).attr("employee_email");
        var url = '<?=base_url("/admin/fetchAttendanceHistoryByEmployee")?>?email='+clickedEmployeeEmail;
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
    });

    //send ajax after admin clicked checked button,
    $('.btn-check-history-by-date').on('click',function (){
        $('#container-history-attendance').empty();
        clickedDates = $('#mdp-demo').multiDatesPicker('value');
        var url = '<?=base_url("/admin/fetchAttendanceHistoryByDate")?>?date='+clickedDates;
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
                        span = "<span>"+ response[i]['employee_name'];
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
    });
</script>
<?= $this->endSection(); ?>
