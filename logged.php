<?php
//pradedame sesiją
session_start();
//jei vartotojas neprisijungęs, nukreipiame į prisijungimo puslapį
if($_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

//įkeliame reikalingus failus
require('inc/connection.class.php');
require('inc/user.class.php');

//kintamajam $id priskiriame sesijos ID
$id = $_SESSION["id"];
//pagal ID nuskaitome vartotojo duomenis
$users = new User();
$result=$users->getUser($id);
//įkeliame header failą
include('inc/header.php');

?>

<div class="container">
  <div class="text-muted">
  <span class="float-right"><a href="logout.php">Atsijungti</a></span>
  </div>
  <br>
    <div class="card text-center">
      <div class="card-header">
        <h2>Prisijungėte sėkmingai!</h2>
      </div>
        <div class="card-body">
<?php
  //parodome vartotojo duomenis
  foreach ($result as $user) {
?>
  <p>Jūsų vardas: <b><?php echo $user['name']; ?></b></P>
  <p>Jūsų pavardė: <b><?php echo $user['last_name']; ?></b></P>
  <p>Jūsų telefono numeris: <b><?php echo $user['phone']; ?></b></P>
  <p>Jūs užsiregistravote: <b><?php echo date("Y-m-d H:i:s", $user['registered_at']); ?></b></P>
  <p>Paskutinį kartą prisijungėte: <b><?php echo date("Y-m-d H:i:s", $user['last_login_at']); ?></b></P>

<?php } ?>

    </div>
  </div>
</div>

<?php include('inc/footer.php'); ?>
