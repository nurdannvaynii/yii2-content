<!DOCTYPE html>

<html lang="tr">

<head>
    <title>SoilGeoteknik</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="styles/lightslider.css">
    <link rel="stylesheet" href="styles/general.css">
    <link href="https://fonts.googleapis.com/css?family=Oregano" rel="stylesheet">
</head>

<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/files/lightslider.js"></script>

<div style="background:#0277bd;">
    <div class="container">
        <div style="padding:3px 0px;">
            <div class="row v-center">
                <div class="col-sm-3 col-xs-12" style="text-align:center;">
                    <a href="index.php">
                        <img src="images/logo.png" style="width:70%;max-width:170px;height: 80px;-webkit-filter: saturate(7); filter: saturate(7);">
                    </a>
                </div>
                <div class="col-sm-9 hidden-xs v-center" style=" width:1500px;height:90px;">
                    <ul class="nav nav-justified">
                        <li>
                            <a href="index.php">Ana Sayfa</a>
                        </li>
                        <li>
                            <a href="about.php">Hakkımızda</a>
                        </li>

                        <li>
                            <a href="activity.php">Faaliyet Alanları</a>
                        </li>

                        <li>
                            <a href="reference.php">Referanslar</a>
                        </li>
                        <li>
                            <a href="geoteknik.php">Geotekniğe Dair</a>
                        </li>

                        <li>
                            <a href="contact.php">İletişim</a>
                        </li>
                    </ul>
                </div>
                <button class="btn" style="padding:0px;" onclick="toogleLanguage('tr')"> <img src="images/tr.png" height="25px;" width="35px;"/> </button>
                <button class="btn" style="padding:0px;" onclick="toogleLanguage('en')"> <img src="images/en.png" height="25px;" width="35px;"/> </button>
            </div>
        </div>
        <div class="hidden-lg hidden-md hidden-sm" style="margin-bottom:10px;">
            <div class="dropdown">
                <button class="btn btn-default btn-block dropdown-toggle" style="text-align:left;" type="button" data-toggle="dropdown">
                    <i class="fa fa-bars fa-fw" aria-hidden="true"></i> Site Menüsü </button>
                <ul class="dropdown-menu" style="width:100%">
                    <li>
                        <a href="index.php">Ana Sayfa</a>
                    </li>

                    <li>
                        <a href="about.php">Hakkımızda</a>
                    </li>

                    <li>
                        <a href="activity.php">Faaliyet Alanları</a>
                    </li>

                    <li>
                        <a href="reference.php">Referanslar</a>
                    </li>

                    <li>
                        <a href="reference.php">Geotekniğe Dair</a>
                    </li>

                    <li>
                        <a href="contact.php">İletişim</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>