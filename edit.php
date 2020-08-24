<!DOCTYPE html>
<html lang="en-US">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <title>Профиль</title>
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
                    <a class="nav-link" href="departments.php">На утверждение</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php
    if (isset($_GET['id'])) {
        require 'DB.Config.php';
        $querySelect = "SELECT id, name, surname, dateOfBirth, departmentId, photoPath FROM person WHERE id='{$_GET["id"]}'";
        $result = $link->query($querySelect);
        $row = mysqli_fetch_row($result);
        $id = $row[0];
        $photoPath = empty($row[5]) ? 'uploads/img/default.png' : $row[5];

        echo '<form method="POST" enctype="multipart/form-data">
                <div style="margin: 5px;">
                                <img src="' . $photoPath . '" width="100px" height="100px">                                                              
                </div>
                <div style="margin: 5px">
                    <input type="file" class="form-control-file" name="photo">
                </div>
        <input name="id" value="' . $row[0] . '" hidden>
        <div style="margin: 5px;">
            <label for="name">Имя:</label>
            <input class="form-control" 
                   type="text" 
                   id="name" 
                   name="name"
                   value="' . $row[1] . '"></div>

        <div style="margin: 5px;">
            <label for="surname">Фамилия:</label>
            <input class="form-control" type="text" id="surname" name="surname" value="' . $row[2] . '" >
        </div>

        <div style="margin: 5px;">
            <label for="dateOfBirth">Дата рождения:</label>
            <input class="form-control" type="date" id="dateOfBirth" name="dateOfBirth" value="' . $row[3] . '">
        </div>

        <div style="margin: 5px;">
                        <label for="departmentId">Отдел:</label>
                        <select class="form-control" name="department">';
        $selectOptions = "SELECT id, title FROM department";
        $result = $link->query($selectOptions);
        while ($options = mysqli_fetch_array($result)) {
            $isSelected = ($options['id'] == $row[4]) ? 'selected' : '';
            echo '<option value="' . $options['id'] . '" ' . $isSelected . '>' . $options['title'] . '</option>';
        }
        echo '</select>
                    </div> ';
        echo '<div>
            <input type="submit" class="btn btn-primary" value="Подтвердить">
        </div>
            </form>';
    }
    ?>
</div>

</body>
</html>
<?php
if (isset($_POST['name']) && isset($_POST['surname'])
    && isset($_POST['id']) && isset($_POST['dateOfBirth']) && isset($_POST['department'])) {
    require 'DB.Config.php';
    $id = $_POST['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $departmentId = $_POST['department'];
    $fileName = !empty($_FILES['photo']['name']) ? 'uploads/img/' . $_FILES['photo']['name'] : '';
    header("Location: employees.php");
    move_uploaded_file($_FILES['photo']['tmp_name'], $fileName);
    $query = "UPDATE person SET name='$name', 
                                    surname='$surname' ,
                                    dateOfBirth='$dateOfBirth' ,
                                    departmentId = '$departmentId' ,
                                    photoPath = '$fileName'
                                    WHERE id='$id'";
    $result = mysqli_query($link, $query);
    $link->close();
}
?>