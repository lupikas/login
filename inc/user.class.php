<?php

class User extends Connection{

  //gauname vartotojo duomenis pagal jo ID
  public function getUser($id){

    //nuskaitome DB
    $sql = 'SELECT * FROM users WHERE user_id = ?';
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$id]);
    return $stmt;
  }
}
