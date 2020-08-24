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
        <a class="navbar-brand" href="index.php">Works</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
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

    <div class="row justify-content-between">
        <input id="addButton" type="button" value="Добавить сотрудника" class="btn btn-success btn-sm"/>

        <form action="employees.php" class="form-inline" method="POST">
            <input class="form-control form-control-sm"
                   type="search"
                   name="searchEmployee"
                   placeholder="Поиск">
            <button class="btn btn-outline-success btn-sm" type="submit">Найти</button>
        </form>
    </div>

    <?php

    require_once 'DB.Config.php';

    if (isset($_POST['searchEmployee'])) {
        $search = $_POST['searchEmployee'];
        $querySelect = "SELECT id, name, surname, dateOfBirth, departmentId 
                        FROM person
                        WHERE person.name LIKE '$search%' 
                        OR person.surname LIKE '$search%'";
    } else $querySelect = "SELECT id, name, surname, dateOfBirth, departmentId, photoPath 
                           FROM person
                           ORDER BY name";
    $result = $link->query($querySelect);

    echo "<table class='table table-striped'>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Surname</th>
                <th>DOB</th>
                <th class='text-center'>Dep. ID</th>
                <th></th>
            </tr>";
    while ($row = mysqli_fetch_array($result)) {
        $photoPath = empty($row['photoPath']) ? 'uploads/img/default.png' : $row['photoPath'];
        echo "<tr>";
        echo "<td style='text-align: center;'> <img src='{$photoPath}' width='50px' height='50px'> </td>" .
            "<td> {$row['name']} </td>" .
            "<td> {$row['surname']} </td>" .
            "<td> {$row['dateOfBirth']} </td>" .
            "<td class='text-center'>";
        if (empty($row['departmentId'])) {
            echo "<button class='btn btn-primary btn-sm'>Добавить в отдел</button>";
        } else {
            echo "{$row['departmentId']} ";
        }
        echo "</td>";
        echo '<td class="text-center"><a href="delete.php?id=' . $row['id'] . '">
                <button class="btn btn-danger btn-sm">Удалить</button></a>';
        echo '<a href = "edit.php?id=' . $row['id'] . '">
                <button id = "editButton"
                        class="btn btn-primary btn-sm">Редактировать</button ></a></td> ';
        echo "</tr>";
    }
    echo "</table>";
    ?>

    <div id="modalForm" class="modal">
        <div class="modal_content">
            <span class="modal-close">&times</span>
            <div class="modal-header">
                <h3>Добавить сотрудника</h3>
            </div>

            <div class="container modal-body">
                <div class="row justify-content-md-center">
                    <form action="" method="POST" id="addPersonForm" enctype="multipart/form-data">
                        <div class="row">
                            <div style="margin: 5px;">
                                <label for="name">Имя:</label>
                                <input class="form-control" type="text" id="name" name="name">
                            </div>

                            <div style="margin: 5px;">
                                <label for="surname">Фамилия:</label>
                                <input class="form-control" type="text" id="surname" name="surname">
                            </div>

                            <div style="margin: 5px;">
                                <label for="dateOfBirth">Дата рождения:</label>
                                <input class="form-control" type="date" id="dateOfBirth" name="dateOfBirth">
                            </div>

                            <div style="margin: 5px;">
                                <label for="departmentId">Отдел:</label>
                                <select class="form-control" name="department">
                                    <?php
                                    $querySelect = "SELECT id, title FROM department";
                                    $result = $link->query($querySelect);
                                    echo "<option value='0'></option>";
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<option value='{$row['id']}'>{$row['title']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div style="margin: 5px;">
                                <label for="photo">Фото:</label>
                                <input type="file" class="form-control-file" name="photo" id="photo">
                            </div>

                        </div>

                        <div class="row justify-content-md-center">
                            <button type="submit" class="btn btn-primary" onclick="onSubmitAddPersonForm()">Подтвердить</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/modalForm.js"></script>

</body>
</html>