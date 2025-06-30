<?php
include_once 'baza_povezava.php';

$error = "";

if (isset($_POST['registracija'])) {
    $ime = $_POST['ime'] ?? '';
    $priimek = $_POST['priimek'] ?? '';
    $email = $_POST['email'] ?? '';
    $geslo = $_POST['geslo'] ?? '';
    $telefon = $_POST['telefon'] ?? '';
    $geslo_hash = sha1($geslo);
    $datum_reg = date('Y-m-d');

    $check_query = "SELECT * FROM Uporabnik WHERE `email`='$email'";
    $check = mysqli_query($conn, $check_query);

    if (!$check) {
        die("Napaka pri preverjanju e-maila: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($check) > 0) {
        $error = "Uporabnik s tem e-mailom že obstaja.";
    } else {
        $insert = "INSERT INTO Uporabnik (ime, priimek, `email`, geslo, telefon, datum_reg) 
                   VALUES ('$ime', '$priimek', '$email', '$geslo_hash', '$telefon', '$datum_reg')";

        if (mysqli_query($conn, $insert)) {
            header("Location: prijava_uporabnikov.php");
            exit;
        } else {
            $error = "Napaka pri registraciji: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Registracija uporabnika</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="registracija.css" />
</head>
<body>
<h1>Registracija uporabnika</h1>

<?php 
if (!empty($error)) echo "<p style='color:red;'>$error</p>"; 
?>

<form method="post" action="#">
    <input type="text" name="ime" placeholder="Ime" required><br><br>
    <input type="text" name="priimek" placeholder="Priimek" required><br><br>
    <input type="email" name="email" placeholder="E-mail" required><br><br>
    <input type="password" name="geslo" placeholder="Geslo" required><br><br>
    <input type="text" name="telefon" placeholder="Telefon"><br><br><br>
    <input type="submit" name="registracija" value="DODAJ"><br><br>
</form>
<a href="index.php">nazaj</a>
</body>
</html>
