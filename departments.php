<!DOCTYPE html>
<html lang="en-US">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Список отделов</title>
</head>
<body>
<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">Works</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="employees.php">Сотрудники<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="departments.php">Отделы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="confirm.php">На утверждение</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="row justify-content-between">
        <input id="addButton" type="button" value="Добавить отдел" class="btn btn-success btn-sm"/>
    </div>

    <?php

    require_once 'DB.Config.php';

    $querySelect = "SELECT department.id, department.title, COUNT(person.departmentId) as count 
                    FROM `person` 
                    RIGHT JOIN `department` ON person.departmentId = department.id
                    GROUP BY department.title
                    ORDER BY department.title";
    $result = $link->query($querySelect);

    echo "<table class='table table-striped'>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Количество сотрудников</th>
            </tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td> {$row['id']} </td>" .
            "<td> {$row['title']} </td>" .
            "<td> {$row['count']} </td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>

    <div id="modalForm" class="modal">
        <div class="modal_content">
            <span class="modal-close">&times</span>
            <div class="modal-header">
                <h3>Добавить отдел</h3>
            </div>

            <div class="container modal-body">
                <div class="row justify-content-md-center">
                    <form action="add.php" method="POST" id="addDepartmentButton">
                        <div class="row">
                            <div style="margin: 5px;">
                                <label for="title">Название:</label>
                                <input class="form-control" type="text" id="title" name="title">
                            </div>
                        </div>

                        <div class="row justify-content-md-center">
                            <button type="submit" class="btn btn-primary">Подтвердить</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="js/modalForm.js"></script>

</body>
</html>