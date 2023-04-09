<?php
session_start();
?>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="shortcut icon" type="image/gif" href="./images/gengargif.gif" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="script.js"></script>
</head>

<body onload="cargar(16); inicio(); maxPuntuacion()">
    <div id="div1">
        <div class="container" id="contenedor">

        </div>
        <div id="Marcador">
            <h4>Máx. Puntuación: </h4>
            <h4 id="maxPuntos">0</h4>
            <br>
            <h4>Partidas jugadas: </h4>
            <h4 id="numPartidas">0</h4>
            <br>
            <div id="tiempo">
                <div class="reloj" id="Minutos">00</div>
                <div class="reloj" id="Segundos">:00</div>
                <div class="reloj" id="Centesimas">:00</div>
            </div>
            <form action="" method="POST">
            <input type="hidden" id="puntuacion" name="puntos" value="1000">
            <br>
            <input type="submit" class="btn btn-primary" class="btn btn-danger" value="Atras" style="width: 210px;"></input>
            </form>
        </div>

    </div>

    <?php

if (isset($_POST["puntos"])){

    require '../DAO/GamesDAO.php';
    require_once '../Modelos/Game.php';
    $puntos = $_POST["puntos"];
    $juego ="pokemon modo facil";
    $iduser= $_SESSION["iduser"];
    $gameDao = new GamesDAO();
    $newgame = new Game($juego, $puntos, $iduser);
    $gameDao->insertGame($newgame);
    header("Location: ../public_html/pagina-principal.php");

}

?>

</body>
</html>