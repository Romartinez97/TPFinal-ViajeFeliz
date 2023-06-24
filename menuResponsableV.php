<?php

include_once("Funciones.php");
include_once("claseResponsable.php");

//Armar un menú con todas las opciones referidas a los responsables:
//- Agregar un responsable (verificar que no se repita uno ya creado, puede ser verificando el número de licencia)
//- Modificar un responsable (¿misma verificación que arriba?)
//- Eliminar un responsable
function menuResponsables()
{
    echo "\n----------MENÚ DE RESPONSABLES----------\n";
    echo "\n 1) Agregar un responsable.";
    echo "\n 2) Modificar información de un responsable.";
    echo "\n 3) Ver lista de todos los responsables registrados.";
    echo "\n 4) Eliminar un responsable.";
    echo "\n 5) Volver al menú principal.";

    $opcionElegida = validarOpcion(5);

    switch ($opcionElegida) {
        case 1:
            //Agregar un responsable
            echo "\nIndique el número de licencia del responsable: ";
            $rNumeroLicencia = esNumero();
            //Reviso si no existe un responsable con ese número de licencia
            $responsableV = new ResponsableV();
            $listaResponsables = $responsableV->listar("rnumerolicencia=" . $rNumeroLicencia);
            while (!empty($listaResponsables)) {
                echo "\nYa existe un responsable con ese número de licencia, intente nuevamente.";
                echo "\nIndique el número de licencia del responsable: ";
                $rNumeroLicencia = esNumero();
                $listaResponsables = $responsableV->listar("rnumerolicencia=" . $rNumeroLicencia);
            }
            echo "\nIndique el nombre del responsable: ";
            $rNombre = esString();
            echo "\nIndique el apellido del responsable: ";
            $rApellido = esString();
            //Cargo y e inserto al responsable
            $responsableV->cargar($rNumeroLicencia, $rNombre, $rApellido);
            $responsableV->insertar();
            echo "\n.Se creó correctamente al nuevo responsable.";
            echo "\n" . $responsableV;
            break;

        case 2:
            //Modificar información de un responsable
            $responsableV = new ResponsableV();
            $listaResponsables = $responsableV->listar();
            for ($i = 1; $i < count($listaResponsables); $i++) {
                echo $listaResponsables[$i];
            }
            echo "\nIndique el número de empleado del responsable que desea modificar: ";
            $idEmpleado = esNumero();
            //Reviso si el empleado existe       
            $empleadoEncontrado = $responsableV->buscar($idEmpleado);
            while (!$empleadoEncontrado) {
                echo "\nEl número ingresado no pertenece al número de empleado de ninguno de los responsables existentes en la empresa.
            Intente nuevamente. ";
                $idEmpleado = esNumero();
                $empleadoEncontrado = $responsableV->buscar($idEmpleado);
            }
            echo "\n" . $responsableV;

            //Menú para modificar al responsable encontrado
            echo "\n----------MODIFICACIÓN DE RESPONSABLE----------\n";
            echo "\n 1) Modificar el nombre.";
            echo "\n 2) Modificar el apellido.";
            echo "\n 3) Modificar la licencia.";
            echo "\n 4) Volver al menú anterior.";
            $opcionElegida = validarOpcion(4);

            switch ($opcionElegida) {

                case 1:
                    //Modificar el nombre
                    echo "\Ingrese el nuevo nombre del responsable: ";
                    $rNombreNuevo = esString();
                    $responsableV->setrNombre($rNombreNuevo);
                    $responsableV->modificar();
                    echo "\nEl nuevo nombre del responsable es '" . $responsableV->getrNombre() . "'.";
                    break;

                case 2:
                    //Modificar el apellido
                    echo "\Ingrese el nuevo apellido del responsable: ";
                    $rApellidoNuevo = esString();
                    $responsableV->setrApellido($rApellidoNuevo);
                    $responsableV->modificar();
                    echo "\nEl nuevo apellido del responsable es '" . $responsableV->getrApellido() . "'.";
                    break;

                case 3:
                    //Modificar el número de licencia
                    echo "\Ingrese el nuevo número de licencia del responsable: ";
                    $rNumeroLicenciaNuevo = esNumero();
                    //Reviso si no existe un empleado con el mismo número de licencia
                    $listaResponsables = $responsableV->listar("rnumerolicencia=" . $rNumeroLicenciaNuevo);
                    while (!empty($listaResponsables)) {
                        echo "\nYa existe un responsable con ese número de licencia, intente nuevamente.";
                        echo "\nIndique el número de licencia del responsable: ";
                        $rNumeroLicenciaNuevo = esNumero();
                        $listaResponsables = $responsableV->listar("rnumerolicencia=" . $rNumeroLicenciaNuevo);
                    }
                    $responsableV->buscar($idEmpleado); //Lo busco de nuevo?
                    $responsableV->setrNumeroLicencia($rNumeroLicenciaNuevo);
                    $responsableV->modificar();
                    echo "\nEl nuevo número de licencia del responsable es '" . $responsableV->getrNumeroLicencia() . "'.";
                    break;

                default:
                    break;
            }

        case 3:
            //Ver lista de todos los responsables registrados
            $responsableV = new ResponsableV();
            $listaResponsables = $responsableV->listar();
            for ($i = 0; $i < count($listaResponsables); $i++) {
                echo "\n" . $listaResponsables[$i];
            }
            break;

        case 4:
            //Eliminar un responsable
            $responsableV = new ResponsableV();
            $listaResponsables = $responsableV->listar();
            for ($i = 0; $i < count($listaResponsables); $i++) {
                echo "\n" . $listaResponsables[$i];
            }
            echo "\nIngrese el número de empleado del responsable que desea eliminar: ";
            $idEmpleado = esNumero();
            //Reviso si existe un empleado con ese ID
            $seEncontro = $responsableV->buscar($idEmpleado);
            while (!$seEncontro) {
                echo "\nNo existe un responsable con ese número de empleado, intente nuevamente.";
                echo "\nIngrese el número de empleado del responsable que desea ver: ";
                $idEmpleado = esNumero();
                $seEncontro = $responsableV->buscar($idEmpleado);
            }
            echo "\n" . $responsableV;
            echo "\n¿Desea eliminar a este responsable? (S/N): ";
            $respuesta = esString();
            $respuesta = strtolower($respuesta);
            while ($respuesta != "s" && $respuesta != "n") {
                echo "\nRespuesta no válida. Indique si desea (S) o no (N) eliminar al responsable: ";
                $respuesta = trim(fgets(STDIN));
                $respuesta = strtolower($respuesta);
            }
            if ($respuesta == "s") {
                $responsableV->eliminar();
                echo "\nSe ha eliminado correctamente al responsable.";
            }
            echo "\nVolviendo al menú anterior...";
            break;

        default:
            break; 
    }
}