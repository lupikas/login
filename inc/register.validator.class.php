<?php

class RegisterValidator extends Connection{

  //priskiriame formos laukus kintamajam
  private $data;
  //sukuriame tuščią masyvą klaidų pranešimams
  private $errors = [];
  //sukuriame privalomų laukų masyvą
  private static $fields = ['email', 'name', 'lastName', 'phone', 'password', 'passwordAgain'];

  ////priskiriame duomenis, kuriuos gausime iš formos
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
    $this->validateName();
    $this->validateLastName();
    $this->validatePhone();
    $this->validatePassword();
    $this->validatePasswordAgain();
    return $this->errors;

  }

  //patikriname el. paštą
  private function validateEmail(){

    //priskiriame reikšmes
    $val = trim($this->data['email']);

    //tikriname ar laukas netuščias
    if(empty($val)){
      $this->addError('email', 'Įveskite el. paštą!');
    } else {
      //tikriname ar įvestas teisingas el, pašto adresas
      if(!filter_var($val, FILTER_VALIDATE_EMAIL)){
        $this->addError('email', 'Įveskite teisingą el. paštą!');
      } else{
        //nuskaitome DB ir patikriname ar toks el. paštas yra
        $sql = "SELECT * FROM users WHERE email=?";
          	$stmt = $this->connect()->prepare($sql);
            $stmt->execute([$val]);
      			$email = $stmt->fetch();
            if($email){
              $this->addError('email', 'Toks el. paštas jau užimtas!');
            }
        }
      }
  }

  //patikriname vardą
  private function validateName(){

    //priskiriame reikšmes
    $val = trim($this->data['name']);

    //tikriname ar laukas netuščias
    if(empty($val)){
      $this->addError('name', 'Įveskite vardą!');
    }
  }

  //patikriname pavardę
  private function validateLastName(){

    //priskiriame reikšmes
    $val = trim($this->data['lastName']);

    //tikriname ar laukas netuščias
    if(empty($val)){
      $this->addError('lastName', 'Įveskite pavardę!');
    }
  }

  //patikriname telefono numerį
  private function validatePhone(){

    //priskiriame reikšmes
    $val = trim($this->data['phone']);

    //tikriname ar laukas netuščias
    if(empty($val)){
      $this->addError('phone', 'Įveskite telefono numerį!');
    } else {
      //patikriname ar telefono numerį sudaro tik skaičiai
      if(!is_numeric($val)){
        $this->addError('phone','Telefono numerį gali sudaryti tik skaičiai!');
      }
    }
  }

  //patikriname slaptažodį
  private function validatePassword(){

    //priskiriame reikšmes
    $val = trim($this->data['password']);

    //tikriname ar laukas netuščias
    if(empty($val)){
      $this->addError('password', 'Įveskite slaptažodį!');
    } else {
      //tikriname ar yra didžioji raidė
      if(!preg_match('@[A-Z]@', $val)){
        $this->addError('password','Slaptažodyje turi būti bent viena didžioji raidė!');
      } else{
        //tikriname ar yra skaičius
        if(!preg_match('@[0-9]@', $val)){
          $this->addError('password','Slaptažodyje turi būti bent vienas skaičius!');
        } else{
          //tikriname ar ilgesnis nei 8 simboliai
          if(strlen($val) < 8){
            $this->addError('password','Slaptažodis turi būti ilgesnis nei 8 simboliai!');
          } else {
            //tikriname ar trumpesnis nei 12 simbolių
            if(strlen($val) > 12){
              $this->addError('password','Slaptažodis turi būti trumpesnis nei 12 simbolių!');
            }
          }
        }
      }
    }
  }

  //patikriname slaptažodžio pakartojimą
  private function validatePasswordAgain(){

    //priskiriame reikšmes
    $val = trim($this->data['password']);
    $valAgain = trim($this->data['passwordAgain']);

    //tikriname ar laukas netuščias
    if(empty($valAgain)){
      $this->addError('passwordAgain', 'Pakartokite slaptažodį!');
    } else {
      //patikriname ar slaptažodžiai sutampa
      if($val != $valAgain){
        $this->addError('passwordAgain','Slaptažodžiai nesutampa!');
      }
    }
  }

  //priskiriame klaidų pranešimus
  private function addError($key, $val){
    $this->errors[$key] = $val;
  }
}

?>
