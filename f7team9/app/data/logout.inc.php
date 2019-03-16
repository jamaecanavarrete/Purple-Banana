<?php

// If logout is pressed
if (isset($_POST['submit'])){
    session_start();
    session_unset();
    session_destroy();
    header("Location: ?page=index");
    exit();
} //logs out and goes back to index.php