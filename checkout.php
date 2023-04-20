<?php
    // Connessione al database
    include('config/db.php');

    if (isset($_POST["svuota"])) {
        // Query per cancellare tutti i prodotti dal carrello
        $query = "DELETE FROM cart;";

        // Esecuzione della query
        mysqli_query($connection, $query);
    }
?>