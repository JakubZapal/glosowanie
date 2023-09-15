<?php
session_start();

// Połączenie z bazą danych MySQL
$db = new mysqli("localhost", "zapal_glosowanie", "KkfnagCjRFN4QZS6lh7", "zapal_glosowanie");
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=zapal_glosowanie", "zapal_glosowanie", "KkfnagCjRFN4QZS6lh7");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT `name`, `votes` FROM `candidates`";
    $statement = $pdo->prepare($query);
    $statement->execute();

    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Błąd bazy danych: " . $e->getMessage();
}

foreach ($data as $row) {
    $labels[] = $row['name'];
    $values[] = $row['votes'];
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyniki Wyborów</title>
    <!-- Dodaj tutaj kod JavaScript i bibliotekę do wykresu, np. Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h4>Wyniki Wyborów</h4>
            <div class="col-md-12">
                <canvas id="myChart"></canvas>
            </div>
        
         <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var data = {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Ilość głosów',
                    data: <?php echo json_encode($values); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };
        
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
         </script>
        <br>
    </div>
</body>
</html>
