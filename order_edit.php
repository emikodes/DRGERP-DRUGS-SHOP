<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <title>Modifica Ordine:</title>
</head>

<body>

    <div class="container mt-5">

        <?php
        include('config/db.php');
        if (isset($_POST['update']) && $_SERVER['REQUEST_METHOD'] == "POST") {

          /*create table orders(
            ID INT PRIMARY KEY AUTO_INCREMENT,
            CustomerID INT REFERENCES customers(ID) ON DELETE CASCADE ON UPDATE CASCADE,
            ProductID INT REFERENCES products(ID) ON DELETE CASCADE ON UPDATE CASCADE,
            Quantity INT NOT NULL,
            Data DATE,
            Address varchar(50),
            ShopID INT REFERENCES shop(ID) ON DELETE CASCADE ON UPDATE CASCADE);*/

            if (!$connection->query("UPDATE orders O,customers C SET O.Quantity={$_POST['Quantity']},O.Address='{$_POST['Address']}',C.Name='{$_POST['Name']}',C.Surname='{$_POST['Surname']}' WHERE C.ID=O.CustomerID AND O.ID={$_POST['ID']}")) {
                echo "<div class='alert alert-danger email_alert'>
                Impossibile eseguire l'aggiornamento : {$connection->error}.
                </div>";

            } else {
                if ($connection->affected_rows == 0) {
                    echo "<div class='alert alert-warning email_alert'>
                    Valori non aggiornati.
                    </div>";

                } else {

                    echo "<div class='alert alert-success email_alert'>
                    Valori aggiornati.
                    </div>";
                }
            }
            header("Refresh:2 url=./dashboardOrdini.php");

            exit(0);

        }


        ?>



        <?php
        if (isset($_POST['edit'])) {
            $IDDaModificare = mysqli_real_escape_string($connection, $_POST['edit']);
            $query = "SELECT O.ID,C.Name,C.Surname,P.ProductName,O.Quantity,O.Address FROM orders O INNER JOIN customers C ON (O.CustomerID=C.ID) INNER JOIN products P ON (O.ProductID=P.ID) WHERE O.ID={$IDDaModificare}";
            $query_run = mysqli_query($connection, $query);

            /*create table orders(
            ID INT PRIMARY KEY AUTO_INCREMENT,
            CustomerID INT REFERENCES customers(ID) ON DELETE CASCADE ON UPDATE CASCADE,
            ProductID INT REFERENCES products(ID) ON DELETE CASCADE ON UPDATE CASCADE,
            Quantity INT NOT NULL,
            Data DATE,
            Address varchar(50),
            ShopID INT REFERENCES shop(ID) ON DELETE CASCADE ON UPDATE CASCADE);*/

            if (mysqli_num_rows($query_run) > 0) {
                $order = mysqli_fetch_array($query_run);
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Modifica Ordine N.
                                    <?= $order['ID']?>  -  "<?=$order['ProductName']?>":
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    ID:<br><input type="text" readonly name="ID" value="<?= $order['ID']; ?>"
                                        class="form-control">
                                    <div class="mb-3">
                                        <label>Nome Cliente:</label>
                                        <input type="text" name="Name" value="<?= $order['Name']; ?>"
                                            class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Cognome Cliente:</label>
                                        <input type="text" name="Surname" value="<?= $order['Surname']; ?>"
                                            class="form-control" required>
                                    </div>
                            
                                    <div class="mb-3">
                                        <label>Quantità:</label>
                                        <input type="number" name="Quantity"
                                            value="<?= $order['Quantity']; ?>" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label>Indirizzo Spedizione:</label>
                                        <input type="text" name="Address" value="<?= $order['Address']; ?>" class="form-control"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" name="update" class="btn btn-primary">
                                            Aggiorna ordine:
                                        </button>
                                        <a href="./dashboardDipendente.php" class="btn btn-primary">Torna alla dashboard:</a>

                                    </div>

                                </form>
                                <?php
            } else {
                echo "<h4>ID Non trovato.</h4>";
            }
        }
        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>