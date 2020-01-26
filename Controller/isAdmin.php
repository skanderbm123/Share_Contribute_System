<?php
session_start();
if($_SESSION['isAdmin'] == 1) {
    $result = 1;
} else {
    $result = 0;
}

echo json_encode($result)
?>