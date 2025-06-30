<?php
include_once 'baza_povezava.php';
include_once 'seja.php';

$napaka = '';
$uspesno = false;

if (isset($_POST['shrani'])) {
    $ime_podjetja = mysqli_real_escape_string($conn, trim($_POST['ime_podjetja']));
    $naslov = mysqli_real_escape_string($conn, trim($_POST['naslov']));
    $telefon = mysqli_real_escape_string($conn, trim($_POST['telefon']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $davcna_stevilka = mysqli_real_escape_string($conn, trim($_POST['davcna_stevilka']));
    $maticna_stevilka = mysqli_real_escape_string($conn, trim($_POST['maticna_stevilka']));
    $odgovorna_oseba = mysqli_real_escape_string($conn, trim($_POST['odgovorna_oseba']));

    if ($ime_podjetja && $naslov && $telefon && $email && $davcna_stevilka && $maticna_stevilka && $odgovorna_oseba) {
        $sql_update = "UPDATE podjetje SET 
            ime = '$ime_podjetja',
            naslov = '$naslov',
            telefon = '$telefon',
            email = '$email',
            davcna_stevilka = '$davcna_stevilka',
            maticna_stevilka = '$maticna_stevilka',
            odgovorna_oseba = '$odgovorna_oseba'
            LIMIT 1";

        if (mysqli_query($conn, $sql_update)) {
            $uspesno = true;
        } else {
            $napaka = "Napaka pri shranjevanju: " . mysqli_error($conn);
        }
    } else {
        $napaka = "Prosim, izpolnite vsa polja.";
    }
}

$sql_podjetje = "SELECT * FROM podjetje LIMIT 1";
$result_podjetje = mysqli_query($conn, $sql_podjetje);
$podjetje = mysqli_fetch_assoc($result_podjetje);
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8" />
    <title>Uredi podjetje</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="opodjetju.css" />
</head>
<body>

<br><br>

<?php if ($napaka): ?>
    <p style="color: red;"><?php echo htmlspecialchars($napaka); ?></p>
<?php endif; ?>
<h1>UREDI PODATKE O PODJETJU</h1>
<form method="POST" action="">
    <label for="ime_podjetja">Ime podjetja:</label><br />
    <input type="text" id="ime_podjetja" name="ime_podjetja" value="<?php echo htmlspecialchars($podjetje['ime'] ?? ''); ?>" required /><br /><br />

    <label for="naslov">Naslov:</label><br />
    <input type="text" id="naslov" name="naslov" value="<?php echo htmlspecialchars($podjetje['naslov'] ?? ''); ?>" required /><br /><br />

    <label for="telefon">Telefon:</label><br />
    <input type="text" id="telefon" name="telefon" value="<?php echo htmlspecialchars($podjetje['telefon'] ?? ''); ?>" required /><br /><br />

    <label for="email">E-pošta:</label><br />
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($podjetje['email'] ?? ''); ?>" required /><br /><br />

    <label for="davcna_stevilka">Davčna številka:</label><br />
    <input type="text" id="davcna_stevilka" name="davcna_stevilka" value="<?php echo htmlspecialchars($podjetje['davcna_stevilka'] ?? ''); ?>" required /><br /><br />

    <label for="maticna_stevilka">Matična številka:</label><br />
    <input type="text" id="maticna_stevilka" name="maticna_stevilka" value="<?php echo htmlspecialchars($podjetje['maticna_stevilka'] ?? ''); ?>" required /><br /><br />

    <label for="odgovorna_oseba">Odgovorna oseba:</label><br />
    <input type="text" id="odgovorna_oseba" name="odgovorna_oseba" value="<?php echo htmlspecialchars($podjetje['odgovorna_oseba'] ?? ''); ?>" required /><br /><br />

    <button type="submit" name="shrani">
        <?php echo $uspesno ? "Uspešno shranjeno!" : "Shrani spremembe"; ?>
    </button>
</form>
<a href="admin.php">NAZAJ</a>
</body>
</html>
