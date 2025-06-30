<?php
require_once 'baza_povezava.php';
include_once 'seja.php';

$sql = "SELECT * FROM obvestila ORDER BY dat_objave DESC";
$result = mysqli_query($conn, $sql);

$sql_cenik = "SELECT * FROM cenik ORDER BY id_cenik";
$rezultat_cenik = mysqli_query($conn, $sql_cenik);


$sql_podjetje = "SELECT * FROM podjetje LIMIT 1";
$result_podjetje = mysqli_query($conn, $sql_podjetje);
$podjetje = mysqli_fetch_assoc($result_podjetje);
?>

<!DOCTYPE html>
<html lang="sl">
<head>
  <meta charset="UTF-8">
  <title>Dynamic_OTransp0rt0</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css1.css">
</head>
<body>

<!-- HEADER -->
<header class="glavni">
  <div class="logo">
    <a href="index.php">
      <img src="slike/logo1.jpg" alt="Logo">
    </a>
  </div>
  <div class="title">UREJANJE-ADMIN</div>
  <nav class="buttons">
    <button><a href="#top">DOMOV</a></button> 
    <button><a href="update.php">PPREVOZI</a></button> 
    <button><a href="odjava.php">ODJAVA</a></button>   
  </nav>
</header>

<br><br>

<!-- GUMB DOMOV -->
<div id="top"></div>

<!-- SLIKE -->
<div class="image-container"> 
  <img src="slike/hipibitch.jpg" alt="Slika 1">
  <img src="slike/avtonazem.jpg" alt="Image 2">
  <img src="slike/zemslika.jpg" alt="Image 3">
  <img src="slike/DOT.jpg" alt="Image 4">
  <img src="slike/zenanazem.jpg" alt="Image 5">
  <img src="slike/sonzah.jpg" alt="Image 6">
  <img src="slike/hipibitch.jpg" alt="Image 7">
</div> 

<!-- CENIK -->
<?php
// Pridobi podatke cenika iz baze
$sql_cenik = "SELECT * FROM cenik ORDER BY id_cenik";
$rezultat_cenik = mysqli_query($conn, $sql_cenik);
?>

<section id="cenik" class="sekcija cenik">
  <a href="uredi_cenik.php">Uredi</a>
  <h2>CENIK PREVOZOV</h2>
  <table border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>Storitev</th>
        <th>Opis</th>
        <th>Cena na Km</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($rezultat_cenik && mysqli_num_rows($rezultat_cenik) > 0) {
          while ($vrstica = mysqli_fetch_assoc($rezultat_cenik)) {
              echo '<tr>';
              echo '<td>' . htmlspecialchars($vrstica['storitev']) . '</td>';
              echo '<td>' . htmlspecialchars($vrstica['opis']) . '</td>';
              echo '<td>' . htmlspecialchars($vrstica['cena']) . '</td>';
              echo '</tr>';
          }
      } else {
          echo '<tr><td colspan="3">Trenutno ni podatkov v ceniku.</td></tr>';
      }
      ?>
    </tbody>
  </table>
</section>


<!-- KONTAKT -->
<section id="kontakt" class="sekcija kontakt">
  <a href="pregled_rezervacij.php">Poglej</a>
  <h2>PIŠI IN SE PRIJAVI</h2>
  
       <br>
      
    <label for="zacetek">VAŠI PODATKI:</label>
    
     <br><br>

  <form action="poslji_rezervacijo.php" method="POST">
    
    <label for="ime">Ime:</label>
    <input type="text" id="ime" name="ime" required>

    <label for="priimek">Priimek:</label>
    <input type="text" id="priimek" name="priimek" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+">

    <label for="telefon">Telefonska številka:</label>
    <input type="tel" id="telefon" name="telefon">

       <br>
      
    <label for="zacetek">PODATKI O PREVOZU:</label>
    
     <br>
    <label for="zacetek">Začetna lokacija:</label>
    <input type="text" id="zacetek" name="zacetek" required>

    <label for="cilj">Ciljna lokacija:</label>
    <input type="text" id="cilj" name="cilj" required>

    <label for="datum">Datum prevoza:</label>
    <input type="date" id="datum" name="datum" required>

    <label for="ura">Ura prevoza:</label>
    <input type="time" id="ura" name="ura" required>

    <label for="opis">Opis (neobvezno):</label>
    <textarea id="opis" name="opis" rows="3"></textarea>

    <label for="nacin_placila">Način plačila:</label>
    <select id="nacin_placila" name="nacin_placila" required>
      <option value="">Izberi način plačila</option>
      <option value="gotovina">Gotovina</option>
      <option value="kartica">Kartica</option>
      <option value="paypal">PayPal</option>
      <option value="bančno">Bančno nakazilo</option>
    </select>

    <button type="submit">Rezerviraj</button>
  </form>
</section>

<!-- OBVESTILA -->
<section id="obvestila" class="sekcija obvestila">
  <a href="uredi_obvestila.php">Uredi</a> 
  <h2>OBVESTILA</h2>

  <?php
  if ($result && mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="obvestilo">';
          echo '<h3>' . htmlspecialchars($row['dat_objave']) . '</h3>';
          echo '<p>' . nl2br(htmlspecialchars($row['vsebina'])) . '</p>';
          echo '</div>';
      }
  } else {
      echo '<p>Trenutno ni obvestil.</p>';
  }
  ?>
</section>


<!-- SLIKE 2 -->
<div class="image-container"> 
  <img src="slike/taxi.jpg" alt="Image 1">
  <img src="slike/nav.jpg" alt="Image 2">
  <img src="slike/tip.jpg" alt="Image 3">
  <img src="slike/DOT.jpg" alt="Image 4">
  <img src="slike/night.jpg" alt="Image 5">
  <img src="slike/noc.jpg" alt="Image 6">
  <img src="slike/taxi.jpg" alt="Image 7">
</div> 

<!-- O PODJETJU -->
<section id="podjetje" class="sekcija podjetje">
 <a href="opodjetju.php">Uredi</a> 
  <h2>O PODJETJU</h2>
  <p><strong>Ime podjetja:</strong> <?php echo htmlspecialchars($podjetje['ime'] ?? ''); ?></p>
  <p><strong>Naslov:</strong> <?php echo htmlspecialchars($podjetje['naslov'] ?? ''); ?></p>
  <p><strong>Telefon:</strong> <?php echo htmlspecialchars($podjetje['telefon'] ?? ''); ?></p>
  <p><strong>E-pošta:</strong> <?php echo htmlspecialchars($podjetje['email'] ?? ''); ?></p>
  <p><strong>Davčna številka:</strong> <?php echo htmlspecialchars($podjetje['davcna_stevilka'] ?? ''); ?></p>
  <p><strong>Matična številka:</strong> <?php echo htmlspecialchars($podjetje['maticna_stevilka'] ?? ''); ?></p>
  <p><strong>Odgovorna oseba:</strong> <?php echo htmlspecialchars($podjetje['odgovorna_oseba'] ?? ''); ?></p>
</section>

<!-- KOMENTARJI -->
<section id="komentarji" class="sekcija komentarji">
<a href="ocena_voznika.php">Preglej</a>
  <h2>KOMENTIRAJ IN OCENI</h2>
  <form action="poslji.php" method="POST">
    <label for="komentar-ime">Ime:</label>
    <input type="text" id="komentar-ime" name="ime" required>

    <label for="ocena">Ocena (1-5):</label>
    <select id="ocena" name="ocena" required>
      <option value="">Izberi oceno</option>
      <option value="5">5 - Odlično</option>
      <option value="4">4 - Zelo dobro</option>
      <option value="3">3 - V redu</option>
      <option value="2">2 - Slabo</option>
      <option value="1">1 - Zelo slabo</option>
    </select>

    <label for="komentar">Komentar:</label>
    <textarea id="komentar" name="komentar" rows="5" required></textarea>

    <button type="submit">Pošlji</button>
  </form>
</section>

<!-- FOOTER -->
<footer>
  <p><strong>Dynamic OTransp0rt1 d.o.o.</strong></p>
  <p>Glavna cesta 123, 3320 Velenje | Tel: +386 40 123 456 | Email: info@otransport1.si</p>
  <p>
    <a href="#cenik">Cenik</a> |
    <a href="#kontakt">Kontakt</a> |
    <a href="#podjetje">O nas</a> |
    <a href="#obvestila">Obvestila</a>
  </p>
  <p>&copy; 2025 Dynamic OTransp0rt1. Vse pravice pridržane.</p>
</footer>

</body>
</html>
