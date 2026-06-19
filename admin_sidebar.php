<div class="sidebar">
    <div class="brand">
        <small>Hotel De Mag</small>
        <h3>Admin Dashboard</h3>
    </div>

    <a class="<?php echo activePage('admin.php', $current_page); ?>" href="admin.php"><i class="fas fa-chart-bar"></i> Dashboard</a>
    <a class="<?php echo activePage('manage_rooms.php', $current_page); ?>" href="manage_rooms.php"><i class="fas fa-hotel"></i> Manage Rooms</a>
    <a class="<?php echo activePage('manage_bookings.php', $current_page); ?>" href="manage_bookings.php"><i class="fas fa-calendar-alt"></i> Manage Bookings</a>
    <a class="<?php echo activePage('manage_customers.php', $current_page); ?>" href="manage_customers.php"><i class="fas fa-users"></i> Manage Customers</a>
    <a class="<?php echo activePage('payments.php', $current_page); ?>" href="payments.php"><i class="fas fa-credit-card"></i> Payments</a>
    <a class="<?php echo activePage('reports.php', $current_page); ?>" href="reports.php"><i class="fas fa-chart-line"></i> View Reports</a>

    <div class="sidebar-bottom">
        <a href="index.php"><i class="fas fa-home"></i> View Website</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
