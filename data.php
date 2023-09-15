<?php
    header('Content-Type: application/json');

    $conn = mysqli_connect("localhost","zapal_glosowanie","KkfnagCjRFN4QZS6lh7","zapal_glosowanie");

    $sqlQuery = "SELECT `id`, `name`, `votes` FROM candidates ORDER BY id";

    $result = mysqli_query($conn,$sqlQuery);

    $data = [];

    foreach ($result as $row) {
        $data[] = $row;
    }

    mysqli_close($conn);

    echo json_encode($data);
?>