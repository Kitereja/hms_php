<?php
include 'admin_layout.php';
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';
$rooms = mysqli_query($conn, "SELECT * FROM rooms ORDER BY room_id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Rooms</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<div class="admin-wrapper">
    <?php include 'admin_sidebar.php'; ?>

    <main class="main-content">
        <div class="page-title">
            <h1>Manage Rooms</h1>
            <p>Add, update, and delete hotel rooms</p>
        </div>

        <?php if ($msg != '') echo "<p class='success'>$msg</p>"; ?>
        <?php if ($error != '') echo "<p class='error'>$error</p>"; ?>

        <div class="panel">
            <form action="admin_process.php" method="POST" enctype="multipart/form-data" class="form-row">
                <input type="hidden" name="action" value="add_room">
                <input type="text" name="room_name" placeholder="Room name" required>
                <select name="room_type" required>
                    <option value="">Select type</option>
                    <option value="Standard">Standard</option>
                    <option value="Deluxe">Deluxe</option>
                    <option value="Suite">Suite</option>
                </select>
                <input type="number" name="price" placeholder="Price" required>
                <input type="number" name="capacity" placeholder="Capacity" required>
                <input type="file" name="image" accept="image/*">
                <select name="status">
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                <button type="submit">Add Room</button>
            </form>

            <table>
                <tr><th>ID</th><th>Name</th><th>Type</th><th>Price</th><th>Capacity</th><th>Status</th><th>Action</th></tr>
                <?php while($room = mysqli_fetch_assoc($rooms)) { ?>
                <tr>
                    <form action="admin_process.php" method="POST" enctype="multipart/form-data">
                        <td><?php echo $room['room_id']; ?><input type="hidden" name="room_id" value="<?php echo $room['room_id']; ?>"></td>
                        <td><input type="text" name="room_name" value="<?php echo $room['room_name']; ?>"></td>
                        <td>
                            <select name="room_type">
                                <option value="Standard" <?php if($room['room_type']=='Standard') echo 'selected'; ?>>Standard</option>
                                <option value="Deluxe" <?php if($room['room_type']=='Deluxe') echo 'selected'; ?>>Deluxe</option>
                                <option value="Suite" <?php if($room['room_type']=='Suite') echo 'selected'; ?>>Suite</option>
                            </select>
                        </td>
                        <td><input type="number" name="price" value="<?php echo $room['price']; ?>"></td>
                        <td><input type="number" name="capacity" value="<?php echo $room['capacity']; ?>"></td>
                        <td>
                            <select name="status">
                                <option value="available" <?php if($room['status']=='available') echo 'selected'; ?>>Available</option>
                                <option value="booked" <?php if($room['status']=='booked') echo 'selected'; ?>>Booked</option>
                                <option value="maintenance" <?php if($room['status']=='maintenance') echo 'selected'; ?>>Maintenance</option>
                            </select>
                        </td>
                        <td>
                            <button name="action" value="update_room">Update</button>
                            <button class="delete" name="action" value="delete_room" onclick="return confirm('Delete this room?')">Delete</button>
                        </td>
                    </form>
                </tr>
                <?php } ?>
            </table>
        </div>
    </main>
</div>
</body>
</html>
