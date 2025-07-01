<?php
session_start();
unset($_SESSION['lives']);
unset($_SESSION['current']);
unset($_SESSION['riddles']);
unset($_SESSION['message']);
header("Location: treeRiddle.php");
exit;
