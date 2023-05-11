<?php
    include_once("../database/user.class.php");

    $_SESSION['userinfo'] = getUserAdmin(intval($_GET['id']));

    $firstName = $_POST['userinfo']['firstName'];
    $lastName = $_POST['userinfo']['lastName'];
    $username= $_POST['userinfo']['username'];
    $email = $_POST['userinfo']['email'];
    $id_department = $_POST['userinfo']['id_department'];
    $is_agent = $_POST['userinfo']['is_agent'];
    $is_admin = $_POST['userinfo']['is_admin'];

    
    if($firstName !== null && $lastName !== null && $username !== null && $email!==null) {

        if(updateUserInfo (getUserID(), $firstName, $lastName, $username, $email)){
            setCurrentUser(getUserID(), $username);
            $_SESSION['userinfo'] = getUser($_SESSION['username']);

            if($newpassword != null){
                if(!updateUserPassword(getUserID(), $newpassword))
                    $_SESSION['ERROR']= "Error: updating password";                    
            }

        } else $_SESSION['ERROR'] = "Error: updating data base";      

    } else $_SESSION['ERROR'] = "Error: name, username, email and password cannot be null";



    header("Location:".$_SERVER['HTTP_REFERER']."");
        
?>