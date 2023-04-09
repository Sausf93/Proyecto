<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>BounceBall</title>
    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i"
          rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/one-page-wonder.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" media="screen" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/main.css"/>
    <script src="https://code.jquery.com/jquery-1.12.0.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!--<script src="../js/jquery-3.2.1.min.js"></script>-->
    <script src="../js/lib/phaser.js"></script>
    <script src="../js/Boot.js"></script>
    <script src="../js/Preloader.js"></script>
    <script src="../js/ScoreBoard.js"></script>
    <script src="../js/Instructions.js"></script>
    <script src="../js/Level1.js"></script>
    <script src="../js/Level2.js"></script>
    <script src="../js/Level3.js"></script>
    <script src="../js/Level4.js"></script>
    <script src="../js/MainMenu.js"></script>
    <script src="../js/main.js"></script>
</head>

<body>
<!-- Navigation -->
<br>

<form action="" method="POST">
            <input type="hidden" id="puntuacion" name="puntos" value="5000">
            <br>
            <p style="text-align: center;">
            <input type="submit" class="btn btn-primary" value="Atras" style="width: 210px;"></input>
            </p>
            </form>
            
<!-- <script src="../js/script.js"></script> -->
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../bundle.js"></script>
</body>


<?php
class DataSource {
    private $host = "localhost";
    // private $db = "id13243509_jsgame";
    // private $user = "id13243509_saulo";
    // private $password = "H>i5B{3O~zwq-xdj";
        private $db = "jsgame";
        private $user = "root";
        private $password = "";
    private $dbh;
    /**
    * Método getter que devuelve el atributo dbh
    */
    public function getDbh() {
        return $this->dbh;
    }
    /**
    * Método que abre una conexión sobre base de datos
    */
    public function openConnection() {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->db";
            $this->dbh = new PDO($dsn, $this->user, $this->password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
             echo $e->getMessage();
         }
     }
    /**
    * Método que cierra una conexión sobre base de datos
    */
    public function closeConnection() {
        $this->dbh = null;
    }
}

class Game{
    
    private $id;
    private $nombre;
    private $puntuacion;
    private $id_usuario;


    public function __construct( $nombre, $puntuacion, $id_usuario) {
        $this->nombre = $nombre;
        $this->puntuacion = $puntuacion;
        $this->id_usuario = $id_usuario;

        }
    function __get($get){
        return $this->$get;
    }

}

interface IGamesDAO
{

    public function selectGames();
    // public function insertUsuario($usuario);
}


class GamesDAO implements IGamesDAO{
    

    public function selectGames()
    {
        $ds = new DataSource();
        $ds->openConnection();
        $games = array();
        try {
            $idusuario = $_SESSION["iduser"];
            $dbh = $ds->getDbh();
            $stmt = $dbh->prepare("SELECT id, nombre, puntuacion, id_usuario FROM game WHERE id_usuario=".$idusuario);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $id = $row["id"];
                $nombre = $row["nombre"];
                $puntuacion = $row["puntuacion"];
                $id_usuario = $row["id_usuario"];
                $game = new Game($nombre, $puntuacion, $id_usuario);
                array_push($games, $game);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $ds->closeConnection();
        return $games;
    }

    public function insertGame($game)
    {
        //Falta la vista y implementar el metodo.
        $ds = new DataSource();
        $ds->openConnection();
        try {
            $dbh = $ds->getDbh();
            $stmt = $dbh->prepare("INSERT INTO game (nombre, puntuacion, id_usuario) VALUES (:nombre, :puntuacion, :id_usuario)");
            $nombre = $game->nombre;
            $puntuacion = $game->puntuacion;
            $id_usuario = $game->id_usuario;
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':puntuacion', $puntuacion);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
           } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $ds->closeConnection();
    }
}


if (isset($_POST["puntos"])){

    $puntos = $_POST["puntos"];
    $juego ="Bounceman";
    $iduser= $_SESSION["iduser"];
    $gameDao = new GamesDAO();
    $newgame = new Game($juego, $puntos, $iduser);
    $gameDao->insertGame($newgame);
    header("Location: ../../public_html/pagina-principal.php");
}

?>
</html>