<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ime = htmlspecialchars($_POST["ime"] ?? '');
    $priimek = htmlspecialchars($_POST["priimek"] ?? '');
    $email = htmlspecialchars($_POST["email"] ?? '');
    $telefon = htmlspecialchars($_POST["telefon"] ?? '');
    $sporocilo = htmlspecialchars($_POST["sporocilo"] ?? '');

    // Tukaj lahko shraniš podatke v datoteko, bazo ali jih pošlješ po e-pošti
    // file_put_contents('kontakt_zapisi.txt', "$ime $priimek, $email, $telefon, $sporocilo\n", FILE_APPEND);
    
    echo "<!DOCTYPE html>
    <html lang='sl'>
    <head>
      <meta charset='UTF-8'>
      <title>Sprememba</title>
      <link rel='stylesheet' href='css1.css'>
    </head>
    <body>
      <section class='sekcija poslano'>
        <h2>POSLANO</h2>
        <p>Hvala, $ime! Vaše sporočilo je bilo uspešno poslano.</p>
        <a href='index.php'>← Nazaj na glavno stran</a>
      </section>
    </body>
    </html>";
} else {
    header("Location: index.php");
    exit();
}
