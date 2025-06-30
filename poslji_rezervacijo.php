<?php
require_once 'baza_povezava.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_uporabnik = $_SESSION['idu'] ?? null;
    if (!$id_uporabnik) {
        echo "<p class='error'>Uporabnik ni prijavljen.</p>";
        exit;
    }

    if (!isset($_SESSION['log']) || $_SESSION['log'] !== true) {
        echo "<p class='error'>Dostop zavrnjen. Prijava obvezna.</p>";
        exit;
    }

    $zacetek = $_POST['zacetek'] ?? '';
    $cilj = $_POST['cilj'] ?? '';
    $datum = $_POST['datum'] ?? '';
    $ura = $_POST['ura'] ?? '';
    $opis = $_POST['opis'] ?? '';
    $nacin_placila = $_POST['nacin_placila'] ?? '';

    if (empty($zacetek) || empty($cilj) || empty($datum) || empty($ura) || empty($nacin_placila)) {
        echo "<p class='error'>Prosim, izpolni vsa obvezna polja.</p>";
        exit;
    }

    $zacetek = mysqli_real_escape_string($conn, $zacetek);
    $cilj = mysqli_real_escape_string($conn, $cilj);
    $datum = mysqli_real_escape_string($conn, $datum);
    $ura = mysqli_real_escape_string($conn, $ura);
    $opis = mysqli_real_escape_string($conn, $opis);
    $nacin_placila = mysqli_real_escape_string($conn, $nacin_placila);

    $sql_prevoz = "INSERT INTO prevoz (zacetek, cilj, datum, ura, cena, opis) 
                   VALUES ('$zacetek', '$cilj', '$datum', '$ura', 0.00, '$opis')";
    if (mysqli_query($conn, $sql_prevoz)) {
        $id_prevoz = mysqli_insert_id($conn);

        $sql_placilo = "INSERT INTO placila (znesek, status, dat_placila, nacin_placila) 
                        VALUES (0, 0, NOW(), '$nacin_placila')";
        if (mysqli_query($conn, $sql_placilo)) {
            $id_placila = mysqli_insert_id($conn);

            $sql_rezervacija = "INSERT INTO rezervacija (datum, status, id_uporabnik, id_prevoz, id_placila) 
                               VALUES (NOW(), 0, $id_uporabnik, $id_prevoz, $id_placila)";
            if (mysqli_query($conn, $sql_rezervacija)) {
                // Tukaj sledi HTML izpis
                ?>
                <!DOCTYPE html>
                <html lang="sl">
                <head>
                  <meta charset="UTF-8" />
                  <title>Rezervacija</title>
                   <meta name="viewport" content="width=device-width, initial-scale=1" />
                   <link rel="stylesheet" type="text/css" href="rezervacija.css" />
                </head>
                <body>
                <div class="container">
                    <h2>Rezervacija uspešno shranjena</h2>
                    <table>
                        <tr><th>Začetek</th><td><?= htmlspecialchars($zacetek) ?></td></tr>
                        <tr><th>Cilj</th><td><?= htmlspecialchars($cilj) ?></td></tr>
                        <tr><th>Datum</th><td><?= htmlspecialchars($datum) ?></td></tr>
                        <tr><th>Ura</th><td><?= htmlspecialchars($ura) ?></td></tr>
                        <tr><th>Način plačila</th><td><?= htmlspecialchars($nacin_placila) ?></td></tr>
                        <tr><th>Opis</th><td><?= htmlspecialchars($opis) ?></td></tr>
                    </table>
                </div>
                </body>
                </html>
                <?php
                exit;
            } else {
                echo "<p class='error'>Napaka pri shranjevanju rezervacije: " . mysqli_error($conn) . "</p>";
                exit;
            }
        } else {
            echo "<p class='error'>Napaka pri shranjevanju plačila: " . mysqli_error($conn) . "</p>";
            exit;
        }
    } else {
        echo "<p class='error'>Napaka pri shranjevanju prevoza: " . mysqli_error($conn) . "</p>";
        exit;
    }
}
?>
