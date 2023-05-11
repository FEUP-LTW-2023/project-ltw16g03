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

  function getUserna($id) {
    global $dbh;
    try {
      $stmt = $dbh->prepare('SELECT username FROM User WHERE id = ?');
      $stmt->execute(array($id));
      if($row = $stmt->fetch()){
        return $row['username'];
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

  function isAgent($id) {
    global $dbh;
    try {
      $stmt = $dbh->prepare('SELECT is_agent FROM User WHERE id = ?');
      $stmt->execute(array($id));
      $result = $stmt->fetch();
      if ($result !== false && $result['is_agent'] == true) {
        return true;
      } else {
        return false;
      }
    } catch(PDOException $e) {
      return false;
    }
  }
  
  function isAdmin($id) {
    global $dbh;
    try {
      $stmt = $dbh->prepare('SELECT is_admin FROM User WHERE id = ?');
      $stmt->execute(array($id));
      $result = $stmt->fetch();
      if ($result !== false && $result['is_admin'] == true) {
        return true;
      } else {
        return false;
      }
    } catch(PDOException $e) {
      return false;
    }
  }

  function getAll(PDO $db){
    $stmt = $db->prepare('
      SELECT id, username
      FROM User 
      ORDER by username
    ');

    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $row;
  }

  function getUserAdmin(int $id) {
    global $dbh;
  try {
    $stmt = $dbh->prepare('SELECT id, username, firstName, lastName, email, id_department, is_agent, is_admin FROM User WHERE id = ?');
    $stmt->execute(array($id));
    return $stmt->fetch();
  
  }catch(PDOException $e) {
    return null;
  }
  }  
  function updateUserInfoAdmin($id, $id_department, $is_agent, $is_admin){
    global $dbh;

    try {
      $stmt = $dbh->prepare('UPDATE User SET id_department = ?, is_agent = ?, is_admin = ? WHERE id = ?');
      if($stmt->execute(array($id_department, $is_agent, $is_admin, $id)))
          return true;
      else{
        return false;
      }   
    }catch(PDOException $e) {
      return false;
    }
  }
