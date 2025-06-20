<?php

$email = $_POST['email'];
$geslo = $_POST['geslo'];

// Povezava na bazo
$conn = mysqli_connect("localhost", "root", "", "spet_zevci");

if (!$conn) {
    die("Povezava na bazo ni uspela: " . mysqli_connect_error());
}

// Poišči uporabnika po emailu
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);

    // Preveri geslo
    if (password_verify($geslo, $user['geslo'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        // Preveri, če je admin po emailu
        if ($user['email'] === "admin@primer.si") {
            $_SESSION['is_admin'] = true;
            header("Location: admin_panel.php");
            exit();
        } else {
            $_SESSION['is_admin'] = false;
            header("Location: uporabnik.php");
            exit();
        }
    } else {
        echo "Napačno geslo.";
    }
} else {
    echo "Uporabnik ne obstaja.";
}
?>
