<?php
session_start();
include_once("conexion.php");

class destinos extends Conexion
{

    public function setdest($ubi, $temporada, $descrip)
    {
        $dest = $this->conectar()->prepare('INSERT INTO destinos( ubicacion, Temporada, clasificacion) VALUES(?, ?, ?);');
        $dest->execute(array( $ubi, $temporada, $descrip));

        //echo " $ubi, $temporada, $descrip";
        header('location: ../plataformaEmpleados/destinos.php?create=correcto');
    }

    public function eliminardest($id)
    {
        $dest = $this->conectar()->prepare('DELETE FROM destinos where id_dest = ?;');
        $dest->execute(array($id));

        header('location: ../plataformaEmpleados/destinos.php?borrar=correcto');
    }

    public function modfdest($ubi, $temporada, $descrip, $id)
    {

        $dest = $this->conectar()->prepare('UPDATE destinos SET ubicacion = ?, Temporada = ?, clasificacion = ? WHERE id_dest = ?;');
        $dest->execute(array($ubi, $temporada, $descrip, $id));
        header('location: ../plataformaEmpleados/destinos.php?modif=correcto');
    }

    public function comprobar($ubi, $temporada)
    {
        $dest = $this->conectar()->prepare('SELECT ubicacion, Temporada FROM destinos WHERE ubicacion = ? AND Temporada = ?');
        $dest->execute(array($ubi, $temporada));
        $datos = $dest->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($datos) == 0) {
            return true;
        } elseif (sizeof($datos) != 0) {
            return false;
        }
    }
}

//
//
    if (isset($_POST['ingresardest'])) {
            
            $id = $_POST['id'];
            $ubi = $_POST['ubicacion'];
            $temp = $_POST['temporada'];
            $descrip = $_POST['descrip'];

            $nuevodest = new destinos();

            if ($nuevodest->comprobar($ubi, $temp) == true){

                $nuevodest->setdest($ubi, $temp, $descrip);
            }else {
               header('location: ../plataformaEmpleados/destinos.php?crear=destinoExistente');
            }

        }elseif (isset($_GET["id"])){
            $elimdest = new destinos();
            $elimdest->eliminardest($_GET["id"]);
            header('location: ../plataformaEmpleados/destinos.php?eliminar=correcto');

        }elseif (isset($_POST["modfdest"])){
            
            $id = $_POST['id'];
            $ubi = $_POST['ubi'];
            $temp = $_POST['temporada'];
            $descrip = $_POST['descrip'];


            $modfdest = new destinos();
            $modfdest->modfdest($ubi, $temp, $descrip, $id);
        }