<?= $this->extend('Includes/Template'); ?>

<?= $this->section('customCSS');?>
    <!-- Custom Profile CSS -->
    <link rel="stylesheet" type = "text/css"  href="<?php echo base_url('css/Profile.css'); ?>">
<?= $this->endSection(); ?>

<?= $this->section('customJS');?>
<?= $this->endSection(); ?>

<?= $this->section('title');?>
    <?php echo(strtoupper($title)); ?>
<?= $this->endSection(); ?>

<?= $this->section('content');?>
<br><br>
<div class="container">
    <div class="row no-gutters">
        <div class="col">
            <img src="<?php echo base_url('assets/images/on-profile.svg'); ?>" class="img-vector">
            <img src="<?php echo base_url('assets/images/plant-decor.png'); ?>" class="img-vector-decor">
        </div>
        <div class="col">
          <div class="box">
            <img src="<?php echo base_url('assets/images/on-profile-card.svg'); ?>" class="img-vector-card">
                <?php if(isset($Employee)):?>
                    <?php foreach ($Employee as $item): ?>
                        <div class="text">
                            <div class="padding">
                                <div class="padding-bottom">
                                    <img onclick="ChangeProfilePicture()"
                                    src="<?php echo(base_url().'/Uploads/ProfilePicture/'.md5(session()->get('Email'))).'/'.$item['employeeImageUrl']?>"
                                    onerror="this.onerror=null;this.src='assets/images/default-photo.svg';"
                                     alt="profile_picture" name="employeeImageUrl" id="employeeImageUrl" class="img-profile">
                                </div>
                                <!-- if error msg exist-->
                                <?php if(!empty(session()->getFlashdata('error_msg'))): ?>
                                    <h6 class="card-subtitle mb-2" style="color: red"><?= session()->getFlashdata('error_msg') ?></h6>
                                <?php endif; ?>
                                <!-- if error msg exist-->
                                <h5 class="card-title"><?php echo($item['employeeName'])?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"> <?php echo($item['division'])?></h6>
                                <p class="card-text"> <?php echo($item['employeeEmail'])?></p>
                            </div>
                    <?php endforeach;?>
                <?php endif;?>
                <div style="padding-left: 55px; padding-top: 40px;">
                    <button class="btn-logout text-uppercase">
                    <a href="<?= base_url('/logout'); ?>" class="logout-text">Logout</a>
                    </button>
                </div>
          </div>
        </div>
    </div>
</div>
</div>
<div class="modal" id="ChangeProfilePictureModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Profile Pictures</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <!--Start of Change profile picture form-->
                <form action="<?= base_url('changeProfilePicture')?>" enctype="multipart/form-data" method="post">
                    <?= csrf_field() ?>
                    <input type="file" name="newProfilePicture" id="newProfilePicture" accept="image/*" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Change</button>
                </form>
                <!-- End of Change profile picture form -->
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('additionalScript');?>
<script>
    function ChangeProfilePicture(){
        $('#ChangeProfilePictureModal').modal('show');
    }
</script>
<?= $this->endSection(); ?>
