<?php
    $error = '';
    $c = mysqli_connect("localhost", "zapal_glosowanie", "KkfnagCjRFN4QZS6lh7", "zapal_glosowanie");
    if ($_POST['password'] == $_POST['password']){
        $q = mysqli_query($c, "SELECT * FROM `users` WHERE `username` = '$_POST[username]';");
        if (mysqli_num_rows($q)>=1)
            $error = "Taki e-mail jest już zajęty";
        else 
        {
            $sql = mysqli_query ($c, "INSERT INTO `users` SET `username` = '$_POST[username]', `password` = '$_POST[password]';");
            Header("location: index.php");
        }
        }
    
    ?>
    <!DOCTYPE html>
    <html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rejestracja</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
        <div class="container">
            <form action="?" method="post">
                <h1>Rejestracja</h1>
                <div class="row col-12">
                    <input type="text" name="username" placeholder="Nazwa użytkownika">
                </div>
                <div class="row col-12">
                    <input type="password" name="password" placeholder="Hasło">
                </div>
                <div class="row col-12">
                    <input type="password" name="v_password" placeholder="Powtórz hasło">
                </div>

                <input type="submit" value="Zarejestruj się">
                <p>Masz konto? <a href="login.php">Zaloguj się</a></p>
            </form>
        </div>
    </body>
    </html>
