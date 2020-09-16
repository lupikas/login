<?php
//pradedame naują sesiją
session_start();
error_reporting(0);
//jei vartotojas prisijungęs nukreipiame į jo puslapį
if($_SESSION["loggedin"] === true){
    header("location: logged.php");
}

//įterpiame visus reikalingus failus
require('inc/connection.class.php');
require('inc/login.validator.class.php');
require('inc/post.class.php');

//klaidų pranešimų masyvą nustatome į tuščią
$errors = [];

//tikriname ar paspaustas mygtukas
if(isset($_POST['submit'])){
  // tikriname laukus
  $validation = new LoginValidator($_POST);
  $errors = $validation->validateForm();

  //jei klaidų nėra prijungiame vartotoją
  if(empty($errors)){
    $login = new Post($_POST);
    $login ->login();
  }
}
//laukams priskiriame tuščias reikšmes
$email = $password = '';
//išeksportuojame visus formos laukus
extract($_POST);

//įterpiame header failą
include('inc/header.php');

//jei klaidų nėra nerodome nieko
if(empty($errors)){
  echo "";
} else {
  //jei klaidų yra, rodome pranešimus

?>

<div class="container">
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <p><?php echo $errors['email'] ?? ''; ?></p>
    <p><?php  echo $errors['password'] ?? ''; ?></p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</div>

<?php }

//patikriname ar gautas pranešimas iš registracijos puslapio
if(ISSET($_GET['register'])){

  //priskiriame reikšmę
  $message = $_GET['register'];

    //tikriname ar reikšme tokia kokia turi būti
    if($message == 'ok'){
      //sukuriame pranešimą ir jį parodome
    $msg = "Registracija sėkminga. Dabar galite prisijungti!";
    }

?>

<div class="container">
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <?php echo $msg; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
</div>

<?php } ?>

<!-- prisijungimo forma -->
<div class="container col-md wrapper w-50 p-3">
    <div class="card text-center">
      <div class="card-header">
        <h2>Prisijunkite</h2>
      </div>
        <div class="card-body">
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="form-group">
              <label for="email" class="font-weight-bold">El. pašto adresas</label>
              <input type="text" class="form-control text-center" id="email" name="email" autocomplete="off" value="<?php echo $email; ?>" >
            </div>
            <div class="form-group">
              <label for="password" class="font-weight-bold">Slaptažodis</label>
              <input type="password" class="form-control text-center" id="password" name="password" autocomplete="off" value="<?php echo $password; ?>">
            </div>
            <button type="submit" value="submit" name="submit" class="btn btn-primary">Prisijungti</button>
          </form>
            <br>
            <div class="text-muted">
              Dar neužsiregistravęs? <a href="register.php">Registruokis</a>.
            </div>
    </div>
  </div>
</div>

<?php include('inc/footer.php'); ?>
