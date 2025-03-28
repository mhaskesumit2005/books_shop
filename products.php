<?php
$title = "";
$sub_title = "";
if (isset($_GET['c']) && isset($_GET['s'])) {
    $cat_qry = $conn->query("SELECT * FROM categories where md5(id) = '{$_GET['c']}'");
    if ($cat_qry->num_rows > 0) {
        $result = $cat_qry->fetch_assoc();
        $title = $result['category'];
        $cat_description = $result['description'];
    }
    $sub_cat_qry = $conn->query("SELECT * FROM sub_categories where md5(id) = '{$_GET['s']}'");
    if ($sub_cat_qry->num_rows > 0) {
        $result = $sub_cat_qry->fetch_assoc();
        $sub_title = $result['sub_category'];
        $sub_cat_description = $result['description'];
    }
} elseif (isset($_GET['c'])) {
    $cat_qry = $conn->query("SELECT * FROM categories where md5(id) = '{$_GET['c']}'");
    if ($cat_qry->num_rows > 0) {
        $result = $cat_qry->fetch_assoc();
        $title = $result['category'];
        $cat_description = $result['description'];
    }
} elseif (isset($_GET['s'])) {
    $sub_cat_qry = $conn->query("SELECT * FROM sub_categories where md5(id) = '{$_GET['s']}'");
    if ($sub_cat_qry->num_rows > 0) {
        $result = $sub_cat_qry->fetch_assoc();
        $sub_title = $result['sub_category'];
        $sub_cat_description = $result['description'];
    }
}
?>
<!-- Header-->
<header class="bg-dark py-5" id="main-header">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?php echo $title ?></h1>
            <p class="lead fw-normal text-white-50 mb-0"><?php echo $sub_title ?></p>
        </div>
    </div>
</header>
<section class="py-5">
    <div class="container-fluid row">
        <?php if (isset($_GET['c'])): ?>
            <div class="col-md-3 border-right mb-2 pb-3">
                <h3 class="fw-bold">Sub Categories</h3>
                <div class="list-group">
                    <a href="./?p=products&c=<?php echo $_GET['c'] ?>" class="list-group-item <?php echo !isset($_GET['s']) ? "active" : "" ?>">All</a>
                    <?php
                    $sub_cat = $conn->query("SELECT * FROM `sub_categories` WHERE md5(parent_id) =  '{$_GET['c']}' ");
                    while ($row = $sub_cat->fetch_assoc()):
                    ?>
                        <a href="./?p=products&c=<?php echo $_GET['c'] ?>&s=<?php echo md5($row['id']) ?>" class="list-group-item <?php echo isset($_GET['s']) && $_GET['s'] == md5($row['id']) ? "active" : "" ?>">
                            <?php echo $row['sub_category'] ?>
                        </a>
                    <?php endwhile; ?>
                </div>
                <hr>
            </div>
        <?php endif; ?>
        <div class="<?php echo isset($_GET['c']) ? 'col-md-9' : 'col-md-10 offset-md-1' ?>">
            <div class="container-fluid p-0">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="book-tab" data-toggle="tab" href="#book" role="tab" aria-controls="book" aria-selected="true">Books</a>
                    </li>
                    <?php if (isset($_GET['c'])): ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">Details</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active" id="book">
                        <?php if (isset($_GET['search'])): ?>
                            <h4 class="text-center fw-bold">Search Result for '<?php echo $_GET['search']; ?>'</h4>
                        <?php endif; ?>
                        <div class="row gx-3 row-cols-1 row-cols-md-3 row-cols-xl-3">
                            <?php
                            $whereData = "";
                            if (isset($_GET['search']))
                                $whereData = " and (title LIKE '%{$_GET['search']}%' or author LIKE '%{$_GET['search']}%' or description LIKE '%{$_GET['search']}%')";
                            elseif (isset($_GET['c']) && isset($_GET['s']))
                                $whereData = " and (md5(category_id) = '{$_GET['c']}' and md5(sub_category_id) = '{$_GET['s']}')";
                            elseif (isset($_GET['c']) && !isset($_GET['s']))
                                $whereData = " and md5(category_id) = '{$_GET['c']}' ";
                            $products = $conn->query("SELECT * FROM `products` WHERE status = 1 {$whereData} ORDER BY rand() ");
                            while ($row = $products->fetch_assoc()):
                                $upload_path = base_app . '/uploads/product_' . $row['id'];
                                $img = "";
                                if (is_dir($upload_path)) {
                                    $fileO = scandir($upload_path);
                                    if (isset($fileO[2]))
                                        $img = "uploads/product_" . $row['id'] . "/" . $fileO[2];
                                }
                                $row = array_map('stripslashes', $row);
                                $inventory = $conn->query("SELECT * FROM inventory WHERE product_id = " . $row['id']);
                                $inv = array();
                                while ($ir = $inventory->fetch_assoc()) {
                                    $inv[] = number_format($ir['price']);
                                }
                            ?>
                                <div class="col-md-12 mb-4">
                                    <div class="card product-item shadow-lg border-0">
                                        <img class="card-img-top w-100" src="<?php echo validate_image($img) ?>" loading="lazy" alt="Product Image" />
                                        <div class="card-body p-4">
                                            <h5 class="fw-bolder text-dark"> <?php echo $row['title'] ?> </h5>
                                            <?php foreach ($inv as $v): ?>
                                                <p class="text-muted mb-2"><b>Price:</b> <?php echo $v ?></p>
                                            <?php endforeach; ?>
                                            <p class="m-0 text-muted"><small>By: <?php echo $row['author'] ?></small></p>
                                        </div>
                                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                            <div class="text-center">
                                                <a class="btn btn-dark" href=".?p=view_product&id=<?php echo md5($row['id']) ?>">View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                            <?php if ($products->num_rows <= 0): ?>
                                <h4 class="text-center fw-bold">No Product Listed.</h4>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="details">
                        <h3 class="text-center fw-bold"> <?php echo $title . " Category" ?> </h3>
                        <hr>
                        <div>
                            <?php echo isset($cat_description) ? stripslashes(html_entity_decode($cat_description)) : '' ?>
                        </div>
                        <h3 class="text-center fw-bold"> <?php echo $sub_title ?> </h3>
                        <hr>
                        <div>
                            <?php echo isset($sub_cat_description) ? stripslashes(html_entity_decode($sub_cat_description)) : '' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>