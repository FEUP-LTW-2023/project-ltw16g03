<?php

function isLoginCorrect($username, $password) {
  global $dbh;
  $passwordhashed = hash('sha256', $password);
  try {
    $stmt = $dbh->prepare('SELECT * FROM User WHERE username = ? AND password = ?');
    $stmt->execute(array($username, $passwordhashed));
    if($stmt->fetch() !== false) {
      return getID($username);
    }
    else return -1;

  } catch(PDOException $e) {
    return -1;
  }
}
  function createUser($username, $firstName, $lastName, $email, $password) {
    $passwordhashed = hash('sha256', $password);
    global $dbh;
    try {
  	  $stmt = $dbh->prepare('INSERT INTO User(username, firstName, lastName, email, password) VALUES (:username,:firstName,:lastName,:email,:password)');
  	  $stmt->bindParam(':username', $username);
  	  $stmt->bindParam(':firstName', $firstName);
  	  $stmt->bindParam(':lastName', $lastName);
  	  $stmt->bindParam(':email', $email);
      $stmt->bindParam(':password', $passwordhashed);
      if($stmt->execute()){
        $id = getID($username);
        return $id;
      }
      else
        return -1;
    }catch(PDOException $e) {
      
      return -1;
    }
    
  }


  function getID($username) {
    global $dbh;
    try {
      $stmt = $dbh->prepare('SELECT id FROM User WHERE username = ?');
      $stmt->execute(array($username));
      if($row = $stmt->fetch()){
        return $row['id'];
      }
    
    }catch(PDOException $e) {
      return -1;
    }
  }

  function duplicateUsername($username) {
    global $dbh;
    try {
      $stmt = $dbh->prepare('SELECT id FROM User WHERE username = ?');
      $stmt->execute(array($username));
      return $stmt->fetch()  !== false;
    
    }catch(PDOException $e) {
      return true;
    }
  }

  function duplicateEmail($email) {
    global $dbh;
    try {
      $stmt = $dbh->prepare('SELECT id FROM User WHERE email = ?');
      $stmt->execute(array($email));
      return $stmt->fetch()  !== false;
    
    }catch(PDOException $e) {
      return true;
    }
  }

  function getUser($username) {
    global $dbh;
    try {
      $stmt = $dbh->prepare('SELECT firstName, lastName, username, email, id_department, is_agent, is_admin FROM User WHERE Username = ?');
      $stmt->execute(array($username));
      return $stmt->fetch();
    
    }catch(PDOException $e) {
      return null;
    }
  }

function updateUserInfo($id, $firstName, $lastName, $username, $email){
    global $dbh;

    try {
      $stmt = $dbh->prepare('UPDATE User SET firstName = ?, lastName = ?, username = ?, email = ? WHERE id = ?');
      if($stmt->execute(array($firstName, $lastName, $username, $email, $id)))
          return true;
      else{
        return false;
      }   
    }catch(PDOException $e) {
      return false;
    }
  }

  function updateUserPassword($id, $newpassword){
    $passwordhashed = hash('sha256', $newpassword);
    global $dbh;

    try {
      $stmt = $dbh->prepare('UPDATE User SET password = ? WHERE id = ?');
      if($stmt->execute(array($passwordhashed, $id)))
          return true;
      else{
        return false;
      }   
    }catch(PDOException $e) {
      return false;
    }
  }