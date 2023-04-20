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
    <title>Modifica Cliente:</title>
</head>

<body>

    <div class="container mt-5">

        <?php
        include('config/db.php');
        if (isset($_POST['update']) && $_SERVER['REQUEST_METHOD'] == "POST") {

            /*create table customers(
                -> ID INT PRIMARY KEY AUTO_INCREMENT,
                -> FidelityPoints INT (Può essere null se il cliente non ha la tesserà fedeltà),
                -> Name varchar(255) NOT NULL,
                -> Surname varchar(255) NOT NULL,
                -> Address varchar(255) NOT NULL,
                -> PhoneNumber char(10) NOT NULL,
                -> email varchar(255) NOT NULL,
                -> token varchar(255) NOT NULL,
                -> is_active enum('0','1') NOT NULL,
                -> password varchar(255) NOT NULL);*/

            if (!$risultatoQuery = $connection->query("UPDATE customers C SET C.Name='{$_POST['Name']}',C.Surname='{$_POST['Surname']}',C.Address='{$_POST['Address']}',C.PhoneNumber='{$_POST['PhoneNumber']}',C.email='{$_POST['email']}' WHERE C.ID={$_POST['ID']}")) {
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
            header("Refresh:2 url=./dashboardClienti.php");

            exit(0);

        }


        ?>



        <?php
        if (isset($_POST['edit'])) {
            $IDDaModificare = mysqli_real_escape_string($connection, $_POST['edit']);
            $query = "SELECT C.ID,C.Name,C.Surname,C.Address,C.PhoneNumber,C.email FROM customers C WHERE C.ID=$IDDaModificare ";
            $query_run = mysqli_query($connection, $query);

              /*create table customers(
                -> ID INT PRIMARY KEY AUTO_INCREMENT,
                -> FidelityPoints INT (Può essere null se il cliente non ha la tesserà fedeltà),
                -> Name varchar(255) NOT NULL,
                -> Surname varchar(255) NOT NULL,
                -> Address varchar(255) NOT NULL,
                -> PhoneNumber char(10) NOT NULL,
                -> email varchar(255) NOT NULL,
                -> token varchar(255) NOT NULL,
                -> is_active enum('0','1') NOT NULL,
                -> password varchar(255) NOT NULL);*/

            if (mysqli_num_rows($query_run) > 0) {
                $customer = mysqli_fetch_array($query_run);
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Modifica Cliente "<?= $customer['Name']?> <?= $customer['Surname'] ?>":
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                    ID:<br><input type="text" readonly name="ID" value="<?= $customer['ID']; ?>"
                                        class="form-control">

                                    <div class="mb-3">
                                        <label>Nome:</label>
                                        <input type="text" name="Name" value="<?= $customer['Name']; ?>"
                                            class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Cognome</label>
                                        <input type="text" name="Surname" value="<?= $customer['Surname']; ?>"
                                            class="form-control" required>
                                    </div>
                                  
                                    <div class="mb-3">
                                        <label>Indirizzo</label>
                                        <input type="text" name="Address" value="<?= $customer['Address']; ?>"
                                            class="form-control" required>
                                    </div>
                                  
                                    <div class="mb-3">
                                        <label>Numero di telefono:</label>
                                        <input type="text" name="PhoneNumber" value="<?= $customer['PhoneNumber']; ?>" class="form-control" pattern="[0-9]{10}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label>Email:</label>
                                        <input type="email" name="email" value="<?= $customer['email']; ?>" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" name="update" class="btn btn-primary">
                                            Aggiorna cliente:
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