<?php
session_start();
if(session_destroy()){
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php");
}
?>