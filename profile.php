<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php session_start(); echo $_SESSION['username'];?> </title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="form.css">
</head>
<body>
    
    <?php require_once 'header.php'; ?>

    <div class="history">

    <?php
    session_start();
    if ($_SESSION['admin'] === True) {
        echo "<span class=\"SchoolName\">მოგესალმებით {$_SESSION['username']}</span>";
    }
    if ($_SESSION['admin'] === False) {
        echo  "<div class=\"MainInfo\">
            <span class=\"SchoolName\"> {$_SESSION['username']}</span>
            <span class=\"CoinsCount\"> {$_SESSION['coins']} GreenCoin</span>

                <div class=\"ProTextPart\">
        
                <span class=\"ProTitle\">შეაგროვე 1000 greencoin-ი და მიიღე უნიკალური პრიზები!</span>

                <progress value={$_SESSION['coins']} max=\"1000\"> </progress>

                <span class=\"proResult\"> {$_SESSION['coins']} /1000</span>
            </div>
        </div>";
    }
    ?>
    <?php
    session_start();
    if ($_SESSION['admin'] === False) {
        echo "
        <div class=\"MainHistory\">
            <span class=\"HistoryTitle\">თქვენი მონაწილეობის ისტორია</span>
            <span class=\"HistorySubTitle\">ჯერჯერობით თქვენ არ მიგიღიათ მონაწილეობა ჩვენს პროექტში</span>
        </div>";
    }
    ?>

<?php
        if ($_SESSION['admin'] === True) {
        echo "
        <form action='' method='post' style='width:660px;'>
            <span>GreenCoin-ების მინიჭება</span>
            <div class='inputs'>
            <input style='width:600px;' name='name' type='text' placeholder='სკოლის ელფოსტა'>
            <input style='width:600px;' name='count' type='number' placeholder='შეიყვანეთ GreenCoin-ების რაოდენობა'>
            </div>

        <div class='register'>
            <button class='reg' type='submit'>მინიჭება</button>
        </div> </form>";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
            $Form = $_POST;
            $email = $Form['name'];
            $count  = $Form['count'];

            $conn = new mysqli('localhost', 'root', '', 'Nature');

            if ($conn->connect_error) {
                die("Ошибка подключения: " . $conn->connect_error);
            }

            // Используем подготовленный запрос для проверки аутентификации
            $login_query = $conn->prepare("SELECT * FROM accounts WHERE `email` = ?");
            $login_query->bind_param("s", $email);
            $login_query->execute();
            $result = $login_query->get_result();

            if ($result->num_rows > 0) {
                $update_query = $conn->prepare("UPDATE accounts SET `coins` = ? WHERE `email` = ?");
                $update_query->bind_param("is", $count, $email);
                $update_query->execute();
                echo 'ქოინება წარმატებით გაიგზავნა!';
            } else {
                echo "შეცდომა: არასწორი მომხმარებლის სახელი ან პაროლი.";
            }

            $login_query->close();
            $conn->close();
        }
    ?>


    <a class="MainHistory" style="width:660px;align-items:center; justify-content:center; text-decoration:none; color:red; text-align:center;" href="reset.php">აქაუნთიდან გამოსვლა</a>
    



    </div>


</body>
</html>

<style>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Georgian:wght@100;200;300;400;500;600;700;800;900&display=swap');

    .history {
        width:100vw;
        height:90vh;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:20px;
        flex-direction:column;
    }
    .MainInfo {
        display: flex;
        width: 660px;
        padding: 40px 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        background: #FFF;
        box-shadow: 2px 2px 4px 4px rgba(0, 0, 0, 0.25);
    }
    .SchoolName {
        color: #000;
        font-family: Noto Sans Georgian;
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    .CoinsCount {
        color: #000;
        font-family: Noto Sans Georgian;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    .MainHistory {
        display: flex;
        padding: 20px 20px;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        background: #FFF;
        box-shadow: 2px 2px 4px 4px rgba(0, 0, 0, 0.25);
    }
    .HistoryTitle {
        color: #000;
        font-family: Noto Sans Georgian;
        font-size: 30px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }
    .HistorySubTitle {
        display: flex;
        width: 620px;
        height: 140px;
        padding: 33px 0px;
        justify-content: center;
        align-items: center;
        gap: 10px;
        border-top: 1px solid #000;
    }
</style>