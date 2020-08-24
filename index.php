<!DOCTYPE html>
<html lang="en-US">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Организация</title>
</head>
<body>
<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand active" href="index.php">Works</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
       
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="employees.php">Сотрудники<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="departments.php">Отделы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="confirm.php">На утверждение</a>
                </li>
            </ul>
        </div>
    </nav>
<?php

    require_once 'DB.Config.php';

    $querySelect = "SELECT person.id, person.name, person.surname, department.title 
                    FROM `person` 
                    INNER JOIN `department` 
                    ON person.departmentId = department.id
                    ORDER BY person.name";
    $result = $link->query($querySelect);

    echo "<table class='table table-striped'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Department</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td> {$row['id']} </td>" .
            "<td> {$row['name']} </td>" .
            "<td> {$row['surname']} </td>" .
            "<td> {$row['title']} </td>";
        echo "</tr>";
    }
    echo "</table>";
?>

</div>

</body>
</html>