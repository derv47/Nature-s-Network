<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>რეგისტაცია</title>
    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>

<?php require_once 'header.php'; ?>




<main>

    <form action="" method="post">
        <span>შესვლა</span>
        <div class="inputs">
        <input name="name" type="text" placeholder="სკოლის ელფოსტა">
        <input name="password" type="password" placeholder="შეიყვანეთ პაროლი">
        </div>

    <div class="register">
        <button class="reg" type="submit">შესვლა</button>
        <a href="regin.php">ჯერ არ გაქვთ აქაუნტი</a>
    </div>

    <?php
        session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
            $Form = $_POST;
            $email = $Form['name'];
            $loginPassword  = $Form['password'];

            $conn = new mysqli('localhost', 'root', '', 'Nature');

            if ($conn->connect_error) {
                die("Ошибка подключения: " . $conn->connect_error);
            }

            // Используем подготовленный запрос для проверки аутентификации
            $login_query = $conn->prepare("SELECT * FROM accounts WHERE `email` = ? AND `password` = ?");
            $login_query->bind_param("ss", $email, $loginPassword);
            $login_query->execute();
            $result = $login_query->get_result();

            if ($result->num_rows > 0) {
                // Успешная аутентификация. Получаем данные из результата запроса
                $user_data = $result->fetch_assoc();
                $_SESSION['username'] = $user_data['name']; // Используем поле 'name' из таблицы
                $_SESSION['coins'] = $user_data['coins'];
                $_SESSION['battery'] = $user_datar['battery'];
                $_SESSION['plastic'] = $user_datar['plastic'];
                $_SESSION['paper'] = $user_datar['paper'];
                $_SESSION['admin'] = False;
                echo "მოგესალმებით, {$_SESSION['username']}! თქვენ გაქვთ {$_SESSION['coins']} მონეტა.";
                header('Location: main.php');
                exit;
            } else {
                echo "შეცდომა: არასწორი მომხმარებლის სახელი ან პაროლი.";
            }

            $login_query->close();
            $conn->close();
        }
    ?>

    </form>

    <form action="" method="post">
        <span>კომპანიის სახით შესხვლა</span>
        <div class="inputs">
        <input name="adminname" type="text" placeholder="კომპანიის სახელი">
        <input name="adminpassword" type="password" placeholder="შეიყვანეთ პაროლი">
        </div>

    <div class="register">
        <button class="reg" type="submit">შესვლა</button>
    </div>
    <?php
        session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adminname']) ) {
            $Form = $_POST;
            $name = $Form['adminname'];
            $AdminloginPassword  = $Form['adminpassword'];

            $conn = new mysqli('localhost', 'root', '', 'Nature');

            if ($conn->connect_error) {
                die("Ошибка подключения: " . $conn->connect_error);
            }

            // Используем подготовленный запрос для проверки аутентификации
            $login_query = $conn->prepare("SELECT * FROM admins WHERE `name` = ? AND `password` = ?");
            $login_query->bind_param("ss", $name, $AdminloginPassword);
            $login_query->execute();
            $result = $login_query->get_result();

            if ($result->num_rows > 0) {
                // Успешная аутентификация. Получаем данные из результата запроса
                $user_data = $result->fetch_assoc();
                $_SESSION['username'] = $user_data['name']; // Используем поле 'name' из таблицы
                $_SESSION['admin'] = True;
                echo "მოგესალმებით, {$_SESSION['username']}! თქვენ გაქვთ {$_SESSION['coins']} მონეტა.";
                header('Location: profile.php');
                exit;
            } else {
                echo "შეცდომა: არასწორი მომხმარებლის სახელი ან პაროლი.";
            }

            $login_query->close();
            $conn->close();
        }
    ?>
    </form>

    <!-- <img src="IMG/Recycle-Logo.png" alt=""> -->


</main>
</body>
</html>