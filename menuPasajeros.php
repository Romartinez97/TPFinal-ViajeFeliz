<?php

include_once("Funciones.php");
include_once("clasePasajero.php");

function menuPasajeros()
{
    echo "\n----------MENÚ DE PASAJEROS----------\n";
    echo "\n 1) Agregar un pasajero a un vuelo.";
    echo "\n 2) Modificar información de un pasajero.";
    echo "\n 3) Ver lista de todos los pasajeros registrados.";
    echo "\n 4) Eliminar un pasajero.";
    echo "\n 5) Volver al menú principal.";

    $opcionElegida = validarOpcion(5);

    switch ($opcionElegida) {
        case 1:
            //Agregar un pasajero
            //Primero listo y muestro los viajes disponibles
            echo "\n-----LISTA DE VIAJES-----";
            $viaje = new Viaje();
            $listaViajes = $viaje->listar();
            for ($i = 1; $i < count($listaViajes); $i++) {
                echo $listaViajes[$i];
            }
            echo "\nIndique el número de viaje en el cual desea ingresar al pasajero: ";
            $idViaje = esNumero();
            $viajeEncontrado = $viaje->buscar($idViaje);
            while (!$viajeEncontrado) {
                echo "\nEl número ingresado no pertenece ninguno de los vuelos registrados. Intente nuevamente. ";
                $idViaje = esNumero();
                $viajeEncontrado = $viaje->buscar($idViaje);
            }
            echo "\nIndique el número de documento del pasajero a agregar: ";
            $pDocumento = esNumero();
            //Reviso si existe un pasajero con ese número de documento
            $pasajero = new Pasajero();
            $existePasajero = $pasajero->buscar($pDocumento);
            while ($existePasajero) {
                echo "\nYa hay un pasajero con ese número de documento registrado, intente nuevamente.";
                echo "\nIndique el número de documento del pasajero a agregar: ";
                $pDocumento = esNumero();
                $pasajero->buscar($pDocumento);
            }
            echo "\nIndique el nombre del pasajero: ";
            $pNombre = esString();
            echo "\nIndique el apellido del pasajero: ";
            $pApellido = esString();
            echo "\nIndique el teléfono del pasajero: ";
            $pTelefono = esNumero();
            //Cargo y e inserto al pasajero
            $pasajero->cargar($pDocumento, $pNombre, $pApellido, $pTelefono, $idViaje);
            $pasajero->insertar();
            echo "\n.Se creó correctamente al nuevo pasajero.";
            echo "\n" . $pasajero;
            break;

        case 2:
            //Modificar información de un pasajero
            $pasajero = new Pasajero();
            $listaPasajeros = $pasajero->listar();
            for ($i = 1; $i < count($listaPasajeros); $i++) {
                echo $listaPasajeros[$i];
            }
            echo "\nIndique el número de documento del pasajero que desea modificar: ";
            $pDocumento = esNumero();
            //Reviso si el pasajero existe
            $pasajeroEncontrado = $pasajero->buscar($pDocumento);
            while (!$pasajeroEncontrado) {
                echo "\nEl número ingresado no pertenece al documento de ninguno de los pasajeros registrados. Intente nuevamente. ";
                $pDocumento = esNumero();
                $pasajeroEncontrado = $pasajero->buscar($pDocumento);
            }
            echo "\n" . $pasajero;

            //Menú para modificar al pasajero encontrado
            echo "\n----------MODIFICACIÓN DE PASAJERO----------\n";
            echo "\n 1) Modificar el nombre.";
            echo "\n 2) Modificar el apellido.";
            echo "\n 3) Modificar el teléfono.";
            echo "\n 4) Cambiar al pasajero de viaje.";
            echo "\n 5) Volver al menú anterior.";
            $opcionElegida = validarOpcion(5);

            switch ($opcionElegida) {

                case 1:
                    //Modificar el nombre
                    echo "\nIngrese el nuevo nombre del pasajero: ";
                    $pNombreNuevo = esString();
                    $pasajero->setpNombre($pNombreNuevo);
                    $pasajero->modificar();
                    echo "\nEl nuevo nombre del pasajero es '" . $pasajero->getpNombre() . "'.";
                    break;

                case 2:
                    //Modificar el apellido
                    echo "\nIngrese el nuevo apellido del pasajero: ";
                    $pApellidoNuevo = esString();
                    $pasajero->setpApellido($pApellidoNuevo);
                    $pasajero->modificar();
                    echo "\nEl nuevo apellido del pasajero es '" . $pasajero->getpApellido() . "'.";
                    break;

                case 3:
                    //Modificar el número de teléfono
                    echo "\nIngrese el nuevo número de teléfono del pasajero: ";
                    $pTelefonoNuevo = esNumero();
                    $pasajero->setpTelefono($pTelefonoNuevo);
                    $pasajero->modificar();
                    echo "\nEl nuevo número de teléfono del pasajero es '" . $pasajero->getpTelefono() . "'.";
                    break;

                case 4:
                    //Modificar el vuelo al que está asociado el pasajero
                    echo "\n-----LISTA DE VIAJES-----";
                    $viaje = new Viaje();
                    $listaViajes = $viaje->listar();
                    for ($i = 1; $i < count($listaViajes); $i++) {
                        echo $listaViajes[$i];
                    }
                    echo "\nIndique el número de viaje en el cual desea ingresar al pasajero: ";
                    $idViaje = esNumero();
                    $viajeEncontrado = $viaje->buscar($idViaje);
                    while (!$viajeEncontrado) {
                        echo "\nEl número ingresado no pertenece ninguno de los vuelos registrados. Intente nuevamente. ";
                        $idViaje = esNumero();
                        $viajeEncontrado = $viaje->buscar($idViaje);
                    }
                    $pasajero->setIDViaje($idViaje);
                    $pasajero->modificar();
                    echo "\nEl pasajero ahora se encuentra registrado en el viaje N° '" . $pasajero->getIDViaje() . "'.";
                    break;

                default:
                    break;
            }

        case 3:
            //Ver lista de todos los pasajeros registrados
            $pasajero = new Pasajero();
            $listaPasajeros = $pasajero->listar();
            for ($i = 0; $i < count($listaPasajeros); $i++) {
                echo "\n" . $listaPasajeros[$i];
            }
            break;

        case 4:
            //Eliminar un pasajero
            $pasajero = new Pasajero();
            $listaPasajeros = $pasajero->listar();
            for ($i = 0; $i < count($listaPasajeros); $i++) {
                echo "\n" . $listaPasajeros[$i];
            }
            echo "\nIngrese el número de documento del pasajero que desea eliminar: ";
            $pDocumento = esNumero();
            //Reviso si existe un pasajero con ese número de documento
            $pasajero = new Pasajero();
            $pasajeroEncontrado = $pasajero->buscar($pDocumento);
            while (!$pasajeroEncontrado) {
                echo "\nEl número ingresado no pertenece al documento de ninguno de los pasajeros registrados. Intente nuevamente. ";
                $pDocumento = esNumero();
                $pasajeroEncontrado = $pasajero->buscar($pDocumento);
            }
            echo "\n" . $pasajero;
            echo "\n¿Desea eliminar a este pasajero? (S/N): ";
            $respuesta = esString();
            $respuesta = strtolower($respuesta);
            while ($respuesta != "s" && $respuesta != "n") {
                echo "\nRespuesta no válida. Indique si desea (S) o no (N) eliminar al responsable: ";
                $respuesta = trim(fgets(STDIN));
                $respuesta = strtolower($respuesta);
            }
            if ($respuesta == "s") {
                $pasajero->eliminar();
                echo "\nSe ha eliminado correctamente al pasajero.";
            }
            echo "\nVolviendo al menú anterior...";
            break;

        default:
            break;
    }
}