<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="src/fakerecaptcha.css" rel="stylesheet">

    <title>Area Prodotti:</title>
    <!-- jQuery + Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>

    <?php
    include('config/db.php');

    if (isset($_SESSION['ID'])) {
        ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-auto bg-light sticky-top">
                    <div class="d-flex flex-sm-column flex-row flex-nowrap bg-light align-items-center sticky-top">
                        <a href="./dashboardDipendente.php" class="d-block p-3 link-dark text-decoration-none" title=""
                            data-bs-toggle="tooltip" data-bs-placement="right">
                            <img src="LOGO2.png"></img>
                        </a>
                        <ul
                            class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center justify-content-between w-100 px-3 align-items-center">
                            <li class="nav-item">
                                <a href="./dashboardProdotti.php" class="nav-link py-3 px-2" title=""
                                    data-bs-toggle="tooltip" data-bs-placement="right">
                                    Prodotti:
                                </a>
                            </li>
                            <li>
                                <a href="./dashboardClienti.php" class="nav-link py-3 px-2" title="" data-bs-toggle="tooltip"
                                    data-bs-placement="right">
                                    Clienti:
                                </a>
                            </li>
                            <li>
                                <a href="./dashboardOrdini.php" class="nav-link py-3 px-2" title="" data-bs-toggle="tooltip"
                                    data-bs-placement="right">
                                    Ordini:
                                </a>
                            </li>
                        </ul>

                        <br><br>

                        <b style="color:red;">Log Out:</b>
                        <br>
                        
                        <!-- Fake captcha start -->
                        <div class="fkrc-container fkrc">
                            <!-- Captcha checkbox widget -->
                            <div id="fkrc-checkbox-window" class="fkrc-checkbox-window fkrc-m-p fkrc-block">
                                <div class="fkrc-checkbox-container fkrc-m-p">
                                    <button type="button" id="fkrc-checkbox"
                                        class="fkrc-checkbox fkrc-m-p fkrc-line-normal"></button>
                                </div>
                                <p class="fkrc-im-not-a-robot fkrc-m-p fkrc-line-normal">I'm not a robot</p>
                                <img src="images/captcha_logo.svg" class="fkrc-captcha-logo fkrc-line-normal" alt="">
                                <p class="fkrc-checkbox-desc fkrc-m-p fkrc-line-normal">CAPTCHA</p>
                                <p class="fkrc-checkbox-desc fkrc-m-p fkrc-line-normal">Privacy - Terms</p>
                                <img src="images/captcha_spinner.gif" class="fkrc-spinner fkrc-m-p fkrc-line-normal" alt=""
                                    id="fkrc-spinner">
                            </div>
                            <!-- Captcha checkbox verification window -->
                            <div id="fkrc-verifywin-window" class="fkrc-verifywin-window">
                                <div class="fkrc-verifywin-container">
                                    <header class="fkrc-verifywin-header">
                                        <span class="fkrc-verifywin-header-text-medium fkrc-m-p fkrc-block">pape
                                            captcha</span>
                                        <span class="fkrc-verifywin-header-text-big fkrc-m-p fkrc-block">A sicurezz primm e
                                            tutt</span>
                                    </header>
                                    <main class="fkrc-verifywin-main">
                                        Scarano 10 plz
                                    </main>
                                </div>
                                <footer class="fkrc-verifywin-container fkrc-verifywin-footer">
                                    <div class="fkrc-verifywin-footer-left">
                                        Press the verify button to proceed.
                                    </div>
                                    <button type="button" class="fkrc-verifywin-verify-button fkrc-block"
                                        id="fkrc-verifywin-verify-button">Log Out</button>
                                </footer>
                            </div>
                            <img src="images/captcha_arrow.svg" alt="" class="fkrc-verifywin-window-arrow"
                                id="fkrc-verifywin-window-arrow" />
                        </div>
                        <!-- Fake captcha end -->
                    </div>


                </div>


                <div class="col py-3">
                    <!--create table products(
                ID INT PRIMARY KEY,
                Legal BOOL,
                THCLevel INT,
                Price DECIMAL(7,2) NOT NULL,
                AvailableQuantity INT NOT NULL,
                ShopID INT REFERENCES shop(ID) ON DELETE CASCADE ON UPDATE CASCADE,
                imagepath varchar(255),
                ProductName varchar(255));-->

                    <div class="col p-5 min-vh-50">
                        <div class="d-flex justify-content-center">
                            <div class="card" style="width: 120rem">
                                <div class="card-body">
                                    <h5 class="card-title text-center mb-4">Elenco Prodotti:</h5>
                                    <center><a href="./product_add.php" class="btn btn-success btn-md">Aggiungi prodotto:</a></center>
                                    <br>

                                    <?php

                                    if ($queryPreparata = $connection->prepare("SELECT P.ID,P.ProductName,P.LightHard,P.Price,SUM(P.AvailableQuantity),SUM(P.AvailableQuantity)*P.Price FROM products P GROUP BY P.ProductName ORDER BY P.ID")) {

                                        if (!$queryPreparata->execute()) {
                                            echo "Impossibile eseguire la query: $connection->error";
                                        } else {
                                            $risultatoQuery = $queryPreparata->get_result()->fetch_all(MYSQLI_ASSOC);

                                            
                                            if (count($risultatoQuery) == 0) {
                                                echo "Nessun prodotto trovato.";
                                            } else {

                                                echo "<div class=\"table-responsive\"><table class=\"table table-bordered table-hover table-striped\">";
                                            echo "<tr>";
                                            echo "<th>ID:</th><th>Nome Prodotti:</th><th>Light/Hard:</th><th>Prezzo Unitario:</th><th>Quantità rimasta:</th><th>Ricavo stimato:</th><th>Operazioni:</th>";
                                            echo "</tr>";

                                                foreach ($risultatoQuery as $singolaTupla) {
                                                    //per ogni tupla
                                                    echo "<tr>";
                                                    foreach ($singolaTupla as $attributo) {
                                                        //per ogni attributo nella singola tupla
                                                        echo "<td>$attributo</td>";
                                                    }
                                                    echo "<td>
                                                <form action=\"product_edit.php\" method=\"POST\" class=\"d-inline\">
                                                    <button type=\"submit\" name=\"edit\" value=\"{$singolaTupla['ID']}\" class=\"btn btn-primary btn-sm\">Edit</button>
                                                </form>
                                                <form action=\"product_delete.php\" method=\"POST\" class=\"d-inline\">
                                                    <button type=\"submit\" name=\"delete\" value=\"{$singolaTupla['ID']}\" class=\"btn btn-danger btn-sm\">Delete</button>
                                                </form>
                                            </td>";

                                                    echo "</tr>";
                                                }

                                                echo "</table></div>";
                                            }
                                        }

                                        $queryPreparata->close(); //chiudo query preparata.
                                    } else {
                                        echo "Impossibile eseguire la query: $connection->error";
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        </div>

        <?php
    } else {
        echo "<div class='alert alert-danger email_alert'>
    Non sei loggato come dipendente.
</div>";
    }
    ?>

    <script src="src/fakerecaptcha.js"></script>
</body>

</html>