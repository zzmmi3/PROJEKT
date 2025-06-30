<?php
include_once 'baza_povezava.php';
include_once 'seja.php';

$uspesno_sporocilo = '';
$vsebina_tekst = '';  // tukaj shranjujemo vrednost textarea

// Dodajanje obvestila
if (isset($_POST['dodaj'])) {
    $vsebina = mysqli_real_escape_string($conn, trim($_POST['vsebina']));

    if (!empty($vsebina)) {
        $datum = date('Y-m-d');
        $query = "INSERT INTO obvestila (vsebina, dat_objave) VALUES ('$vsebina', '$datum')";
        if (mysqli_query($conn, $query)) {
            $uspesno_sporocilo = "Obvestilo je bilo uspešno shranjeno.";
            $vsebina_tekst = ''; // po uspešnem shranjevanju počistimo textarea
        } else {
            $uspesno_sporocilo = "Napaka pri shranjevanju obvestila: " . mysqli_error($conn);
            $vsebina_tekst = $_POST['vsebina']; // če ni uspelo, ostane tekst v textarea
        }
    } else {
        $vsebina_tekst = $_POST['vsebina']; // če je prazno, ostane tekst (verjetno prazen)
    }
} else {
    $vsebina_tekst = ''; // ko se stran prvič naloži, je prazno
}

// Brisanje obvestila
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $query = "DELETE FROM obvestila WHERE id_obvestila = $id";
    mysqli_query($conn, $query);
}

// Naloži vse obvestila, da so prikazana na strani
$query = "SELECT * FROM obvestila ORDER BY dat_objave DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8" />
    <title>Uredi obvestila</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="obvestila.css" />
</head>
<body>


<br><br>

<?php if ($uspesno_sporocilo): ?>
    <p style="color:green; font-weight:bold;"><?php echo htmlspecialchars($uspesno_sporocilo); ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label for="vsebina">Vnesi obvestilo:</label><br>
    <textarea id="vsebina" name="vsebina" rows="4" cols="50" placeholder="Vnesi obvestilo..." required><?php echo htmlspecialchars($vsebina_tekst); ?></textarea><br><br>
    <button type="submit" name="dodaj">Shrani obvestilo</button>
</form>

<hr>
<br>
<h2>SEZNAM OBVESTIL</h2>

<?php
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p><strong>" . htmlspecialchars($row['dat_objave']) . "</strong><br>";
        echo nl2br(htmlspecialchars($row['vsebina'])) . "<br>";
        echo "<a href='?delete_id=" . (int)$row['id_obvestila'] . "' onclick=\"return confirm('Ali ste prepričani, da želite izbrisati to obvestilo?');\">Izbriši</a></p><hr>";
    }
} else {
    echo "<p>Ni obvestil.</p>";
}
?>

<br>
<a href="admin.php">NAZAJ</a>
</body>
</html>
