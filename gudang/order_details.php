<?php
session_start();

require_once '../inc/dbconn.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    $database = new Database();
    $orderDetails = $database->getOrderDetails($order_id);
    $order = $database->getOrderById($order_id);

    include '../inc/header.php';
?>

    <div class="container mt-5">
        <h2>Order Details</h2>
        <p><strong>Status Order:</strong> <?= $order['status_order']; ?></p>
        <p><strong>Total Harga:</strong> <?= $order['total']; ?></p>

        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderDetails as $orderDetail) : ?>
                    <tr>
                        <td><?= $orderDetail['product_name']; ?></td>
                        <td><?= $orderDetail['qty']; ?></td>
                        <td><?= $orderDetail['unit_price']; ?></td>
                        <td><?= $orderDetail['total_price']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total Harga Keseluruhan:</strong></td>
                    <td><?= $order['total']; ?></td>
                </tr>
            </tfoot>
        </table>
            <?php
            // Check if status_order is "menunggu konfirmasi" and then show the button
            if ($order['status_order'] == 'Menunggu Konfirmasi') {
            ?>
                <a href="confirm_order.php?orderid=<?php echo $order['orderid']; ?>" class="btn btn-primary">Konfirmasi Order</a>
            <?php
            }
            ?>
    </div>

<?php } else {
    // Handle case when order_id is not provided
    echo "Order ID is not valid.";
}
?>
