<!-- Header -->
<header class="bg-dark py-5" id="main-header">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 font-weight-bold">Discover Your Next Favorite Book!</h1>
            <p class="lead text-white-50 mb-0">Shop Now and Expand Your Knowledge.</p>
        </div>
    </div>
</header>

<!-- Book Section -->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-4">
        <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 justify-content-center">
            <?php 
                $products = $conn->query("SELECT * FROM `products` WHERE status = 1 ORDER BY RAND() LIMIT 8");
                while ($row = $products->fetch_assoc()):
                    $upload_path = base_app.'/uploads/product_'.$row['id'];
                    $img = "";
                    if (is_dir($upload_path)) {
                        $fileO = scandir($upload_path);
                        if (isset($fileO[2])) {
                            $img = "uploads/product_".$row['id']."/".$fileO[2];
                        }
                    }
                    foreach ($row as $k => $v) {
                        $row[$k] = trim(stripslashes($v));
                    }
                    $inventory = $conn->query("SELECT * FROM inventory WHERE product_id = ".$row['id']);
                    $inv = array();
                    while ($ir = $inventory->fetch_assoc()) {
                        $inv[] = number_format($ir['price']);
                    }
            ?>
            <div class="col mb-5">
                <div class="card h-100 border rounded">
                    <!-- Product image -->
                    <div class="text-center p-3">
                        <img class="card-img-top book-cover img-fluid" src="<?php echo validate_image($img) ?>" alt="Book Cover">
                    </div>
                    <!-- Product details -->
                    <div class="card-body p-4 text-center">
                        <h5 class="font-weight-bold text-dark mb-2"><?php echo $row['title'] ?></h5>
                        <p class="small text-muted mb-1">By: <?php echo $row['author'] ?></p>
                        <p class="font-weight-bold text-primary">
                            <?php foreach ($inv as $price): ?>
                                <span>₹<?php echo $price ?></span>
                            <?php endforeach; ?>
                        </p>
                    </div>
                    <!-- Product actions -->
                    <div class="card-footer bg-transparent border-top-0 text-center pb-3">
                        <a href=".?p=view_product&id=<?php echo md5($row['id']) ?>" class="btn btn-dark btn-sm px-4">View Details</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Custom CSS -->
<style>
    .book-cover {
        height: 250px; 
        object-fit: cover;
        border-radius: 8px;
    }
    .card {
        border-radius: 10px;
        border: 1px solid #ddd; /* Light border for a clean look */
        transition: all 0.3s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
