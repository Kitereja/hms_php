<?php
session_start();
session_destroy();
?>
<script>
sessionStorage.removeItem('hms_logged_in');
window.location.href = 'login.php?msg=Logged out successfully';
</script>
