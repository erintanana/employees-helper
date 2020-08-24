<?php

if (isset($_POST['name']) && isset($_POST['surname'])
    && isset($_POST['dateOfBirth']) && isset($_POST['department'])) {

    $name = $_POST['name'];
    $surname = $_POST["surname"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $departmentId = ($_POST["department"] == 0) ? NULL : $_POST["department"];
    $fileName = !empty($_FILES['photo']['name']) ? 'uploads/img/' . $_FILES['photo']['name'] : '';
    $result = array(
        'name' => $_POST["name"],
        'surname' => $_POST["surname"],
        'dateOfBirth' => $_POST["dateOfBirth"],
        'department' => $departmentId,
        'filename' => $fileName
    );
    if (count($_COOKIE["newEmployee"]) == 0 || !isset($_COOKIE["newEmployee"])) {
        setcookie("newEmployee", json_encode($result), time() + 3600 * 24);
    } else {
        setcookie("newEmployee", $_COOKIE["newEmployee"] . ";" . json_encode($result), time() + 3600 * 24);
    }
}

if (isset($_POST['title'])) {
    require 'DB.Config.php';
    $title = $_POST['title'];
    $link->select_db($database) or die ("Невозможно открыть $database");
    $queryInsert = "INSERT INTO department (title) VALUES ('" . $title . "')";
    $result = $link->query($queryInsert);
    $link->close();
    header("Location: departments.php");
}

if (isset($_POST['confirm'])) {
    require 'DB.Config.php';

    $array = explode(';', $_COOKIE["newEmployee"]);
    foreach ($array as &$item) {
        $json = json_decode($item, true);
        $photoPath = empty($json['filename']) ? 'uploads/img/default.png' : $json['filename'];
        $name = $json['name'];
        $surname = $json['surname'];
        $dateOfBirth = $json['dateOfBirth'];
        $departmentId = ($json['department'] == 0) ? NULL : $json['department'];
    }

    $link->select_db($database) or die ("Невозможно открыть $database");
    move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
    if (is_null($departmentId)) {
        $queryInsert = "INSERT INTO person (name, surname, dateOfBirth, departmentId, photoPath)
                VALUES ('" . $name . "', '" . $surname . "',
                '" . date('Y-m-d', strtotime($dateOfBirth)) . "', NULL, '" . $photoPath . "')";
    } else
        $queryInsert = "INSERT INTO person (name, surname, dateOfBirth, departmentId, photoPath)
                VALUES ('" . $name . "', '" . $surname . "',
                '" . date('Y-m-d', strtotime($dateOfBirth)) . "', $departmentId, '" . $photoPath . "')";
    $result = $link->query($queryInsert);
    setcookie("newEmployee", "", time() - 3600 * 64);
    header("Location: employees.php");
    $link->close();
}

?>