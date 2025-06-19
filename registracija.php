<?php
include_once 'baza_povezava.php';

$error = "";
$success = "";

if (isset($_POST['registracija'])) {
    $ime = $_POST['ime'];
    $priimek = $_POST['priimek'];
    $email = $_POST['email'];        
    $geslo = $_POST['geslo'];
    $geslo_hash = sha1($geslo);
    $telefon = $_POST['telefon'];
    $datum_reg = date('Y-m-d H:i:s');

    // Preveri, če e-mail že obstaja
    $check_query = "SELECT * FROM Uporabnik WHERE `email`='$email'";
$check = mysqli_query($link, $check_query);

if (!$check) {
    die("Napaka pri preverjanju e-maila: " . mysqli_error($link));
}

if (mysqli_num_rows($check) > 0) {
        $error = "Uporabnik s tem e-mailom že obstaja.";
    } 
    
    else {
        $insert = "INSERT INTO Uporabnik (ime, priimek, `email`, geslo, telefon, datum_reg) 
                   VALUES ('$ime', '$priimek', '$email', '$geslo_hash', '$telefon', '$datum_reg')";

        if (mysqli_query($link, $insert)) {
            $success = "Registracija uspešna. Sedaj se lahko prijavite.";
        } else {
            $error = "Napaka pri registraciji: " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
</head>
<body>
<h1>Registracija uporabnika</h1>

<?php 
if (!empty($error)) echo "<p style='color:red;'>$error</p>"; 
if (!empty($success)) echo "<p style='color:green;'>$success</p>"; 
?>

<form method="post" action="#">
    <input type="text" name="ime" placeholder="Ime" required><br><br>
    <input type="text" name="priimek" placeholder="Priimek" required><br><br>
    <input type="email" name="email" placeholder="E-mail" required><br><br>
    <input type="password" name="geslo" placeholder="Geslo" required><br><br>
    <input type="text" name="telefon" placeholder="Telefon"><br><br><br>
    <input type="submit" name="registracija" value="PRIJAVA"><br>
    <br>
    <button><a href="prijava_uporabnikov.php">NAZAJ NA PRIJAVO</a></button>
</form>

</body>
</html>
