<?php 
$title = "All Book Categories";
$sub_title = "";
if(isset($_GET['c']) && isset($_GET['s'])){
    $cat_qry = $conn->query("SELECT * FROM categories where md5(id) = '{$_GET['c']}'");
    if($cat_qry->num_rows > 0){
        $title = $cat_qry->fetch_assoc()['category'];
    }
 $sub_cat_qry = $conn->query("SELECT * FROM sub_categories where md5(id) = '{$_GET['s']}'");
    if($sub_cat_qry->num_rows > 0){
        $sub_title = $sub_cat_qry->fetch_assoc()['sub_category'];
    }
}
elseif(isset($_GET['c'])){
    $cat_qry = $conn->query("SELECT * FROM categories where md5(id) = '{$_GET['c']}'");
    if($cat_qry->num_rows > 0){
        $title = $cat_qry->fetch_assoc()['category'];
    }
}
elseif(isset($_GET['s'])){
    $sub_cat_qry = $conn->query("SELECT * FROM sub_categories where md5(id) = '{$_GET['s']}'");
    if($sub_cat_qry->num_rows > 0){
        $title = $sub_cat_qry->fetch_assoc()['sub_category'];
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
<!-- Category Section -->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-4">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">Categories</h2>
            <p class="text-muted">Explore our different product categories</p>
        </div>
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-lg-3 justify-content-center">
           
            <?php 
                $categories = $conn->query("SELECT * FROM `categories` WHERE status = 1 ORDER BY category ASC");
                while($row = $categories->fetch_assoc()):
                    foreach($row as $k => $v){
                        $row[$k] = trim(stripslashes($v));
                    }
                    $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
            ?>
            <div class="col mb-4">
                <a href="./?p=products&c=<?php echo md5($row['id']) ?>" class="text-decoration-none">
                    <div class="card category-item shadow-sm border-0 rounded-3">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold text-dark border-bottom pb-2"><?php echo $row['category'] ?></h5>
                            <p class="m-0 text-muted small truncate"><?php echo $row['description'] ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>

        </div>
    </div>
</section>

<!-- Custom CSS -->
<style>
    .category-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .category-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
    .truncate {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
