<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<?php 
$total = 0;
$qry = $conn->query("SELECT c.*,p.title,i.price,p.id as pid from `cart` c inner join `inventory` i on i.id=c.inventory_id inner join products p on p.id = i.product_id where c.client_id = ".$_settings->userdata('id'));
while($row= $qry->fetch_assoc()):
    $total += $row['price'] * $row['quantity'];
endwhile;
?>
<section class="py-5">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body">
                <h3 class="text-center"><b>Checkout</b></h3>
                <hr class="border-dark">
                <form action="" id="place_order">
                    <input type="hidden" name="amount" value="<?php echo $total ?>">
                    <input type="hidden" name="payment_method" value="cod">
                    <input type="hidden" name="paid" value="0">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Order Type</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="delivery" name="order_type" value="2" checked>
                                    <label class="form-check-label" for="delivery">For Delivery</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="pickup" name="order_type" value="1">
                                    <label class="form-check-label" for="pickup">For Pick Up</label>
                                </div>
                            </div>
                            <div class="mb-3 address-holder">
                                <label class="form-label">Delivery Address</label>
                                <textarea name="delivery_address" class="form-control" rows="3" required><?php echo $_settings->userdata('default_delivery_address') ?></textarea>
                            </div>
                            <h4><b>Total:</b> &#8377; <?php echo number_format($total) ?></h4>
                            <hr>
                            <h4 class="text-muted">Payment Method</h4>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-dark">Cash on Delivery</button>
                                <span id="paypal-button"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
paypal.Button.render({
    env: 'sandbox',
    client: {
        sandbox: 'AdDNu0ZwC3bqzdjiiQlmQ4BRJsOarwyMVD_L4YQPrQm4ASuBg4bV5ZoH-uveg8K_l9JLCmipuiKt4fxn'
    },
    commit: true,
    style: { color: 'blue', size: 'small' },
    payment: function(data, actions) {
        return actions.payment.create({
            payment: { transactions: [{ amount: { total: '<?php echo $total; ?>', currency: 'PHP' } }] }
        });
    },
    onAuthorize: function(data, actions) {
        return actions.payment.execute().then(function(payment) {
            payment_online();
        });
    },
}, '#paypal-button');

function payment_online(){
    $('[name="payment_method"]').val("Online Payment");
    $('[name="paid"]').val(1);
    $('#place_order').submit();
}

$(function(){
    $('[name="order_type"]').change(function(){
        $('.address-holder').toggle($(this).val() == 2);
    });
    $('#place_order').submit(function(e){
        e.preventDefault();
        start_loader();
        $.ajax({
            url:'classes/Master.php?f=place_order',
            method:'POST',
            data:$(this).serialize(),
            dataType:"json",
            success:function(resp){
                if(resp.status == 'success'){
                    alert_toast("Order Successfully placed.","success");
                    setTimeout(function(){ location.replace('./'); }, 2000);
                } else {
                    alert_toast("An error occurred","error");
                }
                end_loader();
            },
            error:function(){
                alert_toast("An error occurred","error");
                end_loader();
            }
        });
    });
});
</script>
