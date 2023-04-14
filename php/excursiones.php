<?php
session_start();
include_once("conexion.php");

class excursiones extends Conexion{

    public function setExc($dest_ini, $dest_fin, $ubi, $duracion, $tipoexc, $min, $max)
    {
        $excursion = $this->conectar()->prepare('INSERT INTO excursiones(Destino_inicial, Destino_final, ubicacion, duracion, tipo_exc, cant_min, cant_max) VALUES(?, ?, ?, ?, ?, ?, ?);');
        $excursion->execute(array($dest_ini, $dest_fin, $ubi, $duracion, $tipoexc, $min, $max));

        header('location: ../plataformaEmpleados/excursionesEmpresa.php?create=correcto');
    }

    public function eliminarExc($id)
    {
        $excursion = $this->conectar()->prepare('DELETE FROM excursiones where id_excursion = ?;');
        $excursion->execute(array($id));

        header('location: ../plataformaEmpleados/excursionesEmpresa.php?borrar=correcto');
    }

    public function modfExc($dest_ini, $dest_fin, $ubi, $duracion, $tipoexc, $min, $max, $id)
    {

        $excursion = $this->conectar()->prepare('UPDATE excursiones SET Destino_inicial = ?, Destino_final = ?, ubicacion = ?,duracion = ?, tipo_exc = ?, cant_min = ?, cant_max = ? WHERE id_excursion = ?;');
        $excursion->execute(array($dest_ini, $dest_fin, $ubi, $duracion, $tipoexc, $min, $max, $id));
        header('location: ../plataformaEmpleados/excursionesEmpresa.php?modif=correcto');
    }

    public function comprobar($dest_ini, $dest_fin)
    {
        $excursion = $this->conectar()->prepare('SELECT Destino_inicial,Destino_final FROM excursiones WHERE Destino_inicial = ? AND Destino_final = ? ');
        $excursion->execute(array($dest_ini, $dest_fin));
        $datos = $excursion->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($datos) == 0) {
            return true;
        } elseif (sizeof($datos) != 0) {
            return false;
        }
    }
}
//
    //$exc = new excursiones();
    //$exc->setExc('Monumento güemes','dique cabra corral', 1, 120, 103, 2, 45);
    //$exc->modfExc('Monumento güemes','dique cabra corral', 1, 60, 103, 5, 45,6);
    //$exc->eliminarExc(5);
//

        if (isset($_POST['ingresarExc'])) {
            
            $dest_ini = $_POST['dest_ini'];
            $dest_fin = $_POST['dest_fin'];
            $ubi = $_POST['ubicacion'];
            $duracion = $_POST['duracion'];
            $tipo_exc = $_POST['tipo_exc'];
            $min = $_POST['min'];
            $max = $_POST['max'];

            $nuevoExc = new excursiones();

            if ($nuevoExc->comprobar($dest_ini, $dest_fin) == true){
                
            $nuevoExc->setExc($dest_ini, $dest_fin, $ubi, $duracion, $tipo_exc, $min, $max);
            }else {
               header('location: ../plataformaEmpleados/excursionesEmpresa.php?crear=direccionExistente');
            }
        }elseif (isset($_GET["id"])){
            $elimExc = new excursiones();
            $elimExc->eliminarExc($_GET["id"]);
            header('location: ../plataformaEmpleados/excursionesEmpresa.php?eliminar=correcto');

        }elseif (isset($_POST["modfExc"])){
            
            $id = $_POST["id"];
            $dest_ini = $_POST['dest_ini'];
            $dest_fin = $_POST['dest_fin'];
            $ubi = $_POST['ubicacion'];
            $duracion = $_POST['duracion'];
            $tipo_exc = $_POST['tipo_exc'];
            $min = $_POST['min'];
            $max = $_POST['max'];

            $modfExc = new excursiones();
            $modfExc->modfExc($dest_ini, $dest_fin, $ubi, $duracion, $tipo_exc, $min, $max, $id);
        }