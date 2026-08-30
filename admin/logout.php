<?php
// logout.php
session_start();

// Clear all session data
session_unset();
session_destroy();

// Also clear localStorage via JavaScript
echo "
<script>
  localStorage.removeItem('admin');
  window.location.href = 'login.html';
</script>
";
?>
