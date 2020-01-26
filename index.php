<?php
session_start();
//Index file for pointing to the HomePage
if(isset($_SESSION['username'])){
    header("Location: .\View\Dashboard\dashboard.php");
    // include_once dirname(__FILE__)."/View/Dashboard/dashboard.php";
}
else{
    header("Location: .\View\home.php");
    // include_once dirname(__FILE__)."\View\home.php";
}

?>
