<style>
    #uni_modal .modal-content>.modal-footer,#uni_modal .modal-content>.modal-header{
        display:none;
    }
</style>
<div class="container-fluid">
    <form action="" id="registration">
        <div class="row">
        
        <h3 class="text-center text-primary fw-bold">Create New Account
            <span class="float-end">
                <button type="button" class="close btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </span>
        </h3>
            <hr>
        </div>
        <div class="row align-items-center h-100">
            <div class="col-lg-5 border-end">
                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstname" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lastname" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact</label>
                    <input type="text" class="form-control" name="contact" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select" required>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="mb-3">
                    <label class="form-label">Default Delivery Address</label>
                    <textarea class="form-control" rows='3' name="default_delivery_address"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="javascript:void(0)" id="login-show" class="text-decoration-none">Already have an account?</a>
                    <button class="btn btn-dark">Register</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
$(function(){
    $('#login-show').click(function(){
        uni_modal("","login.php")
    })
    
    $('#registration').submit(function(e){
        e.preventDefault();
        start_loader();
        if($('.err-msg').length > 0) $('.err-msg').remove();
        
        $.ajax({
            url:_base_url_+"classes/Master.php?f=register",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            error:err=>{
                console.log(err);
                alert_toast("An error occurred",'error');
                end_loader();
            },
            success:function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    alert_toast("Account successfully registered",'success');
                    setTimeout(function(){ location.reload(); },2000);
                }else if(resp.status == 'failed' && !!resp.msg){
                    $('<div>').addClass("alert alert-danger err-msg").text(resp.msg).insertAfter('[name="password"]');
                    end_loader();
                }else{
                    console.log(resp);
                    alert_toast("An error occurred",'error');
                    end_loader();
                }
            }
        });
    });
});
</script>
    