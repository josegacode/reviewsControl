<!-- Receives the information of a new subject from controller
and register it into db. -->

<?php
    include("connection.php");
    if(isset($_POST) && count($_POST) > 0) {
        $subjectName = $_POST['subjectName'];
        $userId = $_POST['userId'];
        
        $insertNewSubjectQuery = "INSERT INTO subject(name,user) VALUES('$subjectName','$userId')"; 
        $insertNewSubjectResult = $connection->query($insertNewSubjectQuery);
        if($insertNewSubjectResult) include("../view/subjects.php");
        else echo 0;
    } else {}
?>