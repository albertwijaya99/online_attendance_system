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
    <br><br><br><br><br><br>
<!--    loop to show requester name-->
    <?php foreach ($requesterEmailList as $index => $requesterEmail) :?>
        <div class="requester_name" name="<?= $index?>" id="<?= $requesterEmail['requester_note'] ?>" requesterEmail="<?= $requesterEmail['requester']?> ">
            <?php echo $requesterEmail['requester'] ?>
        </div>
    <br>
    <?php endforeach;?>

<!--    loop to create calender as much as requester name-->
    <?php foreach ($requesterEmailList as $index => $requesterEmail) :?>
        <div id="mdp-<?= $index ?>" class="mdpLeaveDate" style="alignment: center"></div>
    <?php endforeach;?>

    <br><br>
<!--    requester notes-->
    <span id="spanRequesterNotes" style="color: red"></span>
    <br><br>

<!--    button action to acc or decline-->
    <button class="btn btn-success btn-action" style="display: none" id="btn-accept" >OK</button>
    <button class="btn btn-danger btn-action" style="display: none"  id="btn-decline" data-toggle="modal" data-target="#rejectionModal">NO</button>
<!--    form to submit action-->
    <form action='<?=base_url("/admin/respondLeaveRequest")?>' method="post" name="formLeaveResponse" id="formLeaveResponse">
        <?= csrf_field()?>
        <input type="hidden" name="requesterEmail" id="requesterEmail">
        <input type="hidden" name="requesterNote" id="requesterNote">
        <input type="hidden" name="adminResponse" id="adminResponse">
        <input type="hidden" name="declineReason" id="declineReason">
    </form>

    <div class="modal" tabindex="-1" role="dialog" id="rejectionModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <h5 class="modal-title" style="color: black">Reason of decline</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="declineReasonTA" name="declineReasonTA"> </textarea>
                    <br>
                    <button class="btn-checkin-checkout btn-confirm-rejection" id="btn-confirm-rejection">Confirm</button>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection(); ?>

<?= $this->section('additionalScript');?>
<!--Additional JS goes Here-->
    <script>
        var clickedRequesterNote = "";
        var clickedIndex = "";
        var clickedRequesterEmail = "";
        var addDatesValues;

        //send ajax after admin clicked on requester name, to get the requested leave date and show the filled calendar
        $('.requester_name').on('click',function (){
            clickedRequesterEmail = $(this).attr("requesterEmail");
            clickedRequesterNote = this.id;
            clickedIndex = $(this).attr("name");
            var url = '<?=base_url("/admin/fetchSelectedLeaveRequest")?>?notes='+clickedRequesterNote+'&email='+clickedRequesterEmail;
            $('#spanRequesterNotes').html(clickedRequesterNote);
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
                    addDatesValues = [];
                    addDatesValues = response;
                    $('.mdpLeaveDate').multiDatesPicker('destroy');
                    $('#mdp-'+clickedIndex).multiDatesPicker({
                        beforeShowDay: function(date) {
                            var day = date.getDay();
                            return [(day != 0),  ''];
                        },
                        addDates: addDatesValues,
                    });
                    $('.btn-action').css("display","");

                })
                .catch(function(err) {
                    console.log('Fetch Error :-S', err);
                });
        });

        //button accept handler
        $('#btn-accept').on('click',function (){
            $('#requesterNote').val(clickedRequesterNote);
            $('#requesterEmail').val(clickedRequesterEmail);
            $('#adminResponse').val("accept");
            $('#formLeaveResponse').submit();
        })

        //button confirm rejection handler (after fill the decline reason)
        $('#btn-confirm-rejection').on('click',function (){
            var declineReason = $('#declineReasonTA').val()
            $('#declineReason').val(declineReason);
            $('#adminResponse').val("decline");
            $('#requesterNote').val(clickedRequesterNote);
            $('#requesterEmail').val(clickedRequesterEmail);
            $('#formLeaveResponse').submit();

        })


    </script>
<?= $this->endSection(); ?>
