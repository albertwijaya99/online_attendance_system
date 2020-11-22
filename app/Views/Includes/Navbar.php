<!--Navbar-->
<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container nav-container">
            <div>
                <img src="<?= base_url('assets/images/docotel-logo-navbar.png')?>" class="img-logo">
            </div>

            <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbarSupportedContent" class="navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" id="li-home">          <a href="<?= base_url('/') ?>" class="font-white nav-link font-weight-bold" id="a-home">Home</a></li>
                    <li class="nav-item" id="li-leaderboard">   <a href="<?= base_url('leaderboard')?>" class="font-white nav-link font-weight-bold" id="a-leaderboard">LeaderBoard</a></li>
                    <li class="nav-item" id="li-paidleave">     <a href="<?= base_url('paidLeave')?>" class="font-white nav-link font-weight-bold" id="a-paidleave">Leave</a></li>
                    <li class="nav-item" id="li-profile">       <a href="<?= base_url('profile') ?>" class="font-white nav-link font-weight-bold" id="a-profile">Profile</a></li>

                    <?php if(session()->get('isAdmin') === '1'): //only showed on admin account?>
                    <li class="nav-item dropdown" id="li-admin">
                        <a href="#" class="font-white nav-link dropdown-toggle font-weight-bold" id="a-admin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="<?= base_url('/admin/attendanceHistory')?>">Employee Attendance History</a>
                            <a class="dropdown-item" href="<?= base_url('/admin/leaveHistory')?>">Employee Leave History</a>
                            <a class="dropdown-item" href="<?= base_url('/admin/showLeaveRequest')?>">Employee Leave Request</a>
                        </div>

                    </li>



                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
</header>
