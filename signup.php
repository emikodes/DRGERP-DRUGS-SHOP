
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Registra Utente</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
    <?php   
    // Database connection
    include('config/db.php');
    require('phpmailer/src/Exception.php');
    require('phpmailer/src/PHPMailer.php');
    require('phpmailer/src/SMTP.php');
    
    // Error & success messages
    global $success_msg, $email_exist, $f_NameErr, $l_NameErr, $_emailErr, $_mobileErr;
    global $fNameEmptyErr, $lNameEmptyErr, $emailEmptyErr, $mobileEmptyErr, $passwordEmptyErr, $addressEmptyErr,$email_verify_err, $email_verify_success;
        
    /*<div class="form-group">
    <label>Nome</label>
    <input type="text" class="form-control" name="name" id="name" />

    <?php echo $fNameEmptyErr; ?>
    <?php echo $f_NameErr; ?>
</div>

<div class="form-group">
    <label>Cognome</label>
    <input type="text" class="form-control" name="surname" id="surname" />

    <?php echo $l_NameErr; ?>
    <?php echo $lNameEmptyErr; ?>
</div>

<div class="form-group">
    <label>Indirizzo</label>
    <input type="text" class="form-control" name="address" id="address" />

    <?php echo $addressErr; ?>
    <?php echo $addressEmptyErr; ?>
</div>
<div class="form-group">
    <label>Email</label>
    <input type="email" class="form-control" name="email" id="email" />

    <?php echo $_emailErr; ?>
    <?php echo $emailEmptyErr; ?>
</div>

<div class="form-group">
    <label>Phone Number</label>
    <input type="text" class="form-control" name="phonenumber" id="phonenumber" />

    <?php echo $_mobileErr; ?>
    <?php echo $mobileEmptyErr; ?>
</div>

<div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" name="password" id="password" />

    <?php echo $_passwordErr; ?>
    <?php echo $passwordEmptyErr; ?>
</div>*/

    if(isset($_POST["submit"])) {
        $inputErr=0;

        echo "<br><br><br><br>";
     
        
            if(!empty($_POST["name"]) && !empty($_POST["surname"]) && !empty($_POST["address"]) && !empty($_POST["email"]) && !empty($_POST["phonenumber"] && !empty($_POST["password"]))){
            // Verify if form values are not empty

            // check if user email already exist
            if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM customers WHERE email = '{$_POST['email']}' ")) > 0) {
                $email_exist = '
                    <div class="alert alert-danger" role="alert">
                        Email già registrata nei nostri database!
                    </div>
                ';
            } else {
                // clean the form data before sending to database
                $firstname = mysqli_real_escape_string($connection, $_POST["name"]);
                $lastname = mysqli_real_escape_string($connection, $_POST["surname"]);
                $address = mysqli_real_escape_string($connection, $_POST["address"]);
                $email = mysqli_real_escape_string($connection, $_POST["email"]);
                $mobilenumber = mysqli_real_escape_string($connection, $_POST["phonenumber"]);
                $password = mysqli_real_escape_string($connection, $_POST["password"]);

                // perform validation
                if(!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
                    $f_NameErr = '<div class="alert alert-danger">
                            Only letters and white space allowed.
                        </div>';
                        $inputErr=1;
                }
                if(!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
                    $l_NameErr = '<div class="alert alert-danger">
                            Only letters and white space allowed.
                        </div>';
                        $inputErr=1;

                }
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_emailErr = '<div class="alert alert-danger">
                            Email format is invalid.
                        </div>';
                        $inputErr=1;

                }
                if(!preg_match("/^[0-9]{10}+$/", $mobilenumber)) {
                    $_mobileErr = '<div class="alert alert-danger">
                            Only 10-digit mobile numbers allowed.
                        </div>';
                        $inputErr=1;

                }
                
                // Store the data in db, if all the preg_match condition met
                if($inputErr==0){

                    // Generate random activation token
                    $token = md5(rand().time());

                    // Password hash
                    $password_hash = password_hash($password, PASSWORD_BCRYPT);

                    $loginLink="https://TOBEFILLEDIN/user_verification.php?token=" . $token;

                    // Query

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
                        -> password varchar(255) NOT NULL);
                    */
                    


                    if(!mysqli_query($connection, "INSERT INTO customers (Name, Surname,Address,PhoneNumber, email, token, is_active,password) VALUES ('{$firstname}', '{$lastname}', '{$address}',
                    '{$mobilenumber}', '{$email}', '{$token}', '0', '{$password_hash}');")){
                        die("Errore durante l'esecuzione della query." . mysqli_error($connection));
                    }else{
                        $msg = <<<HTML
                        <head>
                            
                            <!-- CHARSET -->
                            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                            
                            <!-- MOBILE FIRST -->
                            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
                            
                            <!-- GOOGLE FONTS -->
                            <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono" rel="stylesheet">
                            <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
                            
                            <!-- RESPONSIVE CSS -->
                            <style type="text/css">
                                @media only screen and (max-width: 550px){
                                    .responsive_at_550{
                                        width: 90% !important;
                                        max-width: 90% !important;
                                    }
                                }
                            </style>
                        
                        </head>
                        <!-- END HEAD -->
                        
                        <!-- START BODY -->
                        <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
                            
                            <!-- START EMAIL CONTENT -->
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">        
                                <tbody>
                                    
                                    <tr>
                                        
                                        <td align="center" bgcolor="#6610f2">
                                            
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td width="100%" align="center">
                                                            
                                                            <!-- START SPACING -->
                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                                <tbody>
                                                                    <tr>
                                                                        <td height="40">&nbsp;</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <!-- END SPACING -->

                                                            
                                                            <!-- START SPACING -->
                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                                <tbody>
                                                                    <tr>
                                                                        <td height="40">&nbsp;</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <!-- END SPACING -->
                                                            
                                                            <!-- START CONTENT -->
                                                            <table width="500" border="0" cellpadding="0" cellspacing="0" align="center" style="padding-left:20px; padding-right:20px;" class="responsive_at_550">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" bgcolor="#2e2a2a">
                                                                            
                                                                            <!-- START BORDER COLOR -->
                                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td width="100%" height="7" align="center" border="0" bgcolor="#551857"></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <!-- END BORDER COLOR -->
                                                                            
                                                                            <!-- START SPACING -->
                                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td height="30">&nbsp;</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <!-- END SPACING -->
                                                                            
                                                                            <!-- START HEADING -->
                                                                            <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td width="100%" align="center">
                                                                                            <h1 style="font-family:'Ubuntu Mono', monospace; font-size:20px; color:#ffffff; font-weight:bold; padding-left:20px; padding-right:20px;">droga calda (sul cucchiaio) a 2min da te</h1>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <!-- END HEADING -->
                                                                            
                                                                            <!-- START PARAGRAPH -->
                                                                            <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td width="100%" align="center">
                                                                                            <p style="font-family:'Ubuntu', sans-serif; font-size:14px; color:#ffffff; padding-left:20px; padding-right:20px; text-align:justify;">Grazie fattone del cazzo per regalarci i tuoi soldi, clicca qua sotto per foto di totti nudo</p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <!-- END PARAGRAPH -->
                                                                            
                                                                            <!-- START SPACING -->
                                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td height="30">&nbsp;</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <!-- END SPACING -->
                                                                            
                                                                            <!-- START BUTTON -->
                                                                            <table width="200" border="0" cellpadding="0" cellspacing="0" align="center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" bgcolor="#6610f2">
                                                                                            <a style="font-family:'Ubuntu Mono', monospace; display:block; color:#ffffff; font-size:14px; font-weight:bold; text-decoration:none; padding-left:20px; padding-right:20px; padding-top:20px; padding-bottom:20px;" href={$loginLink}>Verifica indirizzo Mail</a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <!-- END BUTTON -->
                                                                            
                                                                            <!-- START SPACING -->
                                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td height="30">&nbsp;</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <!-- END SPACING -->
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <!-- END CONTENT -->
                                                            
                                                            <!-- START SPACING -->
                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                                <tbody>
                                                                    <tr>
                                                                        <td height="40">&nbsp;</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <!-- END SPACING -->
                                                            
                                                           
                                                            <!-- START SPACING -->
                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                                                <tbody>
                                                                    <tr>
                                                                        <td height="40">&nbsp;</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <!-- END SPACING -->
                                                            
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                        </td>
                                        
                                    </tr>
                                    
                                </tbody>        
                            </table>
                            
                        </body>
                        HTML;
                        
                        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

                        $mail->isSMTP();// Set mailer to use SMTP
                        $mail->CharSet = "utf-8";// set charset to utf8
                        $mail->SMTPAuth = true;// Enable SMTP authentication
                        $mail->SMTPSecure = 'ssl';// Enable TLS encryption, `ssl` also accepted
                        
                        $mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
                        $mail->Port = 465;// TCP port to connect to
                        $mail->SMTPOptions = array(
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            )
                        );
                        $mail->isHTML(true);// Set email format to HTML
                        
                        $mail->Username = 'TOBEFILLEDIN';
                        $mail->Password = 'TOBEFILLEDIN';        
                        
                        $mail->setFrom('mailProject.VERIFY@gmail.com', 'DRGSHOP');//Your application NAME and EMAIL
                        $mail->Subject = 'Conferma la tua mail:';
                        $mail->Body    = $msg;
                        $mail->AltBody = $msg;
                        $mail->AddAddress($email);          
                        
                        if(!$mail->send()){
                            $email_verify_err = '<div class="alert alert-danger">
                                    Impossibile inviare mail di verifica:' . $mail->ErrorInfo . '
                            </div>';

                        } else {
                            $email_verify_success = '<div class="alert alert-success">
                                Mail di verifica inviata!
                            </div>';
                        }
                    }
                }
            }
        } else {
            if(empty($firstname)){
                $fNameEmptyErr = '<div class="alert alert-danger">
                    First name can not be blank.
                </div>';
            }
            if(empty($lastname)){
                $lNameEmptyErr = '<div class="alert alert-danger">
                    Last name can not be blank.
                </div>';
            }
            if(empty($email)){
                $emailEmptyErr = '<div class="alert alert-danger">
                    Email can not be blank.
                </div>';
            }
            if(empty($mobilenumber)){
                $mobileEmptyErr = '<div class="alert alert-danger">
                    Mobile number can not be blank.
                </div>';
            }
            if(empty($password)){
                $passwordEmptyErr = '<div class="alert alert-danger">
                    Password can not be blank.
                </div>';
            }            
        }
    }
?>
   
   <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">DRUGS SHOP - Area Riservata:</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02"
            aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./signup.php">Registrati</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<br><br><br><br>


    <div class="App">
        <div class="vertical-center">
            <div class="inner-block">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                    <h3>Registra cliente:</h3>

                    <?php echo $success_msg; ?>
                    <?php echo $email_exist; ?>

                    <?php echo $email_verify_err; ?>
                    <?php echo $email_verify_success; ?>

                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="name" id="name" />

                        <?php echo $fNameEmptyErr; ?>
                        <?php echo $f_NameErr; ?>
                    </div>

                    <div class="form-group">
                        <label>Cognome</label>
                        <input type="text" class="form-control" name="surname" id="surname" />

                        <?php echo $l_NameErr; ?>
                        <?php echo $lNameEmptyErr; ?>
                    </div>

                    <div class="form-group">
                        <label>Indirizzo</label>
                        <input type="text" class="form-control" name="address" id="address" />

                        <?php echo $addressEmptyErr; ?>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="email" />

                        <?php echo $_emailErr; ?>
                        <?php echo $emailEmptyErr; ?>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="phonenumber" id="phonenumber" />

                        <?php echo $_mobileErr; ?>
                        <?php echo $mobileEmptyErr; ?>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" id="password" />

                        <?php echo $passwordEmptyErr; ?>
                    </div>

                    <button type="submit" name="submit" id="submit" class="btn btn-outline-primary btn-lg btn-block">Registrati
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>