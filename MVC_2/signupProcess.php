<?php
if (isset($_POST['save'])) {
    try {
        require_once("signupConfig.php");
        $sc = new signupConfig();
        $sc->setFirstName($_POST['firstName']); // Исправил имя метода (CamelCase)
        $sc->setLastName($_POST['lastName']);
        $sc->setAddress($_POST['address']);
        $sc->insertData();

        echo "<script>alert('Data saved successfully'); document.location='allData.php';</script>";
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>