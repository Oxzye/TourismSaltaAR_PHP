<?php
    /*
    CREATE TABLE usuarios(
    usuario_id int(11) AUTO_INCREMENT,
    usuario_nomid varchar(16) not null,
    usuario_contra varchar(200) not null,
    usuario_email varchar(50) not null,
    usuario_rol varchar(20) DEFAULT 'cliente',
    PRIMARY KEY(usuario_id)
    );
    */

    class Conexion {

        public function conectar(){

            try {
                $nombreBD = "turismoatr";
                $usuario = "root";
                $contrasena = "12345678";

                $conexion = new PDO('mysql:host=localhost;dbname='.$nombreBD, $usuario, $contrasena);
                
                //echo "u are conected macaquinho kkkkk";
                //print_r($conexion);
                return $conexion;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    //$con = new Conexion();
    //$con->conectar();

    //print_r($con);
?>