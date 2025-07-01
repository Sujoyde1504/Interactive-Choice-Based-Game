<?php
session_start();
unset($_SESSION['board']);
unset($_SESSION['target']);
unset($_SESSION['start_time']);
header("Location: hexagon.php");
exit;
