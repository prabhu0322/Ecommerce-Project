<?php
require_once('includes/session_start.php');

$_SESSION['cart_session'] = [];

return header("Location:cart.php?msg=Cart Cleared&success=1");
