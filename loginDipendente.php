<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>LOGIN DIPENDENTE</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
<?php
   
   // Database connection
   include('config/db.php');

   global $wrongPwdErr, $accountNotExistErr, $emailPwdErr, $verificationRequiredErr, $email_empty_err, $pass_empty_err;

   if(isset($_POST['login'])) {
       $email_signin        = $_POST['email_signin'];
       $password_signin     = $_POST['password_signin'];

       // clean data 
       $user_email = filter_var($email_signin, FILTER_SANITIZE_EMAIL);
       $pswd = mysqli_real_escape_string($connection, $password_signin);


       /*create table employee(
        -> ID INT PRIMARY KEY,
        -> email varchar(255),
        -> password varchar(255));*/

       // Query if email exists in db
       $sql = "SELECT * From employee WHERE email = '{$email_signin}' ";
       $query = mysqli_query($connection, $sql);
       $rowCount = mysqli_num_rows($query);

       // If query fails, show the reason 
       if(!$query){
          die("Query SQL Fallita: " . mysqli_error($connection));
       }

       if(!empty($email_signin) && !empty($password_signin)){

           // Check if email exist
           if($rowCount <= 0) {
               $accountNotExistErr = '<div class="alert alert-danger">
                       Account non trovato.
                   </div>';
           } else {
               // Fetch user data and store in php session

               while($row = mysqli_fetch_array($query)) {
                   $id            = $row['ID'];
                   $email         = $row['email'];
                   $pass_word     = $row['password'];
               }

               // Verify password
               $password = password_verify($password_signin, $pass_word);

                   if($email_signin == $email && $password_signin == $password) {
                      header("Location: ./dashboardDipendente.php");
                      
                      $_SESSION['ID'] = $id;
                      $_SESSION['email'] = $email;


                   } else {
                       $emailPwdErr = '<div class="alert alert-danger">
                               Mail o Password Errata.
                           </div>';
                   }
               

           }

       } else {
           if(empty($email_signin)){
               $email_empty_err = "<div class='alert alert-danger email_alert'>
                           Inserire email.
                   </div>";
           }
           
           if(empty($password_signin)){
               $pass_empty_err = "<div class='alert alert-danger email_alert'>
                           Inserire password.
                       </div>";
           }            
       }
   }

?>    
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">DRUGS SHOP - Area Riservata DIPENDENTE:</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02"
            aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./login.php">Area Riservata UTENTE</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <!-- Login form -->
    <div class="App">
        <div class="vertical-center">
            <div class="inner-block">

                <form action="" method="post">
                    <h3>Login Dipendente</h3>

                    <?php echo $accountNotExistErr; ?>
                    <?php echo $emailPwdErr; ?>
                    <?php echo $verificationRequiredErr; ?>
                    <?php echo $email_empty_err; ?>
                    <?php echo $pass_empty_err; ?>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email_signin" id="email_signin" />
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password_signin"
                            id="password_signin" />
                    </div>

                    <button type="submit" name="login" id="sign_in" class="btn btn-outline-primary btn-lg btn-block">Login Dipendente</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>