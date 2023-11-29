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
        <span>რეგისტრაცია</span>
        <div class="inputs">
        <input name="name" type="text" required placeholder="სკოლის სახელწოდება">
        <input name = "pass1" type="password"  required placeholder="მოიფიქრეთ პაროლი">
        <input name = "pass2" type="password" required placeholder="გაამეორეთ პაროლი">
        <input name = "email" type="email" required placeholder="სკოლის ელფოსტა">
        </div>
        <div class="checkboxes">
            <span>აირჩიეთ რა სახის ნივთებს შეაგროვებთ</span>

            <div class="check-cont"> 

                <div>
                    <input name="plastic" type="checkbox">
                    <span>პლასტამასი</span>
                </div>

                <div>
                    <input name="battery" type="checkbox">
                    <span>ელემენტები</span>
                </div>

                <div>
                    <input name="paper" type="checkbox">
                    <span>მაკულატურა</span>
                </div>

            </div>
        </div>

    <div class="register">
        <button class="reg" type="submit">რეგისტაცია</button>
        <a href="login.php">უკვე გაქვთ აქაუნთი</a>
    </div>
    
    <?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Form = $_POST;
    $UserName = $Form['name'];
    $Password = $Form['pass1'];
    $PasswordR = $Form['pass2'];
    $email = $Form['email'];
    $Plactic = isset($Form['plastic']) ? 1 : 0;
    $Battery = isset($Form['battery']) ? 1 : 0;
    $Paper = isset($Form['paper']) ? 1 : 0;

    if ($Password === $PasswordR) {
        $conn = new mysqli('localhost', 'root', '', 'Nature');

        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        // Проверка наличия имени пользователя в базе данных
        $check_query = $conn->prepare("SELECT * FROM accounts WHERE `name` = ?");
        $check_query->bind_param("s", $UserName);
        $check_query->execute();
        $result = $check_query->get_result();

        if ($result->num_rows > 0) {
            echo "მასეთი სახელი უკვე არსებობს.";
        } else {
            // Используем подготовленный запрос для вставки данных
            $insert_query = $conn->prepare("INSERT INTO accounts (`name`, `password`, `email`,`coins`, `battery`, `plastic`, `paper`) VALUES (?, ?, ?, 0, ?, ?, ?)");
            $insert_query->bind_param("sssiii", $UserName, $Password, $email, $Battery, $Plactic, $Paper);

            if ($insert_query->execute()) {
                // Успешная регистрация, теперь выполним аутентификацию
                $_SESSION['username'] = $user_data['name']; // Используем поле 'name' из таблицы
                $_SESSION['coins'] = $user_data['coins'];
                $_SESSION['battery'] = $user_datar['battery'];
                $_SESSION['plastic'] = $user_datar['plastic'];
                $_SESSION['paper'] = $user_datar['paper'];
                echo "თქვენ წარმატებით დარეგისტრირდით. მოგესალმებით, $UserName!";
                header('Location: main.php');
                exit;
            } else {
                echo "შეცდომა რეგისტრაციისას: " . $insert_query->error;
            }

            $insert_query->close();
        }

        $check_query->close();
        $conn->close();
    } else {
        echo "პირველი პაროლი არ ემთხვევა მეორეს";
    }
}
?>


    </form>


    <img src="IMG/Recycle-Logo.png" alt="">

</main>
</body>
</html>


