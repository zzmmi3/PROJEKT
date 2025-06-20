<?php
include_once 'baza_povezava.php';
include_once 'seja.php';

$error = "";
$success = "";

if (isset($_POST['submit'])) {
   
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $geslo = $_POST['geslo'];

    // Preverimo, če gre za admin prijavo (hardkodiran email in geslo)
    if ($email === 'admin@admin.si' && $geslo === '123admin') {
        session_start();
        $_SESSION['name'] = 'Administrator';
        $_SESSION['surname'] = '';
        $_SESSION['idu'] = 0;
        $_SESSION['log'] = true;
        $_SESSION['admin'] = true;

        header("Location: index.php");
        exit;
        
    } else {
        // Preverimo prijavo za ostale uporabnike iz baze
        $geslo_hash = sha1($geslo);

        $query = "SELECT * FROM Uporabnik WHERE email='$email' AND geslo='$geslo_hash'";
        $result = mysqli_query($link, $query);

        if (!$result) {
            die("Napaka pri poizvedbi: " . mysqli_error($link));
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            session_start();
            $_SESSION['name'] = $row['ime'];
            $_SESSION['surname'] = $row['priimek'];
            $_SESSION['idu'] = $row['id_uporabnik'];
            $_SESSION['log'] = true;
            $_SESSION['admin'] = false;

            $success = "Prijava uspešna. <a href='index.php'>Pojdi na glavno stran</a>";
        } else {
            $error = "Napačen mail ali geslo.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Prijava rezultat</title>
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

<br>
<a href="index.php">DOMOV</a>

</body>
</html>
