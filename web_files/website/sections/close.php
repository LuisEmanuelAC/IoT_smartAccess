<?php
session_start();
session_destroy();
header("Location: /IoT_smartAccess/web_files/website/sections/login.php");
?>