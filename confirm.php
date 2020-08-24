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

    if (isset($_COOKIE["newEmployee"]) && count($_COOKIE["newEmployee"]) > 0) {
        echo "<table class='table table-striped'>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Surname</th>
                <th>DOB</th>
                <th class='text-center'>Dep. ID</th>
            </tr>";
        $array = explode(';', $_COOKIE["newEmployee"]);
        foreach ($array as &$item) {
            $json = json_decode($item, true);
            $photoPath = empty($json['filename']) ? 'uploads/img/default.png' : $json['filename'];
            echo "<tr>";
            echo "<td style='text-align: center;'> <img src='{$photoPath}' width='50px' height='50px'> </td>" .
                "<td> {$json['name']} </td>" .
                "<td> {$json['surname']} </td>" .
                "<td> {$json['dateOfBirth']} </td>" .
                "<td class='text-center'> {$json['department']} </td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<form action='add.php' method='POST'><input value='confirm' name='confirm' hidden/><button class='btn btn-primary' type='submit'>Утвердить</button></form>";
    } else {
        echo '<div class="row justify-content-center ">
                    <div class="col-10 text-center">
                    <p>Нет данных.</p>
                    </div>
              </div>';
    }
    ?>

</div>

<script src="js/jquery-3.5.1.min.js"></script>

</body>
</html>