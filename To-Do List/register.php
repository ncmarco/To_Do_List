<?php
session_start();
require 'config.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $nume=$_POST['nume'];
    $prenume=$_POST['prenume'];
    $email=$_POST['email'];
    $parola=password_hash($_POST['parola'],PASSWORD_DEFAULT);

    $stmt=$conn->prepare("INSERT INTO users (nume, prenume, email, parola) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nume, $prenume, $email, $parola);

    if($stmt->execute()){
        header("Location: login.php");
    } 
    else{
        echo "Eroare: ".$stmt->error;
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
    <title>Înregistrare</title>
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
                            <?php else:?>
                                <ul>
                                    <li><a href="index.php">Acasă</a></li>
                                    <li class="dropdown">
                                        <a href="#" onclick="return false;" class="dropbtn">Utilizator</a>
                                        <div class="dropdown-content">
                                            <a href="#" onclick="return false;">Înregistrare</a>
                                            <a href="login.php">Logare</a>
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
                    <h1>Înregistrare</h1>
                    <form method="POST" action="register.php" id="registerForm">
                        <label for="nume">Nume:</label>
                        <input type="text" id="nume" name="nume" required><br>
                        <label for="prenume">Prenume:</label>
                        <input type="text" id="prenume" name="prenume" required><br>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required><br>
                        <label for="parola">Parolă:</label>
                        <input type="password" id="parola" name="parola" required><br>
                        <button type="submit">Înregistrează-te</button>
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
