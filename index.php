<?php
require_once 'baza_povezava.php';
include_once 'seja.php';
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
    <img src="slike/logo1.jpg" alt="Logo">
  </div>

  <div class="title"><span class="rdeca">DO</span> <span class="rdeca">T</span>RANSP0RT<span class="rdeca">0</span></div>

  <nav class="buttons">
    <a href="#top" class="button">Domov</a>
    <a href="#cenik" class="button">Cenik</a>
    <a href="#kontakt" class="button">Kontakt</a>
    <a href="#obvestila" class="button">Obvestila</a>
    <a href="#podjetje" class="button">O nas</a>
    <a href="prijava_uporabnikov.php" class="nav-button">Prijava</a>
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
<section id="cenik" class="sekcija cenik">
  <h2>CENIK PREVOZOV</h2>
  <table>
    <thead>
      <tr>
        <th>Storitev</th>
        <th>Opis</th>
        <th>Cena</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Mestni prevozi</td>
        <td>Prevozi znotraj mest ter po celotni Sloveniji. Ne glede na to, ali potrebujete hiter mestni prevoz ali daljšo pot med kraji.</td>
        <td>0.70€/km</td>
      </tr>
      <tr>
        <td>Nočni prevozi</td>
        <td>Zagotovite si varen in zanesljiv prevoz tudi ponoči po 20:00 uri</td>
        <td>1.0€/km</td>
      </tr>
      <tr>
        <td>Celodnevni prevozi</td>
        <td>Možen najem vozila za večje skupine – idealno za dogodke, prevoze do letališč ali celodnevne poti po Sloveniji in tujini.</td>
        <td>€10/h (ali po dogovoru)</td>
      </tr>
    </tbody>
  </table>
</section>

<!-- KONTAKT -->
<section id="kontakt" class="sekcija kontakt">
  <h2>PIŠI IN SE PRIJAVI</h2>
  <form action="poslji.php" method="POST">
    <label for="kontakt-ime">Ime:</label>
    <input type="text" id="kontakt-ime" name="ime" required>

    <label for="priimek">Priimek:</label>
    <input type="text" id="priimek" name="priimek" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+">

    <label for="telefon">Telefonska številka:</label>
    <input type="tel" id="telefon" name="telefon">

    <label for="sporocilo">Sporočilo:</label>
    <textarea id="sporocilo" name="sporocilo" rows="5" required></textarea>

    <button type="submit">Pošlji</button>
  </form>
</section>

<!-- Obvestila -->
<section id="obvestila" class="sekcija obvestila">
  <h2>OBVESTILA</h2>

  <div class="obvestilo">
    <h3>Spremenjen delovni čas</h3>
    <p>Od 25. junija do 5. julija bo podjetje zaprto zaradi počitnic.</p>
  </div>

  <div class="obvestilo">
    <h3>Nova storitev dostave</h3>
    <p>Dodali smo novo možnost hitre dostave paketov do 5 kg po celotni Sloveniji!</p>
  </div>

  <div class="obvestilo">
    <h3>Poletna akcija</h3>
    <p>Vsi mestni prevozi 15% ceneje do konca augusta!</p>
  </div>
</section>

<div class="image-container"> 
  <img src="slike/taxi.jpg" alt="Image 1">
  <img src="slike/nav.jpg" alt="Image 2">
  <img src="slike/tip.jpg" alt="Image 3">
  <img src="slike/DOT.jpg" alt="Image 4">
  <img src="slike/night.jpg" alt="Image 5">
  <img src="slike/noc.jpg" alt="Image 6">
  <img src="slike/taxi.jpg" alt="Image 7">
</div> 

<!-- Podatki o podjetju -->
<section id="podjetje" class="sekcija podjetje">
  <h2>O PODJETJU</h2>
  <p><strong>Ime podjetja:</strong> Dynamic OTransp0rt1 d.o.o.</p>
  <p><strong>Naslov:</strong> Glavna cesta 123, 3320 Velenje, Slovenija</p>
  <p><strong>Telefon:</strong> +386 40 123 456</p>
  <p><strong>E-pošta:</strong> info@otransport1.si</p>
  <p><strong>Davčna številka (ID za DDV):</strong> SI12345678</p>
  <p><strong>Matična številka:</strong> 9876543</p>
  <p><strong>Odgovorna oseba:</strong> Živa Zupanc</p>
</section>

<!-- Komentarji -->
<section id="komentarji" class="sekcija komentarji">
  <h2>KOMENTIRAJ IN OCENI</h2>

  <form action="komantar_poslji.php" method="POST">

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

<!-- Footer -->
<footer>
  <p><strong>Dynamic OTransp0rt1 d.o.o.</strong></p>
  <p>Glavna cesta 123, 3320 Velenje, Slovenija | Tel: +386 40 123 456 | Email: info@otransport1.si</p>
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
