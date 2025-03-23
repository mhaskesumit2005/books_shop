<style>
    /* Hide modal header and footer */
    #uni_modal .modal-content > .modal-footer,
    #uni_modal .modal-content > .modal-header {
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <!-- Close button -->
            <div class="text-right">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Login Form Title -->
            <h3 class="text-center">Login</h3>
            <hr>

            <!-- Login Form -->
            <form id="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group d-flex justify-content-between align-items-center">
                    <a href="javascript:void(0)" id="create_account">Create Account</a>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Open Registration Modal
        $('#create_account').click(function () {
            uni_modal("", "registration.php", "mid-large");
        });

        // Login Form Submission
        $('#login-form').submit(function (e) {
            e.preventDefault();
            start_loader();

            // Remove previous error messages
            $('.err-msg').remove();

            $.ajax({
                url: _base_url_ + "classes/Login.php?f=login_user",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                error: function (err) {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function (resp) {
                    if (typeof resp === 'object' && resp.status === 'success') {
                        alert_toast("Login Successfully", 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else if (resp.status === 'incorrect') {
                        $('<div class="alert alert-danger err-msg">Incorrect Credentials.</div>')
                            .prependTo('#login-form');
                        end_loader();
                    } else {
                        console.log(resp);
                        alert_toast("An error occurred", 'error');
                        end_loader();
                    }
                }
            });
        });
    });
</script>
