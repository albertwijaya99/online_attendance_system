<?= $this->extend('Includes/Template'); ?>

<?= $this->section('customCSS');?>
<!-- Custom CSS goes Here-->

<!-- Custom Admin CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/Admin.css'); ?>" />
<?= $this->endSection() ?>

<?= $this->section('customJS');?>
<!-- Custom JS goes Here-->
<?= $this->endSection(); ?>

<!-- Titles Come From Controller -->
<?= $this->section('title');?>
<?php echo(strtoupper($title)); ?>
<?= $this->endSection(); ?>

<?= $this->section('content');?>
<!-- All Content goes Here without <body></body> -->
<br /><br /><br /><br /><br /><br />
<h1 class="center">Approval Leave</h1>
<div class="card-table-leave-request">
  <div class="row no-gutters">
    <div class="col" style="padding: 30px;">
      <div class="table-container">
        <table id="tablepaidleave" class="table-flex">
          <thead>
            <tr>
              <th style="color: black; width: 40px;">No.</th>
              <th style="color: black;">Name</th>
            </tr>
          </thead>
          <tbody>
            <!--    loop to show requester name-->
            <?php foreach ($requesterEmailList as $index =>
            $requesterEmail) :?>
            <tr>
              <td style="color: black; width: 40px;">
                <?php echo $index + 1 ?>
              </td>

              <td style="color: black;">
                <div class="requester_name" name="<?= $index?>" id="<?= $requesterEmail['requester_note'] ?>" requesterEmail="<?= $requesterEmail['requester']?> ">
                  <?php echo $requesterEmail['requester'] ?>
                </div>
                <?php endforeach; ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col">
      <!--    loop to create calender as much as requester name-->
      <?php foreach ($requesterEmailList as $index =>
      $requesterEmail) :?>
      <div id="mdp-<?= $index ?>" class="mdpLeaveDate center" style="top: 50%;"></div>
      <?php endforeach;?>
    </div>
  </div>
  <!--    requester notes-->
  <span id="note" style="display: none;">Note:</span>
  <span id="spanRequesterNotes" style="color: red;"></span>
  <br />
  <br />

  <!--    button action to acc or decline-->
  <div class="row">
    <div class="col" style="padding-left: 400px;">
      <button class="btn-action approve-button" style="display: none;" id="btn-accept">
        <img src="<?php echo base_url('assets/images/check.png'); ?>" style="width: 18px;" />
      </button>
    </div>
    <div class="col" style="padding-right: 400px;">
      <button class="btn-action decline-button" style="display: none;" id="btn-decline" data-toggle="modal" data-target="#rejectionModal">
        <span style="color: white;">X</span>
      </button>
    </div>
    <div></div>
  </div>

  <!--    form to submit action-->
  <form action='<?=base_url("/admin/respondLeaveRequest")?>' method="post" name="formLeaveResponse" id="formLeaveResponse">
    <?= csrf_field()?>
    <input type="hidden" name="requesterEmail" id="requesterEmail" />
    <input type="hidden" name="requesterNote" id="requesterNote" />
    <input type="hidden" name="adminResponse" id="adminResponse" />
    <input type="hidden" name="declineReason" id="declineReason" />
  </form>

  <div class="modal" tabindex="-1" role="dialog" id="rejectionModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" align="center">
          <h5 class="modal-title" style="color: black;">Reason of decline</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <textarea id="declineReasonTA" name="declineReasonTA"> </textarea>
          <br />
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

    // Css when name selected
    $(".requester_name").click(function () {
      // When name is clicked,add color to active (set color to black)
      $(".requester_name").css("color", "black");

      // When name is not clicked, remove class active
      $(".requester_name").removeClass("active");
      $(this).addClass("active");
    });

    //send ajax after admin clicked on requester name, to get the requested leave date and show the filled calendar
    $(".requester_name").on("click", function () {
      clickedRequesterEmail = $(this).attr("requesterEmail");
      clickedRequesterNote = this.id;
      clickedIndex = $(this).attr("name");
      var url = '<?=base_url("/admin/fetchSelectedLeaveRequest")?>?notes=' + clickedRequesterNote + "&email=" + clickedRequesterEmail;
      $("#spanRequesterNotes").html(clickedRequesterNote);
      // fetch data (send ajax request)
      fetch(url, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
        },
      })
        .then((response) => response.json())
        .then((response) => {
          addDatesValues = [];
          addDatesValues = response;
          $(".mdpLeaveDate").multiDatesPicker("destroy");
          $("#mdp-" + clickedIndex).multiDatesPicker({
            beforeShowDay: function (date) {
              var day = date.getDay();
              return [day != 0, ""];
            },
            addDates: addDatesValues,
          });
          $(".btn-action").css("display", "");
        })
        .catch(function (err) {
          console.log("Fetch Error :-S", err);
        });
    });

    //button accept handler
    $("#btn-accept").on("click", function () {
      $("#requesterNote").val(clickedRequesterNote);
      $("#requesterEmail").val(clickedRequesterEmail);
      $("#adminResponse").val("accept");
      $("#formLeaveResponse").submit();
    });

    //button confirm rejection handler (after fill the decline reason)
    $("#btn-confirm-rejection").on("click", function () {
      var declineReason = $("#declineReasonTA").val();
      $("#declineReason").val(declineReason);
      $("#adminResponse").val("decline");
      $("#requesterNote").val(clickedRequesterNote);
      $("#requesterEmail").val(clickedRequesterEmail);
      $("#formLeaveResponse").submit();
    });

    //Note when list by employee clicked
    $(".requester_name").on("click", function () {
      $("#note").show();
    });
  </script>
  <?= $this->endSection(); ?>
</div>
