<?php
require_once 'baza_povezava.php'; 

$sporocilo = '';


if (isset($_POST['dodaj'])) {
    $storitev = mysqli_real_escape_string($conn, trim($_POST['storitev']));
    $opis = mysqli_real_escape_string($conn, trim($_POST['opis']));
    $cena = mysqli_real_escape_string($conn, trim($_POST['cena']));

    if ($storitev && $opis && $cena) {
        $sql = "INSERT INTO cenik (storitev, opis, cena) VALUES ('$storitev', '$opis', '$cena')";
        if (mysqli_query($conn, $sql)) {
            $sporocilo = "Storitev je bila uspešno dodana.";
        } else {
            $sporocilo = "Napaka pri dodajanju storitve: " . mysqli_error($conn);
        }
    } else {
        $sporocilo = "Prosimo, izpolnite vsa polja.";
    }
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8" />
    <title>cenik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="cenik.css" />
</head>
<body>

<header class="glavni">
  <div class="title">UREJANJE STORITEV</div>
  <nav class="buttons">
   
  </nav>
</header>

<section class="sekcija cenik">

<?php if ($sporocilo): ?>
    <p><?= htmlspecialchars($sporocilo) ?></p>
<?php endif; ?>


<form method="POST">
  <label>
    Storitev:<br>
    <input type="text" name="storitev" required>
  </label><br><br>
  <label>
    Opis:<br>
    <textarea name="opis" rows="3" cols="40" required></textarea>
  </label><br><br>
  <label>
    Cena:<br>
    <input type="text" name="cena" required>
  </label><br><br>
  <button type="submit" name="dodaj">Shrani Cenik</button>
</form>

</section>
<a href="admin.php">NAZAJ</a>
</body>
</html>
