<?php
session_start();
session_unset();
session_destroy();
header("Location: /BOOKSHOP/login.html");
exit;
?>
