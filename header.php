<header>
    <a href="main.php" class="logo">Nature's Network</a>

    <div class="optionBlock">
        <a href="main.php#main" class="option">პროექტის შესახებ</a>

        <?php
        session_start();
            if ($_SESSION['admin'] === False) {
                $coinsBtn = '<div class="coins"> <span>'. $_SESSION['coins']. '</span> <img id="coins" src="IMG/GreenCoinSecond.png"> </div>';
            } else {
                $coinsBtn = '';
                echo "<style> #name {padding:10px 20px} </style>";
            }
            // Проверяем, установлена ли сессия
            session_start();
            if (isset($_SESSION['username'])) {
                // Если установлена, значит, пользователь вошел в систему
                echo '';
                echo '<a href="profile.php" class="option wellcome">'. $coinsBtn .
                '<span id="name">'.$_SESSION['username'].'</span>' . '</a>';
            } else {
                // Если не установлена, значит, пользователь не вошел в систему
                echo '<a href="login.php" class="option">შესვლა</a>';
                echo '<a class="reg" href="regin.php">რეგისტრაცია</a>';
            }
        ?>

        
    </div>
</header>

