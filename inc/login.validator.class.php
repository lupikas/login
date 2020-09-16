<?php

class LoginValidator extends Connection{

  //priskiriame formos laukus kintamajam
  private $data;
  //sukuriame tuščią masyvą klaidų pranešimams
  private $errors = [];
  //sukuriame privalomų laukų masyvą
  private static $fields = ['email', 'password'];

  //priskiriame duomenis, kuriuos gausime iš formos
  public function __construct($post_data){
    $this->data = $post_data;
  }

  //patikriname ar visi laukai priklauso formai
  public function validateForm(){

    foreach(self::$fields as $field){
      if(!array_key_exists($field, $this->data)){
        trigger_error("'$field' nepriklauso formai");
        return;
      }
    }

    //jeigu su laukais viskas tvarkoje pradedame tikrinti laukus
    $this->validateEmail();
    $this->validatePassword();
    return $this->errors;

  }

  //patikriname el. paštą
  private function validateEmail(){

    //priskiriame reikšmes
    $val = trim($this->data['email']);
    //tikriname ar įrašytas el. paštas
    if(empty($val)){
      $this->addError('email', 'Įveskite el. paštą!');
    } else {
      //tikriname ar įvestas teisingas el, pašto adresas
      if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
        $this->addError('email', 'Įveskite teisingą el. paštą!');
      } else{
          //nuskaitome DB ir patikriname ar toks el. paštas yra
          $sql = 'SELECT count(*) FROM users WHERE email = ?';
          $stmt = $this->connect()->prepare($sql);
          $stmt->execute([$val]);
          $count = $stmt->fetchColumn();
            if($count != 1){
              $this->addError('email', 'Tokio el. pašto nėra!');
            }
        }
      }
  }

  //patikriname slaptažodį
  private function validatePassword(){

    //priskiriame reikšmes
    $val = trim($this->data['password']);
    $email = trim($this->data['email']);
    //tikriname ar įrašytas slaptažodis
    if(empty($val)){
      $this->addError('password', 'Įveskite slaptažodį!');
    } else{
      //patikriname ar sutampa slaptažodžiai
      $sql = 'SELECT * FROM users WHERE email = ?';
      $stmt = $this->connect()->prepare($sql);
      $stmt->execute([$email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if($user && !password_verify($val, $user['password'])){
        $this->addError('password', 'Netinkamas slaptažodis!');
      }
    }
  }

  //priskiriame klaidų pranešimus
  private function addError($key, $val){
    $this->errors[$key] = $val;
  }

}

?>
