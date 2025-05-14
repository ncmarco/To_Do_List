<?php
session_start();
require 'config.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id=$_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD']=='POST'){
    $task=$_POST['task'];

    $stmt=$conn->prepare("INSERT INTO tasks (user_id, task) VALUES (?, ?)");
    $stmt->bind_param("is",$user_id,$task);

    if($stmt->execute()){
        $task_id=$stmt->insert_id;
        $stmt=$conn->prepare("SELECT id, task, completed FROM tasks WHERE id = ?");
        $stmt->bind_param("i",$task_id);
        $stmt->execute();
        $result=$stmt->get_result();
        $new_task=$result->fetch_assoc();
        echo json_encode($new_task);
    } 
    else{
        echo json_encode(array('error'=>$stmt->error));
    }

    $stmt->close();
    $conn->close();
    exit;
}
$tasks=[];
$stmt=$conn->prepare("SELECT id, task, completed FROM tasks WHERE user_id = ?");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$result=$stmt->get_result();
while($row=$result->fetch_assoc()) {
    $tasks[]=$row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <table class="layout">
        <tr>
            <td colspan="2">
                <header>
                    <nav>
                        <div class="nav-container">
                            <?php if(isset($_SESSION['user_id'])):?>
                                <span class="welcome-message">Bun venit, <?= htmlspecialchars($_SESSION['nume']) . ' ' . htmlspecialchars($_SESSION['prenume']); ?>!</span>
                                <ul>
                                    <li><a href="index.php">Acasă</a></li>
                                    <li><a href="#" onclick="return false;">To-Do List</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                </ul>
                            <?php else:?>
                                <ul>
                                    <li><a href="index.php">Acasă</a></li>
                                    <li class="dropdown">
                                        <a href="#" onclick="return false;" class="dropbtn">Utilizator</a>
                                        <div class="dropdown-content">
                                            <a href="register.php">Înregistrare</a>
                                            <a href="login.php">Logare</a>
                                        </div>
                                    </li>
                                    <li><a href="#" onclick="return false;">To-Do List</a></li>
                                </ul>
                            <?php endif;?>
                        </div>
                    </nav>
                </header>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <main>
                    <h1>To-Do List</h1>
                    <form id="todoForm" method="POST" action="todo.php">
                        <label for="task">Adaugă sarcină:</label>
                        <input type="text" id="task" name="task" required>
                        <button type="submit">Adaugă</button>
                    </form>
                    <div id="taskList">
                        <h2>Sarcinile tale:</h2>
                        <ul id="tasks">
                            <?php foreach($tasks as $task): ?>
                                <li data-id="<?= $task['id'] ?>" class="<?= $task['completed']?'completed':''?>">
                                    <img src="check.png" class="check" alt="check icon">
                                    <?= htmlspecialchars($task['task'])?>
                                    <img src="x.png" alt="delete icon" class="delete">
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </main>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <footer>
                    <p>&copy; 2024 To-Do List</p>
                </footer>
            </td>
        </tr>
    </table>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>
