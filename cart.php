<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-end mb-2">
                <button class="btn btn-outline-dark btn-sm" type="button" id="empty_cart">Empty Cart</button>
            </div>
        </div>
        <div class="card rounded-0">
            <div class="card-body">
                <h3 class="mb-3"><b>Cart List</b></h3>
                <hr class="border-dark">
                <?php 
                    $qry = $conn->query("SELECT c.*,p.title,i.price,p.id as pid FROM `cart` c 
                                         INNER JOIN `inventory` i ON i.id = c.inventory_id 
                                         INNER JOIN `products` p ON p.id = i.product_id 
                                         WHERE c.client_id = ".$_settings->userdata('id'));
                    while($row = $qry->fetch_assoc()):
                        $upload_path = base_app.'/uploads/product_'.$row['pid'];
                        $img = "";

                        foreach($row as $k => $v){
                            $row[$k] = trim(stripslashes($v));
                        }
                        if(is_dir($upload_path)){
                            $fileO = scandir($upload_path);
                            if(isset($fileO[2]))
                                $img = "uploads/product_".$row['pid']."/".$fileO[2];
                        }
                ?>
                <div class="d-flex w-100 justify-content-between mb-2 py-2 border-bottom cart-item">
                    <div class="d-flex align-items-center col-8">
                        <span class="mr-2">
                            <a href="javascript:void(0)" class="btn btn-sm btn-outline-danger rem_item" data-id="<?php echo $row['id'] ?>">
                                <i class="fa fa-trash"></i>
                            </a>
                        </span>
                        <img src="<?php echo validate_image($img) ?>" loading="lazy" class="cart-prod-img mr-2" alt="">
                        <div>
                            <p class="mb-1"><?php echo $row['title'] ?></p>
                            <p class="mb-1"><small><b>Price:</b> <span class="price"><?php echo number_format($row['price']) ?></span></small></p>
                            <div class="input-group" style="width:130px;">
                                <div class="input-group-prepend">
                                    <button class="btn btn-sm btn-outline-secondary min-qty" type="button"><i class="fa fa-minus"></i></button>
                                </div>
                                <input type="number" class="form-control form-control-sm text-center cart-qty" value="<?php echo $row['quantity'] ?>" data-id="<?php echo $row['id'] ?>" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-outline-secondary plus-qty" type="button"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col text-right d-flex align-items-center justify-content-end">
                        <h4><b class="total-amount"><?php echo number_format($row['price'] * $row['quantity']) ?></b></h4>
                    </div>
                </div>
                <?php endwhile; ?>

                <div class="d-flex w-100 justify-content-between mb-2 py-2 border-bottom">
                    <div class="col-8 d-flex justify-content-end"><h4>Grand Total:</h4></div>
                    <div class="col d-flex justify-content-end"><h4 id="grand-total">-</h4></div>
                </div>
            </div>
        </div>
        <div class="d-flex w-100 justify-content-end">
            <a href="./?p=checkout" class="btn btn-sm btn-dark">Checkout</a>
        </div>
    </div>
</section>

<script>
    function calc_total() {
        let total = 0;
        $('.total-amount').each(function () {
            let amount = $(this).text().replace(/\,/g, '');
            total += parseFloat(amount);
        });
        $('#grand-total').text(parseFloat(total).toLocaleString('en-US'));
    }

    function qty_change(type, button) {
        let qtyField = button.closest('.cart-item').find('.cart-qty');
        let qty = parseInt(qtyField.val());
        let price = parseFloat(button.closest('.cart-item').find('.price').text().replace(/,/g, ''));
        let cart_id = qtyField.attr('data-id');

        if (type === 'minus' && qty > 1) qty--;
        else if (type === 'plus') qty++;

        let new_total = (qty * price).toLocaleString('en-US');
        qtyField.val(qty);
        button.closest('.cart-item').find('.total-amount').text(new_total);
        calc_total();

        $.ajax({
            url: 'classes/Master.php?f=update_cart_qty',
            method: 'POST',
            data: { id: cart_id, quantity: qty },
            dataType: 'json',
            success: function (resp) {
                if (resp.status !== 'success') alert_toast("An error occurred", 'error');
            },
            error: function () {
                alert_toast("An error occurred", 'error');
            }
        });
    }

    function rem_item(id) {
        let item = $('.rem_item[data-id="' + id + '"]').closest('.cart-item');
        start_loader();
        $.ajax({
            url: 'classes/Master.php?f=delete_cart',
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function (resp) {
                if (resp.status === 'success') {
                    item.fadeOut('slow', function () { $(this).remove(); });
                    calc_total();
                } else {
                    alert_toast("An error occurred", 'error');
                }
                end_loader();
            },
            error: function () {
                alert_toast("An error occurred", 'error');
                end_loader();
            }
        });
    }

    function empty_cart() {
        start_loader();
        $.ajax({
            url: 'classes/Master.php?f=empty_cart',
            method: 'POST',
            dataType: 'json',
            success: function (resp) {
                if (resp.status === 'success') location.reload();
                else alert_toast("An error occurred", 'error');
                end_loader();
            },
            error: function () {
                alert_toast("An error occurred", 'error');
                end_loader();
            }
        });
    }

    $(function () {
        calc_total();
        $('.min-qty').click(function () { qty_change('minus', $(this)); });
        $('.plus-qty').click(function () { qty_change('plus', $(this)); });
        $('#empty_cart').click(function () { _conf("Are you sure you want to empty your cart?", 'empty_cart', []); });
        $('.rem_item').click(function () { _conf("Are you sure you want to remove this item?", 'rem_item', [$(this).attr('data-id')]); });
    });
</script>
