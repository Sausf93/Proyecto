<?php
session_start();
?>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="shortcut icon" type="image/gif" href="./images/gengargif.gif" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="script.js"></script>
</head>

<body onload="cargar(64); inicio(); maxPuntuacion()">
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
            <h2>Puntuación:</h2>
            <input type="hidden" id="puntuacion" name="puntos" value="4000">
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
    $juego ="pokemon modo dificil";
    $iduser= $_SESSION["iduser"];
    $gameDao = new GamesDAO();
    $newgame = new Game($juego, $puntos, $iduser);
    $gameDao->insertGame($newgame);
    header("Location: ../public_html/pagina-principal.php");

}

?>
</body>

</html>