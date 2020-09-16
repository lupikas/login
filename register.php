<?php

//pradedame sesiją
session_start();
error_reporting(0);
//jei vartotojas prisijungęs nukreipiame į jo puslapį
if($_SESSION["loggedin"] === true){
    header("location: logged.php");
}

//įkeliame reikalingus failus
require('inc/connection.class.php');
require('inc/register.validator.class.php');
require('inc/post.class.php');

//klaidų pranešimų masyvą nustatome į tuščią
$errors = [];

//tikriname ar paspaustas mygtukas
if(isset($_POST['submit'])){
  // tikriname laukus
  $validation = new RegisterValidator($_POST);
  $errors = $validation->validateForm();

  //jei klaidų nėra registruojame vartotoją
  if(empty($errors)){
    $register = new Post($_POST);
    $register ->register();
  }
}

//laukams priskiriame tuščias reikšmes
$email = $name = $lastName = $phone = $password = $passwordAgain = '';
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
    <p><?php  echo $errors['name'] ?? ''; ?></p>
    <p><?php  echo $errors['lastName'] ?? ''; ?></p>
    <p><?php  echo $errors['phone'] ?? ''; ?></p>
    <p><?php  echo $errors['password'] ?? ''; ?></p>
    <p><?php  echo $errors['passwordAgain'] ?? ''; ?></p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</div>
<?php } ?>

<!-- registracijos forma -->
<div class="container col-md wrapper w-50 p-3">
    <div class="card text-center">
      <div class="card-header">
        <h2>Registruokitės</h2>
      </div>
        <div class="card-body">
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="form-group">
              <label for="email" class="font-weight-bold">El. pašto adresas</label>
              <input type="text" class="form-control text-center" id="email" name="email" autocomplete="off" value="<?php echo $email ?>" >
            </div>
            <div class="form-group">
              <label for="name" class="font-weight-bold">Vardas</label>
              <input type="text" class="form-control text-center" id="name" name="name" autocomplete="off" value="<?php echo $name ?>" >
            </div>
            <div class="form-group">
              <label for="lastName" class="font-weight-bold">Pavardė</label>
              <input type="text" class="form-control text-center" id="lastName" name="lastName" autocomplete="off" value="<?php echo $lastName ?>" >
            </div>
            <div class="form-group">
              <label for="phone" class="font-weight-bold">Telefono Nr.</label>
              <input type="text" class="form-control text-center" id="phone" name="phone" autocomplete="off" placeholder="(Formatas 8xxxxxxxx)" value="<?php echo $phone ?>" >
            </div>
            <div class="form-group">
              <label for="password" class="font-weight-bold">Slaptažodis</label>
              <input type="password" class="form-control text-center" id="password" name="password" autocomplete="off" value="<?php echo $password ?>">
            </div>
            <div class="form-group">
              <label for="passwordAgain" class="font-weight-bold">Pakartokite slaptažodį</label>
              <input type="password" class="form-control text-center" id="passwordAgain" name="passwordAgain" autocomplete="off" value="<?php echo $passwordAgain ?>">
            </div>
            <button type="submit" value="submit" name="submit" class="btn btn-primary">Registruotis</button>
          </form>
            <br>
            <div class="text-muted">
              Jau užsiregistravęs? <a href="index.php">Prisijunk</a>.
            </div>
        </div>
    </div>
</div>

<?php include('inc/footer.php'); ?>
