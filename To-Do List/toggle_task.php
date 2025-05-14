<?php
session_start();
require 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $task_id=$_POST['id'];

    $stmt=$conn->prepare("UPDATE tasks SET completed = NOT completed WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);

    if($stmt->execute()){
        $stmt=$conn->prepare("SELECT id, task, completed FROM tasks WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
        $stmt->execute();
        $result=$stmt->get_result();
        $task=$result->fetch_assoc();
        echo json_encode($task);
    } 
    else{
        echo json_encode(array('error'=>$stmt->error));
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
