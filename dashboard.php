<?php include('config/db.php'); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Area Privata Utente:</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>

<?php 
include('config/db.php');

if(isset($_SESSION['id'])) { 
?>

    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <div class="card" style="width: 25rem">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Profilo Utente:</h5>
                    <p class="card-text">Nome: <?php echo $_SESSION['firstname']; ?></p>
                    <p class="card-text">Cognome: <?php echo $_SESSION['lastname']; ?></p>
                    <p class="card-text">Email: <?php echo $_SESSION['email']; ?></p>
                    <p class="card-text">Numero Telefono: <?php echo $_SESSION['mobilenumber']; ?></p>
                    <p class="card-text">Indirizzo: <?php echo $_SESSION['address']; ?></p>

                    <!-- $_SESSION['id'] = $id;
                      $_SESSION['firstname'] = $firstname;
                      $_SESSION['lastname'] = $lastname;
                      $_SESSION['email'] = $email;
                      $_SESSION['mobilenumber'] = $mobilenumber;
                      $_SESSION['token'] = $token;
                      $_SESSION['address'] = $address;-->

                    <a class="btn btn-danger btn-block" href="logout.php">Log out</a>
                </div>
            </div>
        </div>
    </div>
    <center><a href="./index.html" class="btn btn-primary">Torna agli acquisti!</a></center>

    <?php
}else{
    echo  "<div class='alert alert-danger email_alert'>
    Non sei loggato come utente.
</div>";
}
?>
</body>

</html>