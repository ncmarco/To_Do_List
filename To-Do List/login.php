<?php
session_start();
require 'config.php';
$error_message='';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $email=$_POST['email'];
    $parola=$_POST['parola'];

    $stmt=$conn->prepare("SELECT id, nume, prenume, parola FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $nume, $prenume, $hash);
    $stmt->fetch();

    if($stmt->num_rows>0 && password_verify($parola, $hash)) {
        $_SESSION['user_id']=$id;
        $_SESSION['nume']=$nume;
        $_SESSION['prenume']=$prenume;
        header("Location: index.php");
    } 
    else{
        $error_message="Email sau parolă incorecte!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logare</title>
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
                                <span class="welcome-message">Bun venit, <?= htmlspecialchars($_SESSION['nume']).' '.htmlspecialchars($_SESSION['prenume']);?>!</span>
                                <ul>
                                    <li><a href="#" onclick="return false;">Acasă</a></li>
                                    <li><a href="todo.php">To-Do List</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                    
                                </ul>
                            <?php else: ?>
                                <ul>
                                    <li><a href="index.php">Acasă</a></li>
                                    <li class="dropdown">
                                        <a href="#" onclick="return false;" class="dropbtn">Utilizator</a>
                                        <div class="dropdown-content">
                                            <a href="register.php">Înregistrare</a>
                                            <a href="#" onclick="return false;">Logare</a>
                                        </div>
                                    </li>
                                    <li><a href="todo.php">To-Do List</a></li>
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
                    <h1>Logare</h1>
                    <form method="POST" action="login.php" id="loginForm">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required><br>
                        <label for="parola">Parolă:</label>
                        <input type="password" id="parola" name="parola" required><br>
                        <button type="submit">Autentificare</button>
                        <?php if($error_message):?>
                            <p class="error-message"><?= htmlspecialchars($error_message);?></p>
                        <?php endif;?>
                    </form>
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
</body>
</html>
