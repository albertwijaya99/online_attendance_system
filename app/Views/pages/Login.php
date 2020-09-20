<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Bootstrap CSS - Show Password -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Bootstrap JS - Show Password -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/bootstrap-show-password@1.2.1/dist/bootstrap-show-password.min.js"></script>

    <!-- Custom Login CSS -->
    <link rel="stylesheet" type = "text/css"  href="<?php echo base_url('css/Login.css'); ?>">
    <title>Online Attendance System</title>

  </head>

<body>
<div class="container">
<img src="<?php echo base_url('assets/images/docotel-logo.png'); ?>" class="img-docotel-logo">
<img src="<?php echo base_url('assets/images/on-login.svg'); ?>" class="center img-vector">
<h2>Online Attendance</h2>
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <!-- <h5 class="card-title text-center">Sign In</h5> -->
            <form class="form-signin" action="<?= base_url('/checkLogin');?>" method="post">
             <label for="loginEmail">Email address</label>
              <div class="form-label-group">
                <input type="email" name="loginEmail" id="loginEmail" class="form-control" placeholder="Email address" required autofocus>
              </div>

               <label for="loginPassword">Password</label>
              <div class="form-label-group">
                <input type="password" name="loginPassword" id="loginPassword" class="form-control" placeholder="Password" required>
              </div>
              <button class="btn btn-lg btn-submit btn-block text-uppercase" type="submit">Login</button>
           </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
  $(function() {
    $('#loginPassword').password()
  })
</script>
</body>

