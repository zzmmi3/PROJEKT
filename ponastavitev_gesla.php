<?php
include_once 'baza_povezava.php';

$uspeh = "";
$napaka = "";

if (isset($_POST['reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $novo_geslo = mysqli_real_escape_string($conn, $_POST['novo_geslo']);

    if (!empty($email) && !empty($novo_geslo)) {
        $hash_geslo = sha1($novo_geslo);

        $query = "UPDATE Uporabnik SET geslo = '$hash_geslo' WHERE email = '$email'";
        $rezultat = mysqli_query($conn, $query);

        if ($rezultat && mysqli_affected_rows($conn) > 0) {
            $uspeh = "Geslo je bilo uspešno posodobljeno.";
        } else {
            $napaka = "Uporabnik s tem email naslovom ne obstaja.";
        }
    } else {
        $napaka = "Izpolni vsa polja.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Uredi podjetje</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="ponastavitev.css" />
</head>
<body>
<h2>Ponastavi geslo</h2>

<?php
if (!empty($uspeh)) {
    echo "<p style='color:green;'>$uspeh</p>";
}
if (!empty($napaka)) {
    echo "<p style='color:red;'>$napaka</p>";
}
?>

<form method="POST" action="">
    <label for="email">Email naslov:</label><br>
    <input type="email" name="email" required><br><br>

    <label for="novo_geslo">Novo geslo:</label><br>
    <input type="password" name="novo_geslo" required><br><br>

    <input type="submit" name="reset" value="Ponastavi geslo">
</form>

<br>
<a href="index.php">Nazaj na glavno stran</a>
</body>
</html>
