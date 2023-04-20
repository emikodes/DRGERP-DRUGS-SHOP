<!doctype html>
<html lang="en">
  <style>
    hr.new
    {
      border: 3px solid blueviolet;
    }
  </style>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ECSTASY</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <center>
      <img style="margin-top: 20px;" src="img/pills.png"><br><br>
      <hr class="new" style="color: blueviolet; width: 80%;">
    </center>
  </head>
  <body style="background-color: #000000e0;">
    <form method="POST" action=" <?php $_SERVER["PHP_SELF"]; ?> ">
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
          // Connessione al database
          include('config/db.php');
  
          // Query per recuperare i dati dei prodotti dalla tabella 'product'
          $query = "SELECT * FROM products WHERE id=6";
  
          // Esecuzione della query
          $result = mysqli_query($connection, $query);
  
          // Recupero dei dati e creazione dei card per ogni prodotto
          while ($row = mysqli_fetch_assoc($result)) 
          {
            echo '
              <div class="col" style="margin-left:190px; margin-top: 30px;">
                <div class="card h-100" style="width: 30rem; margin-top: 30px; background-color:#000000e0; border-color: blueviolet;">
                  <img src="img/codeina.jpg" class="card-img-top" alt="...">
                  <div class="card-body">
                    <center>
                      <h5 class="card-title" style="color: aliceblue;">' . $row['ProductName'] . '</h5>
		<form method="post" action = "{$_SERVER["PHP_SELF"]}">
                        <input class="btn btn-primary" type="number" style="background-color: blueviolet; border-color: blueviolet;" name="quantity">
                        <input type="hidden" name="productname" value="' . $row['ProductName'] . '">
                        <input type="hidden" name="ID" value="' . $row['ID'] . '">
                        <input type="hidden" name="ShopID" value="' . $row['ShopID'] . '">
                        <input type="hidden" name="price" value="' . $row['Price'] . '">
                        <input class="btn btn-primary" type="submit" style="background-color: blueviolet; border-color: blueviolet;" value="Aggiungi al carrello" name="add">
                      </form>
                    </center>
                  </div>
                </div>
              </div>
            ';
          }
          mysqli_close($connection);
          ?>
      </div>
      <center>
        <br><br><br><a href="index.html" style="color: blueviolet; font-family: monospace; font-size: 20px;">PAGINA INIZIALE</a>
        <a href="cart.php" style="color: blueviolet; font-family: monospace; font-size: 20px;">CARRELLO</a>
      </center>
        </form>
  </body>
</html>

<!-- Pagina di gestione del carrello (gestione_carrello.php) -->
<?php
// Connessione al database
include('config/db.php');

// Verifica se è stato inviato un comando di aggiunta al carrello
if (isset($_POST['add']) ) {
  // Recupera i dati del prodotto dal form

  /*+-------------+--------------+------+-----+---------+-------+
    | Field       | Type         | Null | Key | Default | Extra |
    +-------------+--------------+------+-----+---------+-------+
    | price       | float        | NO   |     | NULL    |       |
    | quantity    | int(11)      | NO   |     | NULL    |       |
    | productname | varchar(255) | NO   |     | NULL    |       |
    | ProductID   | int(11)      | YES  |     | NULL    |       |
    | ShopID      | int(11)      | YES  |     | NULL    |       |
    | CustomerID  | int(11)      | YES  |     | NULL    |       |
    +-------------+--------------+------+-----+---------+-------+ */

  $productname = $_POST['productname'];
  $price = $_POST['price'];
  $quantity=$_POST['quantity'];
  $ShopID=$_POST['ShopID'];
  $ProductID=$_POST['ID'];

  // Inserisci i dati del prodotto nella tabella "cart"
  $query = "INSERT INTO cart (productname, price, quantity,ProductID,ShopID) VALUES ('$productname', $price, $quantity,$ProductID,$ShopID);";
  mysqli_query($connection, $query);
}
?>