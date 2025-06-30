<?php
require_once 'baza_povezava.php';

$sql = "
SELECT 
    o.id_ocena,
    o.ocena,
    o.komentar,
    o.dat_ocene,
    u.ime AS uporabnik_ime
FROM 
    ocene_voznika o
LEFT JOIN 
    uporabnik u ON o.id_uporabnik = u.id_uporabnik
ORDER BY 
    o.id_ocena DESC
";

$rezultat = mysqli_query($conn, $sql);


if (!$rezultat) {
    die("Napaka pri poizvedbi: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8" />
    <title>Pregled ocen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="ocena.css" />
</head>
<body>


  <h2>Pregled ocen uporabnikov</h2>

  <?php if (mysqli_num_rows($rezultat) > 0): ?>
    <table border="1" cellpadding="5" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Uporabnik</th>
          <th>Ocena</th>
          <th>Komentar</th>
          <th>Datum</th>
          <th>Dejanje</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($vrstica = mysqli_fetch_assoc($rezultat)) : ?>
        <tr>
          <td><?= $vrstica['id_ocena'] ?></td>
          <td><?= htmlspecialchars($vrstica['uporabnik_ime'] ?? '—') ?></td>
          <td><?= htmlspecialchars($vrstica['ocena']) ?></td>
          <td><?= nl2br(htmlspecialchars($vrstica['komentar'])) ?></td>
          <td><?= htmlspecialchars($vrstica['dat_ocene']) ?></td>
          <td>
            <form action="brisanje_ocen.php" method="POST">
              <input type="hidden" name="id_ocena" value="<?= $vrstica['id_ocena'] ?>">
              <button type="submit">Izbriši</button>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Ni najdenih ocen.</p>
  <?php endif; ?>

  <p><a href="admin.php">Nazaj</a></p>

</body>
</html>
