<?php
session_start();

// Połączenie z bazą danych MySQL
$db = new mysqli("localhost", "zapal_glosowanie", "KkfnagCjRFN4QZS6lh7", "zapal_glosowanie");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Funkcja do sprawdzania, czy użytkownik jest zalogowany
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Funkcja do pobierania listy kandydatów
function getCandidates() {
    global $db;
    $candidates = array();
    $sql = "SELECT * FROM candidates";
    $result = $db->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $candidates[] = $row;
        }
    }
    return $candidates;
}

// Funkcja do głosowania
function vote($user_id, $candidate_id) {
    global $db;
    $sql = "INSERT INTO votes (user_id, candidate_id) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $user_id, $candidate_id);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        $sql = "UPDATE candidates SET votes = votes + 1 WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $candidate_id);
        $stmt->execute();
        return true;
    }

    return false;
}

// Główna część aplikacji
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isUserLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $candidate_id = intval($_POST['candidate_id']);

        if (vote($user_id, $candidate_id)) {
            $_SESSION['voted'] = true;
            header('Location: results.php');
            exit();
        }
    }
}

// Wylogowywanie użytkownika
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wybory Parlamentarne</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container">        
        <h1>Wybory Parlamentarne</h1>
        <?php
        $q = mysqli_query($db, "SELECT candidate_id FROM votes WHERE user_id = '$_SESSION[user_id]'");
        if(mysqli_num_rows(($q))>0)
            $_SESSION['voted'] = true;
        if (isUserLoggedIn() && !isset($_SESSION['voted'])): ?>
            <form method="post">
                <p>Wybierz swojego kandydata:</p>
                <select name="candidate_id">
                    <option value="">-</option>
                    <?php $candidates = getCandidates(); ?>
                    <?php foreach ($candidates as $candidate): ?>
                        <option value="<?= $candidate['id'] ?>"><?= $candidate['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <input type="submit" value="Oddaj głos">
            </form>
        <?php elseif (isset($_SESSION['voted'])): ?>
            <p>Twój głos został oddany. Dziękujemy!</p>
            <!-- <p><a href="results.php">Zobacz wyniki</a></p> -->
            <?php include('results.php'); ?>
        <?php else: ?>
            <p>Zaloguj się, aby oddać głos.</p>
            <a href="login.php">Zaloguj</a>
        <?php endif; ?>

        <?php if (isUserLoggedIn()): ?>
            <br>
            <a href="?logout=1">Wyloguj</a>
        <?php endif; ?>
    </div>
</body>
</html>
