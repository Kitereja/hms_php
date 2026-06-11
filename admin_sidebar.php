<div class="sidebar">
    <div class="brand">
        <small>Hotel De Mag</small>
        <h3>Admin Dashboard</h3>
    </div>

    <a class="<?php echo activePage('admin.php', $current_page); ?>" href="admin.php">📊 Dashboard</a>
    <a class="<?php echo activePage('manage_rooms.php', $current_page); ?>" href="manage_rooms.php">🏨 Manage Rooms</a>
    <a class="<?php echo activePage('manage_bookings.php', $current_page); ?>" href="manage_bookings.php">📅 Manage Bookings</a>
    <a class="<?php echo activePage('manage_customers.php', $current_page); ?>" href="manage_customers.php">👥 Manage Customers</a>
    <a class="<?php echo activePage('payments.php', $current_page); ?>" href="payments.php">💳 Payments</a>
    <a class="<?php echo activePage('reports.php', $current_page); ?>" href="reports.php">📈 View Reports</a>

    <div class="sidebar-bottom">
        <a href="index.php">🏠 View Website</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
</div>
