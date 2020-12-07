<?= $this->extend('Includes/Template'); ?>

<?= $this->section('customCSS');?>
<!-- Custom CSS goes Here-->

<!-- Custom PaidLeave CSS -->
<link rel="stylesheet" type = "text/css"  href="<?php echo base_url('css/PaidLeave.css'); ?>">
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

       <div class="row no-gutters">
         <div class="col">
         <br><br>
         <div class="row" style="padding-left: 210px;">
             <h1>Remaining Day Off: </h1>
            <div class="card">
            <h1><?= $remaining_leaves?></h1>
            </div>
         </div>

         <div class="card-table">
         <h1 style="color: black; font-size:20px;">Leave History</h1>
         <div class="table-container">
             <table id="tablepaidleave">
             <thead>
                        <tr>
                           <th style="color:black;">Date</th>
                           <th style="color:black;">Status</th>
                           <th style="color:black;">Reason</th>
                           <th style="color:black;">Note</th>
                        </tr>
             </thead>
             <tbody>
                         <?php foreach ($history_leaves as $item):?>

                        <tr>

                        <td style="color:black;">
                            <?php echo $item['leave_date'];?>
                            </td>
                          <td style="color:black;">
                            <?php echo $item['status'];?>
                         </td>
                         <td style="color:black;">
                            <?php echo $item['requester_note'];?>
                       </td>
                         <td style="color:black;">
                          <?php echo $item['approver_note'];?>
                        </td>
                              <?php endforeach;?>
                        </tr>
               </tbody>
             </table>
            </div>
         </div>

             <button name="TapButton" id="TapButton" class="btn-checkin-checkout" data-toggle="modal" data-target="#leaveModal">Apply Leave</button>
          </div>
          <div class="col">
              <img src="<?php echo base_url('assets/images/on-paidleave.svg'); ?>" class="img-vector">
          </div>
       </div>


    <div class="modal" tabindex="-1" role="dialog" id="leaveModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <span style="color: black"><mark>*</mark>Select Leave Type: </span><br>
                    <button onclick="determineLeaveType('paid')" id="paidButton" class="leaveTypeButton btn btn-outline-primary">Paid</button>
                    <button onclick="determineLeaveType('unpaid')" id="unpaidButton" class="leaveTypeButton btn btn-outline-primary">Unpaid</button>
                    <button onclick="determineLeaveType('sick')" id="sickButton" class="leaveTypeButton btn btn-outline-primary">Sick</button>
                    <span style="display: none; color: red; font-size: 12px" id="errMsgLeaveType">Please choose leave type</span>
                    <br>
                    <div style=" padding: 20px;">
                    <div id="mdp-demo" class="date-picker"></div>
                    </div>
                    <span style="color: black; position: relative; top: 260px"><mark>*</mark>Leave Reason: </span><br>
                    <textarea id="leaveReason"> </textarea>
                    <span style="display: none; color: red;font-size: 12px" id="errMsgLeaveReason">Please fill leave reason</span>

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
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [(day != 0),  ''];
        },
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
