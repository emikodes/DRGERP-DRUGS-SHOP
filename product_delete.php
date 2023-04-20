<?php
    include('config/db.php');

    if (isset($_SESSION['ID'])) {

                if ($queryPreparata = $connection->prepare("DELETE FROM products WHERE ID=?")) {
                    $IDDaEliminare = mysqli_real_escape_string($connection, $_POST['delete']);
                    $queryPreparata->bind_param("s",$IDDaEliminare);

                    if (!$queryPreparata->execute()) {
                        echo "<div class='alert alert-danger email_alert'>
                        Impossibile eseguire la query: {$connection->error}
                        </div>";
                    } else {
                        if ($queryPreparata->affected_rows == 0) {
                            echo "<div class='alert alert-danger email_alert'>
                            Nessun prodotto con quel codice trovato.
                            </div>";
                        } else {
                            header("Location: ./dashboardProdotti.php");
                            exit(0);                        
                        }
                    }

                    $queryPreparata->close(); //chiudo query preparata.
                } else {
                    echo "<div class='alert alert-danger email_alert'>
                    Impossibile eseguire la query: {$connection->error}
                    </div>";
                }

    } else {
        echo "<div class='alert alert-danger email_alert'>
    Non sei loggato come dipendente.
</div>";
    }
    ?>