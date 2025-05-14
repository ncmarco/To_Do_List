<?php
session_start();
require 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $task_id=$_POST['id'];

    $stmt=$conn->prepare("DELETE FROM tasks WHERE id=? AND user_id=?");
    $stmt->bind_param("ii",$task_id,$_SESSION['user_id']);

    if($stmt->execute()){
        echo json_encode(array('success'=>true));
    }
    else{
        echo json_encode(array('error'=>$stmt->error));
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
