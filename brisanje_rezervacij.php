<?php
require_once 'baza_povezava.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['izbrisi_prevoz'])) {
    $idRezervacije = (int)$_POST['id_rezervacija'];

   
    $queryPrevoz = "DELETE prevoz FROM prevoz 
                    INNER JOIN rezervacija ON prevoz.id_prevoz = rezervacija.id_prevoz 
                    WHERE rezervacija.id_rezervacija = $idRezervacije";
    mysqli_query($conn, $queryPrevoz);


    $queryRezervacija = "DELETE FROM rezervacija WHERE id_rezervacija = $idRezervacije";
    mysqli_query($conn, $queryRezervacija);

  
    header("Location: pregled_rezervacij.php");
    exit;
} 
?>
