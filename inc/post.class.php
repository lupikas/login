<?php

class Post extends Connection{

  //priskiriame formos laukus kintamajam
  private $data;
  //sukuriame privalomų laukų masyvą
  private static $fields = ['email', 'name', 'lastName', 'phone', 'password', 'passwordAgain'];

    //priskiriame duomenis, kuriuos gausime iš formos
  public function __construct($post_data){
    $this->data = $post_data;
  }

  //sukuriame registracijos funkciją
  public function register(){

    //priskiriame reikšmes
    $email = trim($this->data['email']);
    $name = trim($this->data['name']);
    $lastName = trim($this->data['lastName']);
    $phone = trim($this->data['phone']);
    $password = trim($this->data['password']);
    $password_h = password_hash($password, PASSWORD_DEFAULT);
    $registeredAt = time();

    //įrašome duomenis į DB
    $sql = "INSERT INTO users (email, name, last_name, phone, password, registered_at) VALUES (?,?,?,?,?,?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$email, $name, $lastName, $phone, $password_h, $registeredAt]);

    //nukreipiame į prisijungimo puslapį su žinute, kad registracija sėkminga
    header("location: index.php?register=ok");

  }

  //sukuriame prisijungimo funkciją
  public function login(){

    //priskiriame reikšmes
    $email = trim($this->data['email']);

    //nuskaitome duomenų bazę sesijos kintamiesiems
    $sql = 'SELECT * FROM users WHERE email = ?';
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //pradedame naują sesiją
    session_start();
    //priskiriame reikšmes
    $_SESSION["loggedin"] = true;
    $_SESSION["id"] = $user['user_id'];

    //atnaujiname paskutinio prisijungimo informaciją
    $last_login_at = time();
    $sql = "UPDATE users SET last_login_at=? WHERE user_id=?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$last_login_at, $_SESSION["id"]]);

    //nukreipiame į vartotojo puslapį
    header("location: logged.php");

  }



}
