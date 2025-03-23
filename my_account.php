<?php 
require_once 'config.php';

class Order {
    private $conn;
    private $userId;

    public function __construct($db, $userId) {
        $this->conn = $db;
        $this->userId = $userId;
    }

    public function fetchOrders() {
        $stmt = $this->conn->prepare("SELECT o.*, CONCAT(c.firstname, ' ', c.lastname) AS client FROM `orders` o INNER JOIN clients c ON c.id = o.client_id WHERE o.client_id = ? ORDER BY unix_timestamp(o.date_created) DESC");
        $stmt->bind_param("i", $this->userId);
        $stmt->execute();
        return $stmt->get_result();
    }
}

$order = new Order($conn, $_settings->userdata('id'));
$orders = $order->fetchOrders();
?>

<section class="py-2">
    <div class="container">
        <div class="card rounded-0">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h4><b>Orders</b></h4>
                    <a href="./?p=edit_account" class="btn btn-dark btn-flat">
                        <i class="fa fa-user-cog"></i> Manage Account
                    </a>
                </div>
                <hr class="border-warning">
                <table class="table table-striped text-dark">
                    <colgroup>
                        <col width="10%">
                        <col width="20%">
                        <col width="30%">
                        <col width="20%">
                        <col width="20%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>DateTime</th>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; while ($row = $orders->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])); ?></td>
                                <td>
                                    <a href="javascript:void(0)" class="view_order" data-id="<?php echo $row['id']; ?>">
                                        <?php echo md5($row['id']); ?>
                                    </a>
                                </td>
                                <td>&#8377; <?php echo number_format($row['amount']); ?></td>
                                <td class="text-center">
                                    <?php 
                                    $status_labels = [
                                        'Pending' => 'light text-dark',
                                        'Packed' => 'primary',
                                        'Out for Delivery' => 'warning',
                                        'Delivered' => 'success',
                                        'Cancelled' => 'danger'
                                    ];
                                    $status = ['Pending', 'Packed', 'Out for Delivery', 'Delivered', 'Cancelled'];
                                    ?>
                                    <span class="badge badge-<?php echo $status_labels[$status[$row['status']]]; ?>">
                                        <?php echo $status[$row['status']]; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    function cancelOrder(id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=update_order_status",
            method: "POST",
            data: { id: id, status: 2 },
            dataType: "json",
            error: function(err) {
                console.log(err);
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp) {
                if (resp && resp.status === 'success') {
                    alert_toast("Order cancelled successfully", 'success');
                    setTimeout(function() { location.reload(); }, 2000);
                } else {
                    console.log(resp);
                    alert_toast("An error occurred", 'error');
                }
                end_loader();
            }
        });
    }

    $(function() {
        $('.view_order').click(function() {
            uni_modal("Order Details", "./admin/orders/view_order.php?view=user&id=" + $(this).data('id'), 'large');
        });
        $('table').dataTable();
    });
</script>