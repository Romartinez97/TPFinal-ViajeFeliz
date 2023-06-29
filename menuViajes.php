<?php

include_once("Funciones.php");
include_once("claseViaje.php");

function menuViajes()
{
    echo "\n----------MENÚ DE VIAJES----------\n";
    echo "\n 1) Agregar un viaje.";
    echo "\n 2) Modificar información de un viaje.";
    echo "\n 3) Ver lista de todos los viajes registrados por empresa.";
    echo "\n 4) Eliminar un viaje.";
    echo "\n 5) Volver al menú principal.";

    $opcionElegida = validarOpcion(5);

    switch ($opcionElegida) {
        case 1:
            //Agregar un viaje

            echo "\nIndique el destino del viaje: ";
            $vDestino = esString();
            echo "\nIndique la cantidad máxima de pasajeros del viaje: ";
            $vCantMaxPasajeros = esNumero();
            echo "\nIndique el importe del viaje: ";
            $vImporte = esNumero();
            echo "\n¿Desea asignar un responsable ya existente (opción 1) o agregar a uno nuevo (opcion 2)? (Ingrese el número de la opcion) ";
            $opcionElegida = validarOpcion(5);
            switch ($opcionElegida) {
                case 1:
                    //Asignar responsable ya existente
                    //Muestro los responsables que ya están registrados
                    echo "\n-----LISTA DE RESPONSABLES-----";
                    $responsable = new ResponsableV();
                    $listaResponsables = $responsable->listar();
                    for ($i = 0; $i < count($listaResponsables); $i++) {
                        echo $listaResponsables[$i];
                    }
                    echo "\nIngrese el número del responsable que desea asignar al viaje: ";
                    $idEmpleado = esNumero();
                    //Reviso si el empleado existe       
                    $empleadoEncontrado = $responsable->buscar($idEmpleado);
                    while (!$empleadoEncontrado) {
                        echo "\nEl número ingresado no pertenece al número de empleado de ninguno de los responsables existentes en la empresa.
            Intente nuevamente. ";
                        $idEmpleado = esNumero();
                        $empleadoEncontrado = $responsable->buscar($idEmpleado);
                    }
                    break;

                case 2:
                    //Crear un responsable y asignarlo
                    echo "\nIndique el número de licencia del responsable a crear: ";
                    $rNumeroLicencia = esNumero();
                    //Reviso si no existe un responsable con ese número de licencia
                    $responsable = new ResponsableV();
                    $listaResponsables = $responsable->listar("rnumerolicencia=" . $rNumeroLicencia);
                    while (!empty($listaResponsables)) {
                        echo "\nYa existe un responsable con ese número de licencia, intente nuevamente.";
                        echo "\nIndique el número de licencia del responsable: ";
                        $rNumeroLicencia = esNumero();
                        $listaResponsables = $responsable->listar("rnumerolicencia=" . $rNumeroLicencia);
                    }
                    echo "\nIndique el nombre del responsable: ";
                    $rNombre = esString();
                    echo "\nIndique el apellido del responsable: ";
                    $rApellido = esString();
                    //Cargo y e inserto al responsable
                    $responsable->cargar("", $rNumeroLicencia, $rNombre, $rApellido);
                    $responsable->insertar();
                    echo "\n.Se creó correctamente al nuevo responsable.";
                    echo "\n" . $responsable;
                    break;
            }
            //Muestro la lista de empresas
            echo "\n-----LISTA DE EMPRESAS-----";
            $empresa = new Empresa();
            $listaEmpresas = $empresa->listar();
            for ($i = 1; $i < count($listaEmpresas); $i++) {
                echo $listaEmpresas[$i]; //No está mostrando las empresas
            }
            echo "\n¿A qué empresa desea asignar el viaje? Ingrese el ID de la misma: ";
            $idEmpresa = esNumero();
            //Reviso si existe una empresa con ese número de ID
            $empresaEncontrada = $empresa->buscar($idEmpresa);
            while (!$empresaEncontrada) {
                echo "\nEl número ingresado no pertenece al ID de ninguna de las empresas registradas. Intente nuevamente. ";
                $idEmpresa = esNumero();
                $empresaEncontrada = $empresa->buscar($idEmpresa);
            }
            //Cargo y e inserto al pasajero
            $viaje = new Viaje();
            $viaje->cargar("",$vDestino, $vCantMaxPasajeros, $empresa, $responsable, $vImporte, []);
            $viaje->insertar();
            echo "\nSe creó correctamente el nuevo viaje.";
            echo "\n" . $viaje;
            break;

        case 2:
            //Modificar información de un viaje
            $viaje = new Viaje();
            $listaViajes = $viaje->listar();
            for ($i = 1; $i < count($listaViajes); $i++) {
                echo $listaViajes[$i];
            }
            echo "\nIndique el número del viaje que desea modificar: ";
            $idViaje = esNumero();
            //Reviso si el viaje existe
            $viajeEncontrado = $viaje->buscar($idViaje);
            while (!$viajeEncontrado) {
                echo "\nEl número ingresado no pertenece al ID de ninguno de los viajes registrados. Intente nuevamente. ";
                $idViaje = esNumero();
                $viajeEncontrado = $viaje->buscar($idViaje);
            }
            echo "\n" . $viaje;

            //Menú para modificar al viaje encontrado
            echo "\n----------MODIFICACIÓN DE VIAJE----------\n";
            echo "\n 1) Modificar el destino.";
            echo "\n 2) Modificar la cantidad máxima de pasajeros.";
            echo "\n 3) Modificar el importe del viaje.";
            echo "\n 4) Cambiar al responsable a cargo del viaje.";
            echo "\n 5) Cambiar la empresa a cargo del viaje.";
            echo "\n 6) Volver al menú anterior.";
            $opcionElegida = validarOpcion(6);

            switch ($opcionElegida) {

                case 1:
                    //Modificar el destino
                    echo "\Ingrese el nuevo destino del viaje: ";
                    $destinoNuevo = esString();
                    $viaje->setvDestino($destinoNuevo);
                    $viaje->modificar();
                    echo "\nEl nuevo destino del viaje es '" . $viaje->getvDestino() . "'.";
                    break;

                case 2:
                    //Modificar la cantidad máxima de pasajeros
                    echo "\Ingrese la nueva cantidad máxima de pasajeros: ";
                    $cantMaxPasajerosNuevo = esNumero();
                    $viaje->setvCantMaxPasajeros($cantMaxPasajerosNuevo);
                    $viaje->modificar();
                    echo "\nLa nueva cantidad máxima de pasajeros del viaje es de '" . $viaje->getvCantMaxPasajeros() . "' pasajeros.";
                    break;

                case 3:
                    //Modificar el importe del viaje
                    echo "\Ingrese el nuevo importe del viaje: ";
                    $importeNuevo = esNumero();
                    $viaje->setvImporte($importeNuevo);
                    $viaje->modificar();
                    echo "\nEl nuevo importe del viaje es de $'" . $viaje->getvImporte() . "'.";
                    break;

                case 4:
                    //Cambiar al responsable a cargo del viaje
                    echo "\n-----LISTA DE RESPONSABLES-----";
                    $responsable = new ResponsableV();
                    $listaResponsables = $responsable->listar();
                    for ($i = 1; $i < count($listaResponsables); $i++) {
                        echo $listaResponsables[$i];
                    }
                    echo "\nIndique el número del nuevo responsable a cargo del viaje: ";
                    $idEmpleado = esNumero();
                    //Reviso si el empleado existe       
                    $empleadoEncontrado = $responsable->buscar($idEmpleado);
                    while (!$empleadoEncontrado) {
                        echo "\nEl número ingresado no pertenece al número de empleado de ninguno de los responsables existentes en la empresa.
            Intente nuevamente. ";
                        $idEmpleado = esNumero();
                        $empleadoEncontrado = $responsable->buscar($idEmpleado);
                    }
                    $viaje->setObjResponsable($responsable);
                    $viaje->modificar();
                    echo "\nEl nuevo responsable a cargo del viaje es '" . $viaje->getObjResponsable() . "'.";
                    break;

                case 5:
                    //Cambiar la empresa a cargo del viaje
                    echo "\n-----LISTA DE EMPRESAS-----";
                    $empresa = new Empresa();
                    $listaEmpresas = $empresa->listar();
                    for ($i = 1; $i < count($listaEmpresas); $i++) {
                        echo $listaEmpresas[$i];
                    }
                    echo "\nIndique el número de la empresa que estará a cargo del viaje: ";
                    $idEmpresa = esNumero();
                    //Reviso si la empresa existe       
                    $empresaEncontrada = $empresa->buscar($idEmpresa);
                    while (!$empresaEncontrada) {
                        echo "\nEl número ingresado no pertenece al número de ID de las empresas existentes.
                Intente nuevamente. ";
                        $idEmpresa = esNumero();
                        $empresaEncontrada = $empresa->buscar($idEmpresa);
                    }
                    $viaje->setObjEmpresa($empresa);
                    $viaje->modificar();
                    echo "\nEl viaje ahora está a cargo de la empresa '" . $viaje->getObjEmpresa() . "'.";
                    break;

                default:
                    break;
            }

        case 3:
            //Ver lista de todos los viajes registrados
            $viaje = new Viaje();
            $listaViajes = $viaje->listar();
            for ($i = 0; $i < count($listaViajes); $i++) {
                echo "\n" . $listaViajes[$i];
            }
            break;

        case 4:
            //Eliminar un viaje
            $viaje = new Viaje();
            $listaViajes = $viaje->listar();
            for ($i = 0; $i < count($listaViajes); $i++) {
                echo "\n" . $listaViajes[$i];
            }
            echo "\nIngrese el número del viaje que desea eliminar: ";
            $idViaje = esNumero();
            //Reviso si existe un viaje con ese número de ID
            $viajeEncontrado = $viaje->buscar($idViaje);
            while (!$viajeEncontrado) {
                echo "\nEl número ingresado no pertenece al ID de ninguno de los viajes registrados. Intente nuevamente. ";
                $idViaje = esNumero();
                $viajeEncontrado = $viaje->buscar($idViaje);
            }
            echo "\n" . $viaje;
            echo "\n¿Desea eliminar este viaje? Se eliminaran TODOS los pasajeros asociados a la misma (S/N).: ";
            $respuesta = esString();
            $respuesta = strtolower($respuesta);
            while ($respuesta != "s" && $respuesta != "n") {
                echo "\nRespuesta no válida. Indique si desea (S) o no (N) eliminar al responsable: ";
                $respuesta = trim(fgets(STDIN));
                $respuesta = strtolower($respuesta);
            }
            if ($respuesta == "s") {
                $pasajero = new Pasajero();
                $coleccionPasajeros = $pasajero->listar("idviaje=" . $idViaje);
                for ($i = 0; $i < count($coleccionPasajeros); $i++) {
                    $unPasajero = $coleccionPasajeros[$i];
                    $unPasajero->eliminar();
                }
                $viaje->eliminar();
                echo "\nEl viaje ha sido eliminado.";
            }
            echo "\nVolviendo al menú anterior...";
            break;

        default:
            break;
    }
}