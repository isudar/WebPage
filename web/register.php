<!DOCTYPE html>
<html lang="en">
<head>
  <title>RK "CESTORAD"</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="dizajn.css" type = "text/css">
</head>
<body>
<?php require_once('gornjiDio.php'); ?>
  
  <div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav">
      
    </div>
    <div class="col-sm-7 text-left"> 
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <hr>
  <div class="form-group" >
    <label for="kor_ime">Korisnicko ime</label>
    <input type="text" class="form-control" id="kor_ime" name="kor_ime" placeholder="Korisnicko ime" required>
  </div>
        <hr>
  <div class="form-group" >
    <label for="ime">Ime</label>
    <input type="text" class="form-control" id="ime" name="ime" placeholder="Ime" required>
  </div>
        <hr>
  <div class="form-group" >
    <label for="prezime">Prezime</label>
    <input type="text" class="form-control" id="prezime" name="prezime" placeholder="Prezime" required>
  </div>
        <hr>
  <div class="form-group">
    <label for="zaporka">Zaporka</label>
    <input type="password" class="form-control" id="zaporka" name="zaporka" placeholder="Zaporka" required>
  </div>
    <hr>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
<?php
if(!isset($_SESSION['id']) && empty($_SESSION['id'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $korisnikoIMe = $_POST['kor_ime'];
        $zaporka = md5($_POST['zaporka']);
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];

        $stmt = $spoj->prepare("SELECT * FROM korisnik WHERE korisnickoIme=:korisnickoIme");
        $stmt->bindParam(':korisnickoIme', $korisnikoIMe);
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count === 0) {
                $stmt = $spoj->prepare("INSERT INTO korisnik(korisnickoIme, zaporka, ime, prezime) 
                                            VALUES(:koIme, :zaporka, :ime, :prezime)");
                $stmt->bindParam(':koIme', $korisnikoIMe);
                $stmt->bindParam(':zaporka', $zaporka);
                $stmt->bindParam(':ime', $ime);
                $stmt->bindParam(':prezime', $prezime);
                $stmt->execute();
                header('Location: prijava.php');
        }else {
            echo "Korisnik s korisničkim imenom već postoji!";
        }
    }
} else {
     header('Location: ' . $_SERVER['HTTP_REFERER']);
}
 ?>
    </div>
    <div class="col-sm-3 sidenav">

    </div>
  </div>
</div>


<footer class="container-fluid text-center">
  <p>Ivan Sudar, DKB</p>
</footer>

</body>
</html>
