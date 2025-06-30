<?php
require_once 'baza_povezava.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ime = $_POST['ime'] ?? '';
    $ocena = $_POST['ocena'] ?? '';
    $komentar = $_POST['komentar'] ?? '';

    if ($ime !== '' && in_array($ocena, ['1','2','3','4','5'])) {
        $ime = mysqli_real_escape_string($conn, $ime);
        $ocena = mysqli_real_escape_string($conn, $ocena);
        $komentar = mysqli_real_escape_string($conn, $komentar);

        $sql_uporabnik = "INSERT INTO uporabnik (ime) VALUES ('$ime')";

        if (mysqli_query($conn, $sql_uporabnik)) {
            $id_uporabnik = mysqli_insert_id($conn);
            
            $sql_ocena = "INSERT INTO ocene_voznika (ocena, komentar, dat_ocene, id_uporabnik)
                          VALUES ('$ocena', '$komentar', NOW(), '$id_uporabnik')";
            if (mysqli_query($conn, $sql_ocena)) {
                echo "Uspešno poslano.";
                exit;
            }
        }
    }
    echo "Neuspešno.";
}
