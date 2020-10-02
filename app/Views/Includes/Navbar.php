<!--Navbar-->
<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container nav-container">
            <div class="col-sm-12 col-lg-5">
                <img src="<?= base_url('assets/images/docotel-logo-navbar.png')?>" class="img-logo">
            </div>

            <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbarSupportedContent" class="navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" id="li-home">          <a href="#" class="font-white nav-link font-weight-bold" id="a-home">Home</a></li>
                    <li class="nav-item" id="li-leaderboard">   <a href="#" class="font-white nav-link font-weight-bold" id="a-leaderboard">LeaderBoard</a></li>
                    <li class="nav-item" id="li-paidleave">     <a href="#" class="font-white nav-link font-weight-bold" id="a-paidleave">PaidLeave</a></li>
                    <li class="nav-item" id="li-profile">       <a href="#" class="font-white nav-link font-weight-bold" id="a-profile">Profile</a></li>

                    <?php if(session()->get('isAdmin') === '1'): //only showed on admin account?>
                    <li class="nav-item" id="li-admin">         <a href="#" class="font-white nav-link font-weight-bold" id="a-admin">Admin</a></li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
</header>