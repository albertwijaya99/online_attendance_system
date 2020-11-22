<?= $this->extend('includes/Template'); ?>

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
    <br><br><br><br><br><br><br><br>

    Remaining Day Off : <?= $remaining_leaves?> <br>

    <?php foreach ($history_leaves as $item):?>
        <?php echo $item['leave_date'].' - '.$item['status'] .' - '.$item['requester_note'] .' - '. $item['approver_note']; ?>
        <br>
    <?php endforeach;?>

    <button name="TapButton" id="TapButton" class="btn-checkin-checkout" data-toggle="modal" data-target="#leaveModal">Apply Leave</button>
    <div class="modal" tabindex="-1" role="dialog" id="leaveModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <span style="display: none; color: red" id="errMsgLeaveType">Please Choose Leave Type</span>
                    <button onclick="determineLeaveType('paid')" id="paidButton" class="leaveTypeButton btn btn-outline-primary ">Paid</button>
                    <button onclick="determineLeaveType('unpaid')" id="unpaidButton" class="leaveTypeButton btn btn-outline-primary">Unpaid</button>
                    <button onclick="determineLeaveType('sick')" id="sickButton" class="leaveTypeButton btn btn-outline-primary">Sick</button>
                    <br>
                    <div id="mdp-demo"></div>
                    <br>
                    <span style="display: none; color: red" id="errMsgLeaveReason">Please Fill Leave Reason</span>
                    <textarea id="leaveReason"> </textarea>
                    <br>
                    <button id="submitForm" class="btn-checkin-checkout" onclick="submitFormLeave()">Confirm</button>

                    <form action='<?=base_url("/RequestLeave")?>' method="post" name="formRequestLeave" id="formRequestLeave">
                        <?= csrf_field()?>
                        <input type="hidden" name="leave_type" id="leave_type">
                        <input type="hidden" name="leave_date_range" id="leave_date_range">
                        <input type="hidden" name="leave_reason" id="leave_reason">
                    </form>
                </div>
            </div>
        </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('additionalScript');?>
<!--Additional JS goes Here-->
<script>
    var leaveTypeGlobal = "";
    var leaveReasonGlobal = "";
    var leaveDateGlobal = "";
    $('#mdp-demo').multiDatesPicker({
        beforeShowDay: $.datepicker.noWeekends,
        maxPicks: <?= $remaining_leaves?>
    });

    function submitFormLeave(){
        //check if user haven't choose leave type
        if(leaveTypeGlobal === "") $('#errMsgLeaveType').css('display','block') ;

        //check if user haven't fill leave reason
        if($('#leaveReason').val() === " ") {
            $('#errMsgLeaveReason').css('display','block');
        }
        else {
            leaveReasonGlobal = $('#leaveReason').val();
            $('#errMsgLeaveReason').css('display','none')
        }

        //get calendar value
        var leaveDateGlobal = $('#mdp-demo').multiDatesPicker('value');

        //append value to hidden form
        $('#leave_date_range').val(leaveDateGlobal);
        $('#leave_reason').val(leaveReasonGlobal);

        if(leaveTypeGlobal != "" && leaveReasonGlobal != "" && leaveDateGlobal != "") $('#formRequestLeave').submit(); //submit after everything filled
    }
    function determineLeaveType(leaveType){
        $('.leaveTypeButton').removeClass("btn-outline-success");
        leaveTypeGlobal = leaveType;
        btnId = leaveType + 'Button';
        $('#'+btnId).removeClass("btn-outline-primary");
        $('#'+btnId).addClass("btn-outline-success");
        $('#leave_type').val(leaveType);
        $('#errMsgLeaveType').css('display','none');
    }
</script>

<?= $this->endSection(); ?>
