<?php
session_start();


//Clear Session
$_SESSION["member_id"] = "";
session_destroy();

header("Location: ./");
?>