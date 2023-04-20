<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carrello</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body style="background-color: #000000e0;">
    <div class="container">
      <center><h1 style="color: blueviolet;">Carrello</h1><center>
      <table class="table">
        <thead>
          <tr>
            <th style="color: blueviolet;">Prodotto</th>
            <th style="color: blueviolet;">Prezzo</th>
            <th style="color: blueviolet;">Quantità</th>
            <th style="color: blueviolet;">Totale</th>
          </tr>
        </thead>
        <tbody>
          <form method="POST" action=<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>>
		<?php
			// Connessione al database
      include('config/db.php');

			// Query per recuperare i dati dal database
			$sql = "SELECT * FROM cart";
			$result = mysqli_query($connection, $sql);

			// Ciclo per visualizzare i dati recuperati
			while ($row = mysqli_fetch_assoc($result)) {
				$nome_prodotto = $row['productname'];
				$prezzo = $row['price'];
				$quantita = $row['quantity'];
				$totale = $prezzo * $quantita;

				echo "<tr>";
				echo "<td style=\"color: aliceblue;\">$nome_prodotto</td>";
				echo "<td style=\"color: aliceblue;\">$prezzo</td>";
				echo "<td style=\"color: aliceblue;\">$quantita</td>";
				echo "<td style=\"color: aliceblue;\">$totale</td>";
				echo "</tr>";
			}

			// Chiusura della connessione al database
			mysqli_close($connection);
		?>
        </tbody>
      </table>
      <div class="d-grid gap-2">
        <input type="submit" class="btn btn-primary" style="background-color: blueviolet; border-color: blueviolet;" name="svuota" value="Svuota il carrello">
        <input type="submit" class="btn btn-primary" style="background-color: blueviolet; border-color: blueviolet;" name="compra" value="Acquista">

        <a href="index.html" class="btn btn-secondary" style="background-color: #000000e0;border-color: #000000e0;">Continua lo shopping</a>
      </div>
    </div>

    </form>
  </body>
</html>
<?php
    // Connessione al database
    include('config/db.php');

    if (isset($_POST["svuota"])) {
        // Query per cancellare tutti i prodotti dal carrello
        $query = "DELETE FROM cart;";

        // Esecuzione della query
        mysqli_query($connection, $query);
        header("Refresh:0");

    }

    if(isset($_POST['compra']))
    {
      if(isset($_SESSION['id']))
      {
        //se l'utente è loggato, per ogni prodotto nel carrello inserisci una riga nella tabella "orders"
        /*create table orders(
          ID INT PRIMARY KEY AUTO_INCREMENT,
          CustomerID INT REFERENCES customers(ID) ON DELETE CASCADE ON UPDATE CASCADE,
          ProductID INT REFERENCES products(ID) ON DELETE CASCADE ON UPDATE CASCADE,
          Quantity INT NOT NULL,
          Data DATE,
          Address varchar(50),
          ShopID INT REFERENCES shop(ID) ON DELETE CASCADE ON UPDATE CASCADE);
      
          Tabella "Cart"
          *+-------------+--------------+------+-----+---------+-------+
          | Field       | Type         | Null | Key | Default | Extra |
          +-------------+--------------+------+-----+---------+-------+
          | price       | float        | NO   |     | NULL    |       |
          | quantity    | int(11)      | NO   |     | NULL    |       |
          | productname | varchar(255) | NO   |     | NULL    |       |
          | ProductID   | int(11)      | YES  |     | NULL    |       |
          | ShopID      | int(11)      | YES  |     | NULL    |       |
          +-------------+--------------+------+-----+---------+-------+ */

        $sql = "SELECT * FROM cart";
        $result = mysqli_query($connection, $sql);
      
        // Ciclo per ogni prodotto nel carrello
        while($row = mysqli_fetch_assoc($result)) {
          $ProductId = $row['ProductID'];
          $CustomerId = mysqli_fetch_array($connection->query("SELECT ID FROM customers WHERE email='{$_SESSION['email']}'"))['ID'];
          $Quantity = $row['quantity'];
          $Data = date('Y-m-d');
          $shop_id = $row['ShopID'];
          $Address = $_SESSION['address'];
      
          echo $CustomerId;

          // Inserire il prodotto nella tabella ordini
          $sql2 = "INSERT INTO orders (CustomerID,ProductID,Quantity,Data,Address,ShopID)
                   VALUES ('$CustomerId','$ProductId', '$Quantity', '$Data', '$Address','$shop_id')";
      
          mysqli_query($connection, $sql2);
        }
      
        // Svuotare il carrello dell'utente loggato
        $sql3 = "DELETE FROM cart";
        mysqli_query($connection, $sql3);
        //OCCHIO CHE CustomerID è una foreign key, se sei loggato ho già fatto io la creazione del cliente, quindi fai una query in cui cerchi l'id del cliente tramite la mail che sta in £_SESSION['email], poi l'id lo metti come foreign key.
        //capito niente della riga 111 zio pera
        //SELECT id FROM customers WHERE email=$_SESSION['email']
      }
      else
      {
 echo "<br><br><div class='alert alert-warning email_alert'>
                    Non sei loggato come utente!.
                    </div><center>
                    <a href=\"./login.php\" style=\"color: blueviolet; font-family: monospace; font-size: 20px; margin-left: -40px;\">LOGIN</a>
                  </center>";}
    }
?>

