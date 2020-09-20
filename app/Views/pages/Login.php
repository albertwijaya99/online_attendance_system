<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    
    <!-- Custom Login CSS -->
    <link rel="stylesheet" type = "text/css"  href="<?php echo base_url('css/Login.css'); ?>">
    <title>Online Attendance System</title>

  </head>

<body>
<div class="container">
<img src="<?php echo base_url('assets/images/docotel-logo.png'); ?>" class="img-docotel-logo">
<img src="<?php echo base_url('assets/images/on-login.svg'); ?>" class="center img-vector">
<h1>Online Attendance</h1>
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <!-- <h5 class="card-title text-center">Sign In</h5> -->
            <form class="form-signin" action="<?= base_url('/checkLogin');?>" method="post">
              <div class="form-label-group">
                <input type="email" name="loginEmail" id="loginEmail" class="form-control" placeholder="Email address" required autofocus>
                <label for="loginEmail">Email address</label>
              </div>

              <div class="form-label-group">
                <input type="password" name="loginPassword" id="loginPassword" class="form-control" placeholder="Password" required>
                <label for="loginPassword">Password</label>
              </div>
              <input type="checkbox" class="checkbox-show-password" onclick="Toggle()"> 
              <label class="show-password">Show password</label>
              <button class="btn btn-lg btn-submit btn-block text-uppercase" type="submit">Login</button>
           </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script> 
    // Change the type of input to password or text 
        function Toggle() { 
            var temp = document.getElementById("loginPassword"); 
            if (temp.type === "password") { 
                temp.type = "text"; 
            } 
            else { 
                temp.type = "password"; 
            } 
        } 
</script> 
</body>

