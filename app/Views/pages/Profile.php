<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>



<a href="<?= base_url('/logout'); ?>">Logout</a>
<br>

<br>
<?php if(isset($Employee)):?>
    <?php foreach ($Employee as $item): ?>
        <?php echo('Email       : '.$item['employeeEmail'])?>
        <br>
        <?php echo('Nama        : '.$item['employeeName'])?>
        <br>
        <?php echo('Point       : '.$item['employeePoint'])?>
        <br>
        <?php echo('Division    : '.$item['division'])?>
        <br>
        <img onclick="ChangeProfilePicture()" src="<?php echo($item['employeeImageUrl'])?>" alt="profile_picture" name="employeeImageUrl" id="employeeImageUrl" width="200">
        <br>
    <?php endforeach;?>
<?php endif;?>
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
<!--                Start of Change profile picture form-->
                <form action="<?= base_url('changeProfilePicture')?>" enctype="multipart/form-data" method="post">
                    <input type="file" name="newProfilePicture" id="newProfilePicture" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Change</button>
                </form>
<!--                End of Change profile picture form-->
            </div>
        </div>
    </div>
</div>

<script>
    console.log('Session : <?=session()->get("Email") ?>');
    console.log('Environment : <?=ENVIRONMENT?>');

    function ChangeProfilePicture(){
        $('#ChangeProfilePictureModal').modal('show');
    }
</script>