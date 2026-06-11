<?php
include 'admin_layout.php';
$customers = mysqli_query($conn, "SELECT * FROM users WHERE role='guest' ORDER BY user_id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Customers</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php'; ?>

    <main class="main-content">
        <div class="page-title">
            <h1>Manage Customers</h1>
            <p>View and delete customer accounts</p>
        </div>

        <div class="panel">
            <table>
                <tr><th>ID</th><th>Full Name</th><th>Email</th><th>Created At</th><th>Action</th></tr>
                <?php while($customer = mysqli_fetch_assoc($customers)) { ?>
                <tr>
                    <td><?php echo $customer['user_id']; ?></td>
                    <td><?php echo $customer['full_name']; ?></td>
                    <td><?php echo $customer['email']; ?></td>
                    <td><?php echo $customer['created_at']; ?></td>
                    <td>
                        <form action="admin_process.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $customer['user_id']; ?>">
                            <button class="delete" name="action" value="delete_customer" onclick="return confirm('Delete this customer?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </main>
</div>
</body>
</html>
