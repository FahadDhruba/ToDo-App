<?php
session_start();

if(isset($_POST['title'])){
    include('../config/config.php');

    $title = $_POST['title'];
    $time = time();

    if(empty($title)){
        $_SESSION['status']='error';
        header("Location: ../");
    }else {
        $res = mysqli_query($con, "INSERT INTO `todos` (`id`, `title`, `time`, `checked`) VALUES (NULL, '$title',  '$time', '0');");
        
        if($res){
            $_SESSION['success']='task added';
            header("Location: ../"); 
        }else {
            header("Location: ../");
        }
        $conn = null;
        exit();
    }
}else {
    $_SESSION['status']='error';
    header("Location: ../");
}