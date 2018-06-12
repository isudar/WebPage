<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <title>RK "CESTORAD"</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="./jquery-3.2.1.js"></script>
  <script src="./skriptica.js"></script>
  <link rel="stylesheet" href="dizajn.css" type = "text/css">
</head>
<body>

<?php require_once('gornjiDio.php'); ?>
<div class="container-fluid text-center">
  <?php
    $stmt = $spoj->prepare("SELECT komentar.tekst as tekst, komentar.datum as datum,
                        korisnik.korisnickoIme as korisnickoIme, korisnik.id as korisnik_id, komentar.id as id
                        FROM komentar
                        INNER JOIN korisnik ON korisnik.id=komentar.korisnik_id");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
    
?>

    <div id="komentar<?php echo $row['id']; ?>">
    <h3><?php echo $row['korisnickoIme']; ?></h3>
    <p><?php echo $row['tekst']; ?></p>
    <p><i><?php echo $row['datum']; ?></i></p>
    <?php if($_SESSION['id'] === $row['korisnik_id']): ?> 
        <button type="submit" class="btn btn-danger" id="obrisi" data-param="<?php echo $row['id'] ?>">Obriši komentar</button>
    <?php endif; ?>
    </div>
    
<?php endwhile; ?>
<hr>
  </div>
<div class="container-fluid text-center">  
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="form-group" >
    <label for="komentar">Komentar:</label>
    <textarea rows="5" cols="30" name="komentar" id="komentar" placeholder="Unesite komentar..." required></textarea>
  

  <button type="submit" class="btn btn-default">Komentiraj</button>
</form>
</div>
</div>


<?php
if(isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $komentar = $_POST['komentar'];

            $stmt = $spoj->prepare("INSERT INTO komentar(tekst, datum, korisnik_id) 
                                        VALUES(:tekst, :datum, :korisnik_id)");
            $stmt->bindParam(':tekst', $komentar);
            $stmt->bindParam(':datum', (new DateTime())->format('Y-m-d H:i:s'));
            $stmt->bindParam(':korisnik_id', $_SESSION['id']);
            $stmt->execute();
            header('Refresh: 0');
        }   
    } else {
     header('Location: ' . $_SERVER['HTTP_REFERER']);
}

 ?>
</div>

 <footer class="container-fluid text-center">
  <p>Ivan Sudar, DKB</p>
</footer>
</body>
</html>
<?php ob_end_flush(); ?>