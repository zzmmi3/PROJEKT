<?php
include_once 'baza_povezava.php';
include_once 'seja.php';

$error = "";
$success = "";

if (isset($_POST['submit'])) {
   
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $geslo = $_POST['geslo'];

    // Preverimo, če gre za admin prijavo (hardkodiran email in geslo)
    if ($email === 'admin@admin.si' && $geslo === '123admin') {
        session_start();
        $_SESSION['name'] = 'Administrator';
        $_SESSION['surname'] = '';
        $_SESSION['idu'] = 0;
        $_SESSION['log'] = true;
        $_SESSION['admin'] = true;

        header("Location: admin.php"); 
        exit;

    } else {
        // Preverimo prijavo za ostale uporabnike iz baze
        $geslo_hash = sha1($geslo);

        $query = "SELECT * FROM Uporabnik WHERE email='$email' AND geslo='$geslo_hash'";
        $result = mysqli_query($conn, $query);

if (!$result) {
    die("Napaka pri poizvedbi: " . mysqli_error($conn));
}


        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            session_start();
            $_SESSION['name'] = $row['ime'];
            $_SESSION['surname'] = $row['priimek'];
            $_SESSION['idu'] = $row['id_uporabnik'];
            $_SESSION['log'] = true;
            $_SESSION['admin'] = false;

             header("Location: index.php");  
            exit;

        } else {
            $error = "Napačen mail ali geslo.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Uredi podjetje</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="prijava.css" />
</head>
<body>
<h1>PRIJAVA</h1>

<?php 
if (!empty($error)) {
    echo "<p style='color:red;'>$error</p>";
} elseif (!empty($success)) {
    echo "<p style='color:green;'>$success</p>";
}
?>

<form method="post" action="">
    <input type="email" id="email" name="email" placeholder="Email" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+">
    <input type="password" name="geslo" placeholder="Geslo" required><br><br>
    <input type="submit" name="submit" value="PRIJAVA">
</form>
<br><br>

<br>
<button><a href="index.php">NAZAJ</a></button>
<br><br>
<a href="ponastavitev_gesla.php" style="color:blue; text-decoration:underline;">Pozabil sem geslo?</a>
<br><br>
<a href="registracija.php" style="color:blue; text-decoration:underline;">Registriraj se</a>
</body>
</html>
