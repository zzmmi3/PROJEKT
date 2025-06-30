<?php
require_once 'baza_povezava.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_ocena']))  
{
    $id_ocena = intval($_POST['id_ocena']);

    $sql = "DELETE FROM ocene_voznika WHERE id_ocena = $id_ocena";

    if (mysqli_query($conn, $sql)) 
    {
        header("Location: ocena_voznika.php");
        exit;
    } 

    else 
    {
        echo "Napaka pri brisanju: " . mysqli_error($conn);
    }
}
else
{
    echo "Neveljavna zahteva.";
}

?>