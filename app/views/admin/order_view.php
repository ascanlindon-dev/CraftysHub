<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Details</title>
<style>
body { font-family: "Poppins", sans-serif; background: #f5f6fa; color: #333; }
.container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 16px rgba(102,126,234,0.10); padding: 30px; }
h2 { color: #667eea; text-align: center; margin-bottom: 25px; }
dt { font-weight: 600; color: #764ba2; margin-top: 12px; }
dd { margin: 0 0 10px 0; }
.back-btn { display: inline-block; margin-bottom: 18px; color: #667eea; background: #f8f9fa; padding: 8px 18px; border-radius: 8px; text-decoration: none; font-weight: 500; transition: background 0.2s, color 0.2s; box-shadow: 0 2px 8px rgba(102,126,234,0.07); }
.back-btn:hover { background: #e9ecef; color: #5a67d8; }
</style>
</head>
<body>
<div class="container">
    <a href="/admin/orders" class="back-btn">← Back to Orders</a>
    <h2>Order Details</h2>
    <?php if ($order): ?>
    <dl>
        <dt>Order Number</dt><dd><?= htmlspecialchars($order->order_number ?? $order->id) ?></dd>
        <dt>Buyer ID</dt><dd><?= htmlspecialchars($order->buyer_id ?? '') ?></dd>
        <dt>Status</dt><dd><?= htmlspecialchars($order->status ?? '') ?></dd>
            <dt>Edit Status</dt>
                <dd>
                    <div style="background: linear-gradient(90deg,#f8fafc 60%,#e3f0ff 100%); border-radius: 10px; box-shadow: 0 2px 8px rgba(102,126,234,0.10); padding: 18px 22px; margin: 10px 0 18px 0;">
                        <form method="post" action="/admin/update_order_status" style="display: flex; flex-direction: column; gap: 12px;">
                            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order->id) ?>">
                            <label style="font-weight:600; color:#667eea; margin-bottom:6px;">Change Order Status:</label>
                            <select name="status" style="padding: 8px; border-radius: 6px; border: 1px solid #ccd; font-size: 1em;">
                                <option value="pending" <?= ($order->status == 'pending') ? 'selected' : '' ?>>Pending</option>
                                <option value="processing" <?= ($order->status == 'processing') ? 'selected' : '' ?>>Processing</option>
                                <option value="shipped" <?= ($order->status == 'shipped') ? 'selected' : '' ?>>Shipped</option>
                                <option value="completed" <?= ($order->status == 'completed') ? 'selected' : '' ?>>Completed</option>
                                <option value="cancelled" <?= ($order->status == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                            <button type="submit" style="background: linear-gradient(90deg,#667eea,#764ba2); color: #fff; border: none; padding: 10px 0; border-radius: 6px; font-weight: 600; font-size: 1em; box-shadow: 0 1px 4px rgba(102,126,234,0.07); transition: background 0.2s;">Update Status</button>
                        </form>
                    </div>
                </dd>
            <dt>Grand Total</dt><dd>₱<?= number_format($order->grand_total ?? 0, 2) ?></dd>
        <dt>Shipping Name</dt><dd><?= htmlspecialchars($order->shipping_name ?? '') ?></dd>
        <dt>Email</dt><dd><?= htmlspecialchars($order->shipping_email ?? '') ?></dd>
        <dt>Phone</dt><dd><?= htmlspecialchars($order->shipping_phone ?? '') ?></dd>
        <dt>Address</dt><dd><?= htmlspecialchars($order->shipping_address ?? '') ?></dd>
        <dt>Payment Method</dt><dd><?= htmlspecialchars($order->payment_method ?? '') ?></dd>
        <dt>Payment Status</dt><dd><?= htmlspecialchars($order->payment_status ?? '') ?></dd>
        <dt>Order Date</dt><dd><?= htmlspecialchars($order->order_date ?? '') ?></dd>
        <dt>Notes</dt><dd><?= htmlspecialchars($order->order_notes ?? '') ?></dd>
    </dl>
    <?php else: ?>
    <p style="text-align:center; color:#dc3545;">Order not found.</p>
    <?php endif; ?>
</div>
</body>
</html>

