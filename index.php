<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <meta name=”viewport” content=” width=device-width, height=device-height, initial-scale=1.0, user-scalable=yes,
        maximum-scale=5.0″ />
    <link href="fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="fontawesome/css/brands.css" rel="stylesheet">
    <link href="fontawesome/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <title>UCRS | Billetter</title>
</head>

<body>
    <div id="wrapper">
        <div id="menu">
            <ul>
                <li><a href="index"><img src="img/ucrs_neg.png" alt=""></a></li>
                <li class="menu-item"> <i class="fa-solid fa-ticket icon" id="billet-icon"></i><a
                        href="billet">Billet</a></li>
                <li class="menu-item"> <i class="fa-solid fa-lock icon"></i><a href="admin/login">Login</a></li>
            </ul>
        </div>

        <div id="content">
            <h1 id="navn"> <i class="fa-solid fa-face-sad-tear" style="color: #ffffff;"></i><br> Der er ingen <br> Aktiv
                fest</h1>
            <div id="infos">
                <div class="info">
                    <p class="info-title">Event</p>
                    <p id="fest-type"> - </p>
                </div>
                <div class="info">
                    <p class="info-title">Dato</p>
                    <p id="fest-dato"> - </p>
                </div>
                <div class="info">
                    <p class="info-title">Pris</p>
                    <div id="pris_kasse">
                        <p id="pris">-</p>
                        <p id="sale"></p>
                    </div>

                </div>
                <div class="info">
                    <a class="btn" href="billet">Køb</a>
                </div>
            </div>
            <p id="tid-tilbage"></p>
        </div>


        <div id="img"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/index.js"></script>
</body>