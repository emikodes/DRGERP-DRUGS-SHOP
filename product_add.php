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
    <title>Aggiunta Prodotto:</title>
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


            $queryConPlaceholder = "INSERT INTO products (Drug,LightHard,Price,AvailableQuantity,ShopID,imagepath,ProductName) VALUES (?, ?, ?,?,?,?)";

            if ($queryPreparata = $connection->prepare($queryConPlaceholder)) {

                $queryPreparata->bind_param("sssssss",$_POST['Drug'],$_POST['LightHard'], $_POST['Price'], $_POST['AvailableQuantity'], $_POST['ShopID'], $_POST['imagepath'], $_POST['ProductName']);
                /*imposto i parametri da sostituire al posto dei placeholder (?).
                il primo parametro, è una stringa detta "type definition",
                in cui specifico il tipo
                di parametri che passerò alla mia query.
                
                In questo caso, 's' sta per "string",
                3 's' perchè inserisco 3 parametri di tipo "string".
                
                b — binary (such as image, PDF file, etc.)
                d — double (floating point number)
                i — integer (whole number)
                s — string (text)
                
                ES: se i parametri fossero due, e in ordine una stringa e un intero,
                la "type definition" string sarebbe "si".
                
                PER PASSARE DATE, POSSO INSERIRE O DIRETTAMENTE
                IL VALORE DI RITORNO DI UN INPUT TYPE DATE,
                O IL VALORE DI RITORNO DELLA FUNZIONA date() nel formato "Y-m-d".
                
                ES: se i parametri fossero due, e in ordine una stringa e un intero,
                la "type definition" string sarebbe "si".
                */

                if (!$queryPreparata->execute()) {
                    //eseguo la query, con i parametri sostituiti al posto dei placeholder
                    echo "<div class='alert alert-warning email_alert'>
            Valori non aggiornati: {$connection->error}
            </div>";
                } else {
                    echo "<div class='alert alert-success email_alert'>
                            Valori aggiornati.
                            </div>";
                }





                header("Refresh:2 url=./dashboardProdotti.php");

                exit(0);


            }
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Aggiungi Prodotto:
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

							<div class="mb-3">
                                <br>
                                <label>Categoria</label>
                                <br><br>
                                <select name="Drug" class="form-select" required>
                                    <option value="cannabis" selected>Cannabis</option>
                                    <option value="lsd">LSD</option>
									<option value="funghetti">Funghetti</option>
                                    <option value="cocaina">Cocaina</option>
                                    <option value="ecstasy">Ecstasy</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <br>
                                <label>Light / Hard</label>
                                <br><br>
                                <select name="LightHard" class="form-select" required>
                                    <option value="light" selected>Light</option>
                                    <option value="hard">Hard</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Prezzo</label>
                                <input type="text" name="Price" value="" pattern="[0-9]{1,5}[.]{0,1}[0-9]{0,2}"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Quantità disponibile:</label>
                                <input type="number" name="AvailableQuantity" value="" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Sede Magazzino:</label>
                                <input type="text" name="ShopID" value="" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Nome Prodotto:</label>
                                <input type="text" name="ProductName" value="" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Path Immagine Prodotto (Memorizzata sul server, per la visualizzazione nella
                                    pagina INDEX):</label>
                                <input type="text" name="imagepath" value="" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <button type="submit" name="update" class="btn btn-primary">
                                    Aggiungi prodotto:
                                </button>
                                <a href="./dashboardDipendente.php" class="btn btn-primary">Torna alla dashboard:</a>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>