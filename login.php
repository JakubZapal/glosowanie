<?php
    session_start();
    $c = mysqli_connect("localhost", "zapal_glosowanie", "KkfnagCjRFN4QZS6lh7", "zapal_glosowanie");
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $q = mysqli_query($c, "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password';");
        if (mysqli_num_rows($q) == 1) {
            $row = mysqli_fetch_row($q);
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['user_id'] = $row[0];
            Header("Location: index.php");
        } 
        else {
            echo "<div class='form'>
                  <h3>Złe hasło/email.</h3><br/>
                  <p><a href='index.php'>Zaloguj się ponownie</a><p>
                  </div>";
        }
    } 
    
    else {
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form method="post" class="col-11 col-sm-5 col-md-3">
            <h1 class="login-title">Logowanie</h1>
            <div class="row col-12">
                <input type="text" name="username" placeholder="Nazwa użytkownika" autofocus required/>
            </div>
            <div class="row col-12">
                <input type="password" name="password" placeholder="Hasło"/>
            </div>
            <p>Nie masz konta? <a href="registration.php">Zarejestruj się!</a></p>
            <input type="submit" value="Zaloguj się"/>
      </form>
    <?php
        }
    ?>   
    </div>
</body>
</html>