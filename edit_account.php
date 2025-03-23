<section class="py-5">
    <div class="container">
        <div class="card shadow rounded-3 border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold text-primary">Update Account Details</h4>
                    <a href="./?p=my_account" class="btn btn-outline-dark">
                        <i class="fas fa-angle-left"></i> Back to Order List
                    </a>
                </div>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form action="" id="update_account">
                            <input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
                            
                            <div class="mb-3">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" name="firstname" class="form-control" value="<?php echo $_settings->userdata('firstname') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" name="lastname" class="form-control" value="<?php echo $_settings->userdata('lastname') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" name="contact" class="form-control" value="<?php echo $_settings->userdata('contact') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" class="form-select" required>
                                    <option <?php echo $_settings->userdata('gender') == "Male" ? "selected" : '' ?>>Male</option>
                                    <option <?php echo $_settings->userdata('gender') == "Female" ? "selected" : '' ?>>Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="default_delivery_address" class="form-label">Default Delivery Address</label>
                                <textarea class="form-control" rows='3' name="default_delivery_address"><?php echo $_settings->userdata('default_delivery_address') ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $_settings->userdata('email') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter new password (optional)">
                            </div>
                            <div class="mb-3">
                                <label for="cpassword" class="form-label">Current Password</label>
                                <input type="password" name="cpassword" class="form-control" placeholder="Enter current password">
                            </div>
                            <div class="text-end">
                                <button class="btn btn-dark">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(function(){
    $('#update_account [name="password"], #update_account [name="cpassword"]').on('input', function(){
        let password = $('#update_account [name="password"]').val();
        let cpassword = $('#update_account [name="cpassword"]').val();
        $('#update_account [name="password"], #update_account [name="cpassword"]').attr('required', password !== '' || cpassword !== '');
    });
    
    $('#update_account').submit(function(e){
        e.preventDefault();
        start_loader();
        if($('.err-msg').length > 0) $('.err-msg').remove();
        
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=update_account",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp){
                if (typeof resp == 'object' && resp.status == 'success') {
                    alert_toast("Account successfully updated", 'success');
                    $('#update_account [name="password"], #update_account [name="cpassword"]').val('').attr('required', false);
                } else if (resp.status == 'failed' && resp.msg) {
                    $('<div>').addClass("alert alert-danger err-msg").text(resp.msg).prependTo('#update_account');
                    $('body, html').animate({scrollTop: 0}, 'fast');
                } else {
                    console.log(resp);
                    alert_toast("An error occurred", 'error');
                }
                end_loader();
            }
        });
    });
});
</script>
