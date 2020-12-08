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

<!--    Loop to show requester name-->
<br /><br /><br /><br /><br />
<h1 class="center">Leave History</h1>
<div class="card-table">
  <div class="row no-gutters">
    <div class="col">
      <div style="padding: 20px;">
        <div class="wrap">
          <label>
            <input type="radio" name="radioBtn" id="employee-segment" checked />
            <div class="bg"></div>
            <span class="label">Employees</span>
          </label>
          <label>
            <input type="radio" name="radioBtn" id="date-segment" />
            <div class="bg"></div>
            <span class="label">Date</span>
          </label>
        </div>
      </div>

      <div class="table-container">
        <table id="tablepaidleave" class="table-flex">
          <thead>
            <tr>
              <th style="color: black;">Name</th>
              <th style="color: black;">Position</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($employee as $index =>
            $currEmployee): ?>
            <tr>
              <td style="color: black;">
                <div class="employee_name" name="<?= $index ?>" employee_name="<?= $currEmployee['employee_name'] ?>" employee_email="<?= $currEmployee['employee_email'] ?>">
                  <?php echo $currEmployee['employee_name']; ?>
                  <td style="color: black;">
                    <?php echo $currEmployee['division_name']; ?>
                  </td>
                </div>
                <?php endforeach; ?>
              </td>
            </tr>
          </tbody>
        </table>
        <div id="mdp-demo" class="center" style="display: none; top: 70%;"></div>
        <!--calendar div -->
        <button name="checkLeaveHistory" id="checkLeaveHistory" class="btn-checkin-checkout btn-check-history-by-date center" style="display: none; top: 117%;">Check</button>
      </div>
    </div>
    <div class="col">
      <h1 style="color: black; padding-top: 30px;">History</h1>
      <!--    div to contains all attendance history info-->
      <div id="container-history-leave" class="center-table" style="color: red;"></div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('additionalScript');?>
<!--Additional JS goes Here-->
<script>
  var clickedEmployeeEmail = "";
  var clickedDates = "";
  $("#mdp-demo").multiDatesPicker({
    beforeShowDay: function (date) {
      var day = date.getDay();
      return [day != 0, ""];
    },
    maxPicks: 1,
  });

  //send ajax after admin clicked on requester name, to get the requested leave date and show leaves history
  $(".employee_name").on("click", function () {
    $("#container-history-leave").empty();
    clickedEmployeeEmail = $(this).attr("employee_email");
    var url = '<?=base_url("/admin/fetchEmployeeLeaveHistory")?>?email=' + clickedEmployeeEmail;
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
        var span = "";
        var table = "";
        if (response.length === 0) {
          span = "<span> No leaves history found! </span><br>";
          $("#container-history-leave").append(span);
        } else {
          for (var i = 0; i < response.length; i++) {
            table = "<div class='table-container'> ";
            table += "<table id='tablepaidleave' class='table-flex'>";
            table += "<thead>";
            table += "<tr><th style='color: black;'>Date</th><th style='color: black;'>Reason</th><th style='color: black;'>Status</th></tr>";
            table += "</thead>";
            table += "<tbody>";
            for (var i = 0; i < response.length; i++) {
              table += "<tr><td style='color: black;'>" + response[i]["leave_date"] + "</td>";
              table += "<td style='color: black;'>";
              response[i]["approver_note"] === null ? (table += "-") : (table += response[i]["approver_note"]);
              table += "</td>";
              table += "<td style='color: black;'>" + response[i]["status"] + "</td>";
              +"</tr>";
            }
            table += "</tbody>";
            table += "</table>";
            table += "</div>";
            $("#container-history-leave").append(table);
          }
        }
      })
      .catch(function (err) {
        console.log("Fetch Error :-S", err);
      });
  });

  //send ajax after admin clicked checked button,
  $(".btn-check-history-by-date").on("click", function () {
    $("#container-history-leave").empty();
    clickedDates = $("#mdp-demo").multiDatesPicker("value");
    var url = '<?=base_url("/admin/fetchLeaveHistoryByDate")?>?date=' + clickedDates;
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
        console.log(response);
        var span = "";
        var table = "";
        if (response.length === 0) {
          span = "<span> No leaves history found! </span><br>";
          $("#container-history-leave").append(span);
        } else {
          for (var i = 0; i < response.length; i++) {
            table = "<div class='table-container'> ";
            table += "<table id='tablepaidleave' class='table-flex'>";
            table += "<thead>";
            table += "<tr><th style='color: black;'>Name</th><th style='color: black;'>Reason</th><th style='color: black;'>Status</th></tr>";
            table += "</thead>";
            table += "<tbody>";
            for (var i = 0; i < response.length; i++) {
              table += "<tr><td style='color: black;'>" + response[i]["employee_name"] + "</td>";
              table += "<td style='color: black;'>";
              response[i]["approver_note"] === null ? (table += "-") : (table += response[i]["approver_note"]);
              table += "</td>";
              table += "<td style='color: black;'>" + response[i]["status"] + "</td>";
              +"</tr>";
            }
            table += "</tbody>";
            table += "</table>";
            table += "</div>";
            $("#container-history-leave").append(table);
          }
        }
      })
      .catch(function (err) {
        console.log("Fetch Error :-S", err);
      });
  });

  //segment when list by date clicked
  $("#date-segment").on("click", function () {
    $("#tablepaidleave").hide();
    $("#mdp-demo").css("display", "block");
    $("#checkLeaveHistory").css("display", "block");
  });

  //segment when list by employee clicked
  $("#employee-segment").on("click", function () {
    $("#tablepaidleave").show();
    $("#mdp-demo").css("display", "none");
    $("#checkLeaveHistory").css("display", "none");
  });
</script>
<?= $this->endSection(); ?>
