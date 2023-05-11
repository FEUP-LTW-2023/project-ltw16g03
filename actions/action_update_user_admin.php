<?php
    include_once("../database/user.class.php");

    $id_department = $_POST['userinfo']['id_department'];
    $is_agent = $_POST['userinfo']['is_agent'];
    $is_admin = $_POST['userinfo']['is_admin'];

    
    if($firstName !== null && $lastName !== null && $username !== null && $email!==null) {

        if(updateUserInfoAdmin (['userinfo']['id'], $id_department, $is_agent, $is_admin)){
            $_SESSION['userinfo'] = getUserAdmin(intval($_GET['id']));

        } else $_SESSION['ERROR'] = "Error: updating data base";      

    } else $_SESSION['ERROR'] = "Error: name, username, email and password cannot be null";



    header("Location:".$_SERVER['HTTP_REFERER']."");
        
?>