<?php
require_once("signupConfig.php");

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];

    $data = new signupConfig();
    $data->update($id, $firstName, $lastName, $address);

    echo "<script>alert('Data updated successfully!'); window.location.href='allData.php';</script>";
}
?>
