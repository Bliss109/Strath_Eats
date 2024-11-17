<?php
session_start();
session_unset();
session_destroy();
header("location: ../Registration/index.php");
exit();
?>
