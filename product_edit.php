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
    <title>Modifica Prodotto:</title>
</head>

<body>

    <div class="container mt-5">

        <?php
        include('config/db.php');
        if (isset($_POST['update']) && $_SERVER['REQUEST_METHOD'] == "POST") {

            /*//Magazzino (Prodotti)
            create table products(
            ID INT PRIMARY KEY,
            Legal BOOL,
            THCLevel INT,
            Price DECIMAL(7,2) NOT NULL,
            AvailableQuantity INT NOT NULL,
            ShopID INT REFERENCES shop(ID) ON DELETE CASCADE ON UPDATE CASCADE,
            imagepath varchar(255),
            ProductName varchar(255)); */

            $quantitàRimanente = $connection->query("SELECT SUM(AvailableQuantity) as available FROM products p INNER JOIN shop ON (ShopID=shop.ID) WHERE p.ID={$_POST['ID']}");
            $quantitàPrecedente = $connection->query("SELECT AvailableQuantity as previous FROM products p WHERE p.ID={$_POST['ID']}");
            $quantitàMassima = $connection->query("SELECT MaxNumProducts as maxNum FROM products p INNER JOIN shop ON (ShopID=shop.ID) WHERE p.ID={$_POST['ID']}");

            $quantitàRimanente = (mysqli_fetch_array($quantitàRimanente)['available']);
            $quantitàPrecedente = (mysqli_fetch_array($quantitàPrecedente)['previous']);
            $quantitàMassima = (mysqli_fetch_array($quantitàMassima)['maxNum']);

            if (($quantitàRimanente - $quantitàPrecedente + (int)$_POST['AvailableQuantity']) > (int)$quantitàMassima) {
                echo "<div class='alert alert-warning email_alert'>
                Valori non aggiornati, non puoi acquistare più prodotti rispetto alla quantità massima del magazzino (Quantità massima: {$quantitàMassima});
                </div>";
            } else {


                if (!$risultatoQuery = $connection->query("UPDATE products P SET P.LightHard='{$_POST['LightHard']}',P.Price={$_POST['Price']},P.AvailableQuantity={$_POST['AvailableQuantity']} WHERE P.ID={$_POST['ID']}")) {
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
              
            }

            header("Refresh:2 url=./dashboardProdotti.php");

            exit(0);
        }


        ?>



        <?php
        if (isset($_POST['edit'])) {


            $IDDaModificare = mysqli_real_escape_string($connection, $_POST['edit']);
            $query = "SELECT P.ID,LightHard,Price,AvailableQuantity,ProductName,S.Address,S.ID AS ShopID FROM products P INNER JOIN shop S ON (P.ShopID=S.ID) WHERE P.ID=$IDDaModificare";
            $query_run = mysqli_query($connection, $query);

            /*create table products(
            ID INT PRIMARY KEY,
            Legal BOOL,
            THCLevel INT,
            Price DECIMAL(7,2) NOT NULL,
            AvailableQuantity INT NOT NULL,
            ShopID INT REFERENCES shop(ID) ON DELETE CASCADE ON UPDATE CASCADE,
            imagepath varchar(255),
            ProductName varchar(255));*/

            if (mysqli_num_rows($query_run) > 0) {
                $product = mysqli_fetch_array($query_run);
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Modifica Prodotto "
                                    <?= $product['ProductName']; ?>":
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    ID:<br>
                                    <input type="text" readonly name="ID" value="<?= $product['ID']; ?>" class="form-control">

                                    <div class="mb-3">
                                        <br>
                                        <label>Light / Hard</label>
                                        <br><br>
                                        <select name="LightHard" class="form-select">
                                            <option value="light" selected>Light</option>
                                            <option value="hard">Hard</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Prezzo</label>
                                        <input type="text" name="Price" value="<?= $product['Price']; ?>"
                                            pattern="[0-9]{1,5}[.]{0,1}[0-9]{0,2}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Quantità disponibile:</label>
                                        <input type="number" name="AvailableQuantity"
                                            value="<?= $product['AvailableQuantity']; ?>" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label>Sede Magazzino:</label>
                                        <input type="text" name="ShopID" value="<?= $product['ShopID']; ?>" class="form-control"
                                            required readonly>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" name="update" class="btn btn-primary">
                                            Aggiorna prodotto:
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