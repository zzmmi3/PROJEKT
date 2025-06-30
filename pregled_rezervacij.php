<?php
require_once 'baza_povezava.php';

// Obdelava oddanih obrazcev
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Posodobitev rezervacije
    if (isset($_POST['posodobi'])) {
        $idRezervacije = (int)$_POST['id_rezervacija'];
        $statusKoncano = isset($_POST['status']) ? 1 : 0;
        $statusPlacano = isset($_POST['placano']) ? 1 : 0;
        $idVozilo = $_POST['id_vozilo'] !== '' ? (int)$_POST['id_vozilo'] : "NULL";
        $idVoznik = $_POST['id_voznik'] !== '' ? (int)$_POST['id_voznik'] : "NULL";

        mysqli_query($conn, "UPDATE rezervacija SET status = $statusKoncano WHERE id_rezervacija = $idRezervacije");

        mysqli_query($conn, "UPDATE placila 
            INNER JOIN rezervacija ON placila.id_placila = rezervacija.id_placila 
            SET placila.status = $statusPlacano 
            WHERE rezervacija.id_rezervacija = $idRezervacije");

        mysqli_query($conn, "UPDATE prevoz 
            INNER JOIN rezervacija ON prevoz.id_prevoz = rezervacija.id_prevoz 
            SET prevoz.id_vozila = $idVozilo, prevoz.id_voznik = $idVoznik 
            WHERE rezervacija.id_rezervacija = $idRezervacije");

        if ($statusKoncano && $statusPlacano) {
            mysqli_query($conn, "DELETE prevoz FROM prevoz 
                INNER JOIN rezervacija ON prevoz.id_prevoz = rezervacija.id_prevoz 
                WHERE rezervacija.id_rezervacija = $idRezervacije");
        }
    }

    // Posodobitev plačila
    if (isset($_POST['shrani_placilo'])) {
        $idPlacila = (int)$_POST['id_placila'];
        $nacinPlacila = mysqli_real_escape_string($conn, $_POST['nacin_placila']);
        $znesek = (float)$_POST['znesek'];
        $datumPlacila = $_POST['datum_placila'];
        $statusPlacila = isset($_POST['status']) ? 1 : 0;

        mysqli_query($conn, "UPDATE placila 
            SET nacin_placila = '$nacinPlacila', 
                znesek = $znesek, 
                datum_placila = '$datumPlacila', 
                status = $statusPlacila 
            WHERE id_placila = $idPlacila");
    }

    // Brisanje prevoza
    if (isset($_POST['izbrisi_prevoz'])) {
        $idRezervacije = (int)$_POST['id_rezervacija'];
        mysqli_query($conn, "DELETE prevoz FROM prevoz 
            INNER JOIN rezervacija ON prevoz.id_prevoz = rezervacija.id_prevoz 
            WHERE rezervacija.id_rezervacija = $idRezervacije");
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Pridobitev vseh rezervacij
$rezervacijeQuery = "SELECT r.id_rezervacija, r.status AS rez_status, r.datum,
                           u.ime, u.priimek,
                           p.zacetek, p.cilj, p.datum AS datum_prevoza, p.ura,
                           pla.status AS plac_status, pla.znesek,
                           p.id_prevoz, p.id_voznik, p.id_vozila
                    FROM rezervacija r
                    LEFT JOIN uporabnik u ON r.id_uporabnik = u.id_uporabnik
                    LEFT JOIN prevoz p ON r.id_prevoz = p.id_prevoz
                    LEFT JOIN placila pla ON r.id_placila = pla.id_placila
                    ORDER BY r.datum DESC";
$rezervacije = mysqli_query($conn, $rezervacijeQuery);
if (!$rezervacije) {
    die("Napaka pri poizvedbi rezervacij: " . mysqli_error($conn));
}

// Pridobitev vozil
$vozila = [];
$vozilaResult = mysqli_query($conn, "SELECT * FROM vozila");
if (!$vozilaResult) {
    die("Napaka pri poizvedbi vozil: " . mysqli_error($conn));
}
while ($v = mysqli_fetch_assoc($vozilaResult)) {
    $vozila[$v['id_vozila']] = $v['znamka'] . ' ' . $v['model'] . ' (' . $v['registracija'] . ')';
}

// Pridobitev voznikov
$vozniki = [];
$voznikiResult = mysqli_query($conn, "SELECT * FROM voznik");
if (!$voznikiResult) {
    die("Napaka pri poizvedbi voznikov: " . mysqli_error($conn));
}
while ($v = mysqli_fetch_assoc($voznikiResult)) {
    $vozniki[$v['id_voznik']] = $v['ime'] . ' ' . $v['priimek'];
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8" />
    <title>Uredi podjetje</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="admin_rezervacija.css" />
</head>
<body>

<h2>Seznam rezervacij</h2>
<table border="1">
    <tr>
        <th>ID</th><th>Uporabnik</th><th>Začetek</th><th>Cilj</th><th>Datum prevoza</th><th>Ura</th>
        <th>Voznik</th><th>Vozilo</th><th>Končano</th><th>Plačano</th><th>Shrani</th><th>Izbriši</th>
    </tr>
    <?php while ($rez = mysqli_fetch_assoc($rezervacije)): ?>
        <tr>
            <form method="POST">
                <td><?= $rez['id_rezervacija'] ?></td>
                <td><?= htmlspecialchars($rez['ime'] . ' ' . $rez['priimek']) ?></td>
                <td><?= htmlspecialchars($rez['zacetek']) ?></td>
                <td><?= htmlspecialchars($rez['cilj']) ?></td>
                <td><?= $rez['datum_prevoza'] ?></td>
                <td><?= $rez['ura'] ?></td>
                <td>
                    <select name="id_voznik">
                        <option value="">-- Izberi --</option>
                        <?php foreach ($vozniki as $id => $ime): ?>
                            <option value="<?= $id ?>" <?= ($rez['id_voznik'] == $id ? 'selected' : '') ?>><?= $ime ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select name="id_vozilo">
                        <option value="">-- Izberi --</option>
                        <?php foreach ($vozila as $id => $voz): ?>
                            <option value="<?= $id ?>" <?= ($rez['id_vozila'] == $id ? 'selected' : '') ?>><?= $voz ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="checkbox" name="status" <?= $rez['rez_status'] ? 'checked' : '' ?>></td>
                <td><input type="checkbox" name="placano" <?= $rez['plac_status'] ? 'checked' : '' ?>></td>
                <td>
                    <input type="hidden" name="id_rezervacija" value="<?= $rez['id_rezervacija'] ?>">
                    <button type="submit" name="posodobi">Shrani</button>
                </td>
            </form>
            <td>
                <form method="POST" action="brisanje_rezervacij.php">
                  <input type="hidden" name="id_rezervacija" value="<?= $rez['id_rezervacija'] ?>">
                   <button type="submit" name="izbrisi_prevoz">Izbriši</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Seznam plačil</h2>
<table border="1">
    <tr>
        <th>ID Rezervacije</th><th>Način</th><th>Znesek</th><th>Datum</th><th>Status</th><th>Shrani</th>
    </tr>
    <?php
    $placilaQuery = "SELECT r.id_rezervacija, pla.id_placila, pla.nacin_placila, pla.znesek, pla.dat_placila, pla.status
                     FROM rezervacija r
                     LEFT JOIN placila pla ON r.id_placila = pla.id_placila
                     ORDER BY r.datum DESC";
    $placilaResult = mysqli_query($conn, $placilaQuery);
    if (!$placilaResult) {
        die("Napaka pri poizvedbi plačil: " . mysqli_error($conn));
    }
    ?>
    <?php while ($pla = mysqli_fetch_assoc($placilaResult)): ?>
        <tr>
            <form method="POST">
                <td><?= $pla['id_rezervacija'] ?></td>
                <td><input type="text" name="nacin_placila" value="<?= htmlspecialchars($pla['nacin_placila']) ?>"></td>
                <td><input type="number" step="0.01" name="znesek" value="<?= $pla['znesek'] ?>"></td>
                <td><input type="date" name="dat_placila" value="<?= $pla['dat_placila'] ?>"></td>
                <td><input type="checkbox" name="status" <?= $pla['status'] ? 'checked' : '' ?>></td>
                <td>
                    <input type="hidden" name="id_placila" value="<?= $pla['id_placila'] ?>">
                    <button type="submit" name="shrani_placilo">Shrani</button>
                </td>
            </form>
        </tr>
    <?php endwhile; ?>
</table>
<button><a href="admin.php">NAZAJ</a></button>
</body>
</html>
