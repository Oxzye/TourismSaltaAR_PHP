<?php
$marca = 'seleccionado';
?>

<head>
    <style>
        .pepe {
            color: white;
            display: flex;
        }

        .mainmenubtn {
            background-color: #2c3e50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 20px;

        }

        .mainmenubtn:hover {
            background-color: #2c3e50;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-child {
            display: none;
            background-color: #2c3e50;
            min-width: 200px;
        }

        .dropdown-child a {
            background-color: #2c3e50;
            padding: 20px;
            text-decoration: none;
            display: block;
            color: white;
        }

        .dropdown-child a:hover {
            background-color: #127b8e;
            transition: 500ms background-color;
        }


        .dropdown:hover .dropdown-child {
            display: block;
        }
    </style>
</head>
<header>
    <nav class="menu">
        <p class="pepe"><?php echo $bienvenida; ?></p>
        <div class="dropdown">

            <button class="mainmenubtn">Perfil usuario</button>
            <div class="dropdown-child">
                <li><a href="">Usuario: <?php echo $_SESSION['nombre']; ?></a></li>
                <li> <a href="">Rol: <?php if ($_SESSION['rol'] == 3) {
                                            echo "admin";
                                        } elseif ($_SESSION['rol'] == 2) {
                                            echo "empleado";
                                        } ?></a></li>
                <li><a href="">ID: <?php echo $_SESSION['id']; ?></a></li>
                <li><a href="../php/cerrarsession.php">Cerrar sesion</a></li>
                </ul>
            </div>
        </div>

    </nav>
</header>