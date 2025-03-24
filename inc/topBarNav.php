<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand d-flex align-items-center" href="./">
            <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30" class="d-inline-block align-top me-2" alt="Logo">
            <?php echo $_settings->info('short_name') ?>
        </a>
        
        <button class="navbar-toggler btn btn-sm" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto mb-2 mb-lg-0 ml-lg-4">
                <li class="nav-item"><a class="nav-link" href="./">Home</a></li>
                
                <?php 
                $cat_qry = $conn->query("SELECT * FROM categories WHERE status = 1 LIMIT 3");
                $count_cats = $conn->query("SELECT * FROM categories WHERE status = 1")->num_rows;
                while ($crow = $cat_qry->fetch_assoc()):
                    $sub_qry = $conn->query("SELECT * FROM sub_categories WHERE status = 1 AND parent_id = '{$crow['id']}'");
                ?>
                    <?php if ($sub_qry->num_rows == 0): ?>
                        <li class="nav-item"><a class="nav-link" href="./?p=products&c=<?php echo md5($crow['id']) ?>"><?php echo $crow['category'] ?></a></li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown<?php echo $crow['id'] ?>" role="button" data-toggle="dropdown"
                                aria-expanded="false"><?php echo $crow['category'] ?></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown<?php echo $crow['id'] ?>">
                                <?php while ($srow = $sub_qry->fetch_assoc()): ?>
                                    <a class="dropdown-item" href="./?p=products&c=<?php echo md5($crow['id']) ?>&s=<?php echo md5($srow['id']) ?>"><?php echo $srow['sub_category'] ?></a>
                                <?php endwhile; ?>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endwhile; ?>
                
                <?php if ($count_cats > 3): ?>
                    <li class="nav-item"><a class="nav-link" href="./?p=view_categories">All Categories</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="./?p=about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="./?p=contact">Contact</a></li>
            </ul>

            <form class="form-inline mr-3" id="search-form">
                <div class="input-group">
                    <input class="form-control form-control-sm" type="search" placeholder="Search" aria-label="Search" name="search"
                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : "" ?>">
                    <div class="input-group-append">
                        <button class="btn btn-outline-success btn-sm" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

            <div class="d-flex align-items-center">
                <?php if (!isset($_SESSION['userdata']['id'])): ?>
                    <button class="btn btn-outline-dark btn-sm ml-2" id="login-btn">Login</button>
                <?php else: ?>
                    <a class="nav-link text-dark mr-2" href="./?p=cart">
                        <i class="bi-cart-fill me-1"></i> Cart
                        <span class="badge badge-dark text-white ml-1 rounded-pill" id="cart-count">
                            <?php 
                            $count = isset($_SESSION['userdata']['id']) ? $conn->query("SELECT SUM(quantity) AS items FROM cart WHERE client_id =".$_settings->userdata('id'))->fetch_assoc()['items'] : 0;
                            echo ($count > 0 ? $count : 0);
                            ?>
                        </span>
                    </a>
                    <a href="./?p=my_account" class="nav-link text-dark"><b>Hi, <?php echo $_settings->userdata('firstname')?>!</b></a>
                    <a href="logout.php" class="nav-link text-dark"><i class="fa fa-sign-out-alt"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
    $(document).ready(function() {
        $('#login-btn').click(function() {
            uni_modal("", "login.php");
        });

        $('#search-form').submit(function(e) {
            e.preventDefault();
            let searchText = $('[name="search"]').val().trim();
            if (searchText !== '') {
                window.location.href = './?p=products&search=' + searchText;
            }
        });
    });
</script>
