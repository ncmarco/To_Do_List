<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acasă</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <table class="layout">
        <tr>
            <td colspan="2">
                <header>
                    <nav>
                        <div class="nav-container">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <span class="welcome-message">Bun venit, <?= htmlspecialchars($_SESSION['nume']) . ' ' . htmlspecialchars($_SESSION['prenume']); ?>!</span>
                                <ul>
                                    <li><a href="#" onclick="return false;">Acasă</a></li>
                                    <li><a href="todo.php">To-Do List</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                    
                                </ul>
                            <?php else: ?>
                                <ul>
                                    <li><a href="#" onclick="return false;">Acasă</a></li>
                                    <li class="dropdown">
                                        <a href="#" onclick="return false;" class="dropbtn">Utilizator</a>
                                        <div class="dropdown-content">
                                            <a href="register.php">Înregistrare</a>
                                            <a href="login.php">Logare</a>
                                        </div>
                                    </li>
                                    <li><a href="todo.php">To-Do List</a></li>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </nav>
                </header>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <main>
                    <h1>Despre aplicație</h1>
                    <p>To-Do List te ajută să îți organizezi și gestionezi sarcinile zilnice într-un mod eficient și simplu. <br>Adaugă rapid noi sarcini, taie-le pe cele completate, șterge-le pe cele de care nu mai ai nevoie și păstrează o evidență clară a activităților tale.<br> Începe acum să-ți administrezi timpul eficient și să îți atingi obiectivele cu ușurință!</p>
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
