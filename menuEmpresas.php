<?php

include_once("Funciones.php");
include_once("claseEmpresa.php");

function menuEmpresas()
{
    echo "\n----------MENÚ DE EMPRESAS----------\n";
    echo "\n 1) Agregar una empresa.";
    echo "\n 2) Modificar información de una empresa.";
    echo "\n 3) Ver lista de todas las empresas registradas.";
    echo "\n 4) Eliminar una empresa.";
    echo "\n 5) Volver al menú principal.";

    $opcionElegida = validarOpcion(5);

    switch ($opcionElegida) {
        case 1:
            //Agregar una empresa
            echo "\nIndique el nombre de la empresa que desea agregar: ";
            $nombreEmpresa = esString();
            //Reviso si ya existe una empresa con ese nombre
            $empresa = new Empresa();
            $listaEmpresas = $empresa->listar("enombre='" . $nombreEmpresa . "'");
            while (!empty($listaEmpresas)) {
                echo "\nYa existe una empresa con ese nombre, intente nuevamente.";
                echo "\nIndique el nombre de la empresa que desea agregar: ";
                $nombreEmpresa = esString();
                $listaEmpresas = $empresa->listar("enombre=" . $nombreEmpresa);
            }

            echo "\nIndique la dirección de la empresa: ";
            $direccionEmpresa = trim(fgets(STDIN));
            //Cargo y e inserto a la empresa
            $empresa->cargar("", $nombreEmpresa, $direccionEmpresa, []);
            $empresa->insertar();
            echo "\n.Se creó correctamente a la nueva empresa.";
            echo "\n" . $empresa;
            break;

        case 2:
            //Modificar información de una empresa
            $empresa = new Empresa();
            $listaEmpresas = $empresa->listar();
            for ($i = 1; $i < count($listaEmpresas); $i++) {
                echo $listaEmpresas[$i];
            }
            echo "\nIndique el número de la empresa que desea modificar: ";
            $idEmpresa = esNumero();
            //Reviso si la empresa existe
            $empresaEncontrada = $empresa->buscar($idEmpresa);
            while (!$empresaEncontrada) {
                echo "\nEl número ingresado no pertenece al ID de ninguna de las empresas registradas. Intente nuevamente. ";
                $idEmpresa = esNumero();
                $empresaEncontrada = $empresa->buscar($idEmpresa);
            }
            echo "\n" . $empresa;

            //Menú para modificar a la empresa encontrada
            echo "\n----------MODIFICACIÓN DE EMPRESA----------\n";
            echo "\n 1) Modificar el nombre.";
            echo "\n 2) Modificar la dirección.";
            echo "\n 3) Volver al menú anterior.";
            $opcionElegida = validarOpcion(3);

            switch ($opcionElegida) {

                case 1:
                    //Modificar el nombre
                    echo "\nIngrese el nuevo nombre de la empresa: ";
                    $eNombreNuevo = esString();
                    //Reviso si ya existe una empresa con ese nombre
                    $listaEmpresas = $empresa->listar("enombre='" . $eNombreNuevo . "'");
                    while (!empty($listaResponsables)) {
                        echo "\nYa existe una empresa con ese nombre, intente nuevamente.";
                        echo "\nIndique el nombre de la empresa que desea agregar: ";
                        $eNombreNuevo = esString();
                        $listaEmpresas = $empresa->listar("enombre=" . $eNombreNuevo);
                    }
                    $empresa->seteNombre($eNombreNuevo);
                    $empresa->modificar();
                    echo "\nEl nuevo nombre de la empresa es '" . $empresa->geteNombre() . "'.";
                    break;

                case 2:
                    //Modificar la direccion
                    echo "\nIngrese la nueva dirección de la empresa: ";
                    $eDireccionNueva = esString();
                    $empresa->seteDireccion($eDireccionNueva);
                    $empresa->modificar();
                    echo "\nLa nueva dirección de la empresa es '" . $empresa->geteDireccion() . "'.";
                    break;

                default:
                    break;
            }

        case 3:
            //Ver lista de todas las empresas registradas
            $empresa = new Empresa();
            $listaEmpresas = $empresa->listar();
            for ($i = 0; $i < count($listaEmpresas); $i++) {
                echo "\n" . $listaEmpresas[$i];
            }
            break;

        case 4:
            //Eliminar una empresa
            $empresa = new Empresa();
            $listaEmpresas = $empresa->listar();
            for ($i = 0; $i < count($listaEmpresas); $i++) {
                echo "\n" . $listaEmpresas[$i];
            }
            echo "\nIngrese el número de la empresa que desea eliminar: ";
            $idEmpresa = esNumero();
            //Reviso si existe una empresa con ese número de ID
            $empresaEncontrada = $empresa->buscar($idEmpresa);
            while (!$empresaEncontrada) {
                echo "\nEl número ingresado no pertenece al ID de ninguna de las empresas registradas. Intente nuevamente. ";
                $idEmpresa = esNumero();
                $empresaEncontrada = $empresa->buscar($idEmpresa);
            }
            echo "\n" . $empresa;
            echo "\n¿Desea eliminar a esta empresa? Se eliminaran TODOS los datos asociadas a la misma (viajes y pasajeros) (S/N): ";
            $respuesta = trim(fgets(STDIN));
            $respuesta = strtolower($respuesta);
            while ($respuesta != "s" && $respuesta != "n") {
                echo "\nIndique si desea (S) o no (N) eliminar la empresa: ";
                $respuesta = trim(fgets(STDIN));
                $respuesta = strtolower($respuesta);
            }
            if ($respuesta == "s") {
                //Conseguir ID de todos los viajes de la empresa
                $viaje = new Viaje();
                $coleccionViajes = $viaje->listar("idempresa=" . $idEmpresa);
                for ($i = 0; $i < count($coleccionViajes); $i++) {
                    $unViaje = $coleccionViajes[$i];
                    $unID = $unViaje->getIDViaje();
                    $pasajero = new Pasajero();
                    $coleccionPasajeros = $pasajero->listar("idviaje=" . $unID);
                    for ($j = 0; $j < count($coleccionPasajeros); $j++) {
                        $unPasajero = $coleccionPasajeros[$j];
                        $unPasajero->eliminar();
                    }
                    $unViaje->eliminar();
                }
                $empresa->eliminar();
                echo "\nLa empresa ha sido eliminada.";
            }
            echo "\nVolviendo al menú anterior...";
            break;

        default:
            break;
    }
}