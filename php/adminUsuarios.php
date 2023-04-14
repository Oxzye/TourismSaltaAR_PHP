<?php
    session_start();
    include_once "conexion.php";
    
    class Admin extends Conexion{

        public function getUsuario($id)
        {
            $sentencia = $this->conectar()->prepare('SELECT * FROM usuarios WHERE usuario_id = ?;');
            $sentencia->execute(array($id));
            $datos = $sentencia->fetch(PDO::FETCH_OBJ);
            //print_r($datos);
            return $datos;
        }

        public function modificarUsuario($nombre, $contra, $email, $rol, $idactual)
        {
            $contra = md5($contra);

            $sentencia = $this->conectar()->prepare('UPDATE usuarios SET usuario_nomid = ?, usuario_contra = ?, usuario_email = ?, usuario_rol = ? WHERE usuario_id = ?;');
            $sentencia->execute(array($nombre, $contra, $email, $rol, $idactual));
            header('location: ../plataformaEmpleados/adminUsuarios.php?modificacion=correcta');
        }

        public function eliminarUsuario($id)
        {
            //elimina el usuario por id
            $sentencia = $this->conectar()->prepare('DELETE FROM usuarios WHERE usuario_id = ?;');
            $sentencia->execute(array($id));

            //guardar registro de eliminacion
            

            header('location: ../plataformaEmpleados/adminUsuarios.php?borrar=correcto');
        }

        public function setUsuario($nombre, $contra, $email, $rol)
        {

            $contra = md5($contra);
            $sentencia = $this->conectar()->prepare('INSERT INTO usuarios(usuario_nomid, usuario_contra, usuario_email, usuario_rol) VALUES(?, ?, ?, ?);');
            $sentencia->execute(array($nombre, $contra, $email, $rol));
            header('location: ../plataformaEmpleados/adminUsuarios.php?create=correcto');
        }

        public function comprobar($nombre)
        {
            $usuario = $this->conectar()->prepare('SELECT usuario_nomid FROM usuarios WHERE usuario_nomid = ?');
            $usuario->execute(array($nombre));
            $datos = $usuario->fetchAll(PDO::FETCH_ASSOC);
            if (sizeof($datos) == 0) {
                return true;
            } elseif (sizeof($datos) != 0) {
                return false;
        }
        }





        //paquetes
        public function eliminarpaquete($id)
        {
            //elimina el usuario por id
            $sentencia = $this->conectar()->prepare('DELETE FROM paquetes_viajes where id_paq = ?;');
            $sentencia->execute(array($id));

            //guardar registro de eliminacion
            

            header('location: ../plataformaEmpleados/paqueteEmpresa.php?borrar=correcto');
        }
        public function setpaquete($idpaq, $itine, $hotel, $rest,$exc,$dest)
        {
            $paq = $this->conectar()->prepare('INSERT INTO paquetes_viajes(id_paq, itinerarios) VALUES(?, ?);');
            $paq->execute(array($idpaq, $itine));

            $hxp = $this->conectar()->prepare('INSERT INTO hotxpaq(id_paq, id_hotel) VALUES(?, ?);');
            $hxp->execute(array($idpaq, $hotel));

            $rxp = $this->conectar()->prepare('INSERT INTO restxpaq(id_paq, id_rest) VALUES(?, ?);');
            $rxp->execute(array($idpaq, $rest));

            $exp = $this->conectar()->prepare('INSERT INTO excxpaq(id_exc, id_paq) VALUES(?, ?);');
            $exp->execute(array($exc, $idpaq));

            $dxp = $this->conectar()->prepare('INSERT INTO destxpaq(id_paq, id_dest) VALUES(?, ?);');
            $dxp->execute(array($idpaq, $dest));
            header('location: ../plataformaEmpleados/paquetesEmpresa.php?create=correcto');
        }

        public function modfPaquete($itine, $hotel, $rest, $exc, $dest, $idpaq, $idact, $restact, $hotact, $excact, $destact)
        {
            $paq = $this->conectar()->prepare ('UPDATE paquetes_viajes SET itinerarios = ? WHERE paquetes_viajes.id_paq = ?;');
            $paq->execute(array($itine, $idact));

            $hxp = $this->conectar()->prepare('UPDATE hotxpaq SET  id_hotel = ? WHERE id_paq = ? AND id_hotel = ?;');
            $hxp->execute(array($hotel, $idact, $hotact));

            $rxp = $this->conectar()->prepare('UPDATE restxpaq SET  id_rest = ? WHERE id_paq = ? AND id_rest = ?;');
            $rxp->execute(array($rest, $idact, $restact));

            $exp = $this->conectar()->prepare('UPDATE excxpaq SET id_exc = ? WHERE id_paq = ? AND id_exc = ?;');
            $exp->execute(array($exc, $idact, $excact));

            $dxp = $this->conectar()->prepare('UPDATE destxpaq SET id_dest = ? WHERE id_paq = ? AND id_dest = ?;');
            $dxp->execute(array($dest, $idact, $destact));

            /*echo "itinerario nuevo = $itine 
            ,hotelnvo =  $hotel
            ,restnuevo =  $rest
            ,excnvo = $exc
            ,destnvo = $dest
            ,idpaq = $idpaq
            ,idpaq2 = $idact
            ,restact = $restact
            ,hotact = $hotact
            ,excact = $excact
            ,destact = $destact";*/
            header('location: ../plataformaEmpleados/paquetesEmpresa.php?EDIT=correcto');
        }
        public function comprobarid($id)
        {
        
        $paquetes = $this->conectar()->prepare('SELECT id_paq FROM paquetes_viajes WHERE id_paq = ?');
        $paquetes->execute(array($id));
        $datos = $paquetes->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($datos) == 0) {
            return true;
        } elseif (sizeof($datos) != 0) {
            return false;
        }
        } 
        public function idcero($id)
        {
            if($id==0)
            {
                $paquetes = $this->conectar()->query('SELECT MAX(id_paq) FROM paquetes_viajes');
                $dato = $paquetes->fetchAll(PDO::FETCH_OBJ);
                foreach ($dato as $datos) {
                $id=$datos->$id_paq +1;
            }
            return $id;     
            }
        }
    }


    //crear modificar, eliminar usuarios

    if (isset($_SESSION['rol']) == 3) {

        if (isset($_POST['setUsuario'])){

            $nombre = $_POST['nombre'];
            $contra = $_POST['contraseña'];
            $email = $_POST['email'];
            $rol = $_POST['rol'];

            $crear = new Admin();

            if ($crear->comprobar($nombre) == true){

                $crear->setUsuario($nombre, $contra, $email, $rol);
            }else {
               header('location: ../plataformaEmpleados/adminUsuarios.php?crear=nombreExistente');
            }

            

        }else if (isset($_POST['modfUsuario'])){
            
            $nombre = $_POST['nombre'];
            $contra = $_POST['contraseña'];
            $email = $_POST['email'];
            $rol = $_POST['rol'];
            $idactual = $_POST['idactual'];

            $editar = new Admin();
            if ($editar->comprobar($nombre) == true){

                $editar->modificarUsuario($nombre, $contra, $email, $rol, $idactual);

            }else {
                
                $nombre = $nombre.rand(1,9999);
                $editar->modificarUsuario($nombre, $contra, $email, $rol, $idactual);
            }
            
            
        }else if( isset($_GET["id"]) && (isset($_GET["desde"])) ){

            $eliminar = new Admin();
            $eliminar->eliminarUsuario($_GET["id"]);
            header('location: ../plataformaEmpleados/empleados.php?eliminado=correcto');
        }else if(isset($_GET["id"])){
             $eliminar = new Admin();
            $eliminar->eliminarUsuario($_GET["id"]);
            header('location: ../plataformaEmpleados/adminUsuarios.php?eliminado=correcto');
        }

    }else {
        echo "error no sos un administrador";
        }

    //crear eliminar, modificar paquetes
        
    if (isset($_POST['setpaquete'])){
        
        $idpaq = $_POST['idpaq'];
        $itine = $_POST['itinerario'];
        $hotel = $_POST['hotel'];
        $rest = $_POST['restaurante'];
        $exc = $_POST['excursion'];
        $dest = $_POST['destino'];
        $crear = new Admin();
        
        if($crear->comprobarid($idpaq) == true)
        {
        $crear->setpaquete($idpaq, $itine, $hotel, $rest,$exc,$dest);
        }
        // else if($idpaq==0)
        // {
        //    $idpaq = idcero($idpaq);
        //     $crear->setpaquete($idpaq, $itine, $hotel, $rest,$exc,$dest);
        //     header('location: ../plataformaEmpleados/paquetesEmpresa.php?create=incorrecto_idrepetido');    
        // }
        else
        {
            header('location: ../plataformaEmpleados/paquetesEmpresa.php?create=incorrecto_idrepetido'); 
        }
    
    }
        else if(isset($_GET["idp"])){
            $eliminar = new Admin();
           $eliminar->eliminarpaquete($_GET["idp"]);
           header('location: ../plataformaEmpleados/paquetesEmpresa.php?eliminado=correcto');
        }elseif (isset($_POST['modfpaquete'])){

            $idpaq = $_POST['idpaq'];
            $itine = $_POST['itinerario'];
            $hotel = $_POST['hotel'];
            $rest = $_POST['restaurante'];
            $exc = $_POST['excursion'];
            $dest = $_POST['destino'];
            $idact = $_POST['idactual'];
            $restact = $_POST['restact'];
            $hotact = $_POST['hotact'];
            $excact = $_POST['excact'];
            $desact = $_POST['desact'];
            $itiact = $_POST['itiact'];

            $crear = new Admin();
            $crear->modfpaquete($itine, $hotel, $rest, $exc, $dest, $idact, $idact, $restact, $hotact, $excact, $desact);
        }
    include_once ("guardar_registros.php");
?>