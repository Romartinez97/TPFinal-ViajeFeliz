<?php

include_once("BaseDatos.php");
include_once("claseViaje.php");
include_once("clasePasajero.php");
include_once("claseResponsableV.php");
include_once("claseEmpresa.php");
include_once("funciones.php");



// Carga de datos

$objEmpresa = new Empresa();
$objEmpresa->cargar("Chevallier", "Avenida Argentina 123", []);
$objEmpresa->insertar();

$objResponsable1 = new ResponsableV();
$objResponsable1->cargar(123, "Pedro", "López");
$objResponsable1->insertar();

$objResponsable2 = new ResponsableV();
$objResponsable2->cargar(324, "Enzo", "Pérez");
$objResponsable2->insertar();

$objViaje1 = new Viaje();
$objViaje1->cargar("Buenos Aires", 50, $objEmpresa->getidempresa(), $objResponsable1->getrnumeroempleado(), 15000, []);
$objViaje1->insertar();

$objViaje2 = new Viaje();
$objViaje2->cargar("Mendoza", 50, $objEmpresa->getidempresa(), $objResponsable1->getrnumeroempleado(), 20000, []);
$objViaje2->insertar();

$objViaje3 = new Viaje();
$objViaje3->cargar("Salta", 50, $objEmpresa->getidempresa(), $objResponsable2->getrnumeroempleado(), 25000, []);
$objViaje3->insertar();

$objPasajero1 = new Pasajero();
$objPasajero1->cargar(40111111, "Martín", "Benítez", 4331111, $objViaje1->getidviaje());
$objPasajero1->insertar();

$objPasajero2 = new Pasajero();
$objPasajero2->cargar(40222222, "Pablo", "Pérez", 4332222, $objViaje1->getidviaje());
$objPasajero2->insertar();

$objPasajero3 = new Pasajero();
$objPasajero3->cargar(40333333, "Guido", "Herrera", 4333333, $objViaje1->getidviaje());
$objPasajero3->insertar();

$objPasajero4 = new Pasajero();
$objPasajero4->cargar(40444444, "Leandro", "Díaz", 4334444, $objViaje2->getidviaje());
$objPasajero4->insertar();

$objPasajero5 = new Pasajero();
$objPasajero5->cargar(40555555, "Lucas", "Merolla", 4335555, $objViaje2->getidviaje());
$objPasajero5->insertar();

$objPasajero6 = new Pasajero();
$objPasajero6->cargar(40666666, "Tomás", "Pozzo", 4336666, $objViaje3->getidviaje());
$objPasajero6->insertar();


/**************************************/
/********* PROGRAMA PRINCIPAL *********/
/**************************************/

do {
  $opcion = seleccionarOpcion();
  switch ($opcion) {

    case 1:
      //Cargar información del viaje.
      echo "\nIngrese el destino del viaje: ";
      $destinoViaje = esString();
      echo "\nIngrese la cantidad máxima de pasajeros permitidos: ";
      $maxPasajerosViaje = esNumero();
      echo "\nIngrese el costo del pasaje del viaje: ";
      $costoViaje = esNumero();
      echo "\nIngrese el ID de la empresa que está encargada del viaje: ";
      $idEmpresa = esNumero();
      //Datos del responsable del viaje
      echo "\nDatos del responsable del viaje:";
      echo "\nNombre: ";
      $nombreR = esString();
      echo "\nApellido: ";
      $apellidoR = esString();
      echo "\nNúmero de licencia: ";
      $numLicenciaR = esNumero();
      $responsableV = new ResponsableV();
      $responsableV->cargar($numLicenciaR, $nombreR, $apellidoR);
      $responsableV->insertar();
      echo $responsableV;
      $viaje = new Viaje();
      $viaje->cargar($destinoViaje, $maxPasajerosViaje, $idEmpresa, $responsableV->getrnumeroempleado(), $costoViaje, []);
      $viaje->insertar();
      echo $viaje;
      $idViaje = $viaje->getidviaje();
      //Datos de pasajeros
      echo "\n¿Desea ingresar los datos de un pasajero para dicho viaje? (S/N) ";
      $respuesta = trim(fgets(STDIN));
      $respuesta = strtolower($respuesta);
      while ($respuesta != "s" && $respuesta != "n") {
        echo "\nIndique si desea (S) o no (N) agregar a un pasajero: ";
        $respuesta = trim(fgets(STDIN));
        $respuesta = strtolower($respuesta);
      }
      while ($respuesta == "s") {
        $listadoPasajeros = $viaje->listar("idviaje=" . $idViaje);
        if (count($listadoPasajeros) == $maxPasajerosViaje) {
          echo "\nEl viaje ya llegó al límite de pasajeros a bordo, no se permite el ingreso de otro más";
          $respuesta = "n";
          break;
        } else {
          echo "\nIngrese el nombre del pasajero: ";
          $nombreP = esString();
          echo "\nIngrese el apellido del pasajero: ";
          $apellidoP = esString();
          echo "\nIngrese el número de teléfono del pasajero (sin puntos ni guiones): ";
          $telefonoP = esNumero();
          echo "\nIngrese el número de documento del pasajero (sin puntos): ";
          $numeroDocP = esNumero();
          $pasajero = new Pasajero();
          $pasajero->Buscar($numeroDocP);
          $pasajeroRepetido = false;
          do {
            if ($pasajero->getpdocumento() == $numeroDocP) {
              echo "\nYa se encuentra registrado un pasajero con el DNI " . $numeroDocP . ", intente nuevamente.";
              $pasajeroRepetido = true;
            }
          } while ($pasajeroRepetido);
        }
        $pasajero = new Pasajero();
        $pasajero->cargar($numeroDocP, $nombreP, $apellidoP, $telefonoP, $viaje->getidviaje());
        echo "\nPasajero cargado:\n " . $pasajero;

        echo "\n¿Desea ingresar los datos de otro pasajero? (S/N): ";
        $respuesta = trim(fgets(STDIN));
        $respuesta = strtolower($respuesta);
        while ($respuesta != "s" && $respuesta != "n") {
          echo "\nIndique si desea (S) o no (N) agregar a un pasajero: ";
          $respuesta = trim(fgets(STDIN));
          $respuesta = strtolower($respuesta);
        }
      }
      $pasajero = new Pasajero();
      $listadoPasajeros = $pasajero->listar("idviaje=" . $idViaje);
      $viaje->setcoleccionpasajeros($listadoPasajeros);
      break;

    case 2:
      //Modificar información
      echo "\nIngrese el ID del viaje a modificar: ";
      $idViaje = esNumero();
      $viaje = new Viaje();
      $viaje->buscar($idViaje);

      while ($viaje == false) {
        echo "\nEl ID ingresado no corresponde a ningún viaje registrado. Ingrese un ID válido: ";
        $idViaje = esNumero();
        $viaje->buscar($idViaje);
      }
      echo "\n   1) Modificar información de un viaje.";
      echo "\n   2) Modificar información de un pasajero.";
      echo "\n   3) Volver al menú anterior.";
      do {
        echo "\nIngrese un número del 1 al 3 para elegir la opción: ";
        $opcion = trim(fgets(STDIN));
        if ($opcion <= 0 || $opcion > 3) {
          echo "\nPor favor, ingrese un número valido.\n";
        }
      } while ($opcion <= 0 || $opcion > 3);
      switch ($opcion) {

        case 1:
          //Modificar información del viaje
          echo "\n   1) Modificar destino del viaje.";
          echo "\n   2) Modificar número máximo de pasajeros del viaje.";
          echo "\n   3) Modificar importe del viaje.";
          echo "\n   4) Eliminar un viaje.";
          echo "\n   5) Volver al menú anterior.";
          do {
            echo "\nIngrese un número del 1 al 5 para elegir la opción: ";
            $opcion = trim(fgets(STDIN));
            if ($opcion <= 0 || $opcion > 5) {
              echo "\nPor favor, ingrese un número valido.\n";
            }
          } while ($opcion <= 0 || $opcion > 5);
          switch ($opcion) {

            case 1:
              echo "\nIngrese el nuevo destino: ";
              $destinoNuevo = esString();
              $viaje->setvdestino($destinoNuevo);
              $viaje->modificar();
              echo "\nEl nuevo destino es " . $viaje->getvdestino() . ".";
              break;

            case 2:
              echo "\nIngrese el nuevo número máximo de pasajeros: ";
              $numMaxNuevo = esNumero();
              $viaje->setvcantmaxpasajeros($numMaxNuevo);
              $viaje->modificar();
              echo "\nEl nuevo número máximo de pasajeros es " . $viaje->getvcantmaxpasajeros() . ".";
              break;

            case 3:
              echo "\nIngrese el nuevo importe del viaje: ";
              $importeNuevo = esNumero();
              $viaje->setvimporte($importeNuevo);
              $viaje->modificar();
              echo "\nEl nuevo importe del viaje es " . $viaje->getvimporte() . ".";
              break;

            case 4:
              echo "\nIngrese el ID del viaje a eliminar: ";
              $idViaje = esNumero();
              $viaje = new Viaje();
              $viaje->buscar($idViaje);
              while ($viaje == false) {
                echo "\nEl ID ingresado no corresponde a ningún viaje registrado por la empresa. Ingrese un ID válido:";
                $idViaje = esNumero();
                $viaje->buscar($idViaje);
              }
              echo "\n" . $viaje;
              echo "\n¿Está segura/o que desea eliminar el viaje de ID " . $idViaje . "? Se eliminarán los datos asociados al mismo (pasajeros) (S/N)";
              $respuesta = trim(fgets(STDIN));
              $respuesta = strtolower($respuesta);
              while ($respuesta != "s" && $respuesta != "n") {
                echo "\nIndique si desea (S) o no (N) eliminar el viaje: ";
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
                echo "\nEl viaje ha sido eliminado";
              }

            default:
              break;
          }
          break;

        case 2:
          //Modificar información de un pasajero
          echo "\nIngrese el documento del pasajero a modificar (sin puntos): ";
          $documentoPasajero = esNumero();
          $pasajero = new Pasajero();
          $pasajero->buscar($documentoPasajero);
          while ($pasajero == false) {
            echo "\nEl documento ingresado no corresponde a ningún pasajero registrado en este viaje. Ingrese un documento válido:";
            $documentoPasajero = esNumero();
            $pasajero->buscar($documentoPasajero);
          }

          echo "\n   1) Modificar nombre y apellido del pasajero.";
          echo "\n   2) Modificar teléfono del pasajero.";
          echo "\n   3) Volver al menú anterior.";
          do {
            echo "\nIngrese un número del 1 al 3 para elegir la opción: ";
            $opcion = trim(fgets(STDIN));
            if ($opcion <= 0 || $opcion > 3) {
              echo "\nPor favor, ingrese un número valido.\n";
            }
          } while ($opcion <= 0 || $opcion > 3);

          switch ($opcion) {
            case 1:
              echo "\nIngrese el nuevo nombre y apellido del pasajero.";
              echo "\nNombre: ";
              $nombreNuevo = esString();
              echo "\nApellido: ";
              $apellidoNuevo = esString();
              $pasajero->setpnombre($nombreNuevo);
              $pasajero->setpapellido($apellidoNuevo);
              $pasajero->modificar();
              $listadoPasajeros = $pasajero->listar("idviaje=" . $idViaje);
              $viaje->setcoleccionpasajeros($listadoPasajeros);
              echo "\nEl nuevo nombre y apellido del pasajero es " . $pasajero->getpnombre() . " " . $pasajero->getpapellido() . ".";
              break;

            case 2:
              echo "\nIngrese el nuevo número de teléfono del pasajero (sin puntos): ";
              $nuevoTelefono = esNumero();
              $pasajero->setptelefono($nuevoTelefono);
              $pasajero->modificar();
              $listadoPasajeros = $pasajero->listar("idviaje=" . $idViaje);
              $viaje->setcoleccionpasajeros($listadoPasajeros);
              echo "\nEl nuevo teléfono del pasajero es " . $pasajero->getptelefono() . ".";
              break;
            default:
              break;
          }
          break;
      }
      break;

    case 3:
      //Ver información de un viaje.
      echo "\nIngrese el ID del viaje del cual desea ver la información: ";
      $idViaje = esNumero();
      $viaje = new Viaje();
      $viaje->buscar($idViaje);

      while ($viaje == false) {
        echo "\nEl ID ingresado no corresponde a ningún viaje registrado. Ingrese un ID válido: ";
        $idViaje = esNumero();
        $viaje->buscar($idViaje);
      }
      echo $viaje;
      break;

    case 4:
      //Cargar información de una empresa
      echo "\nIngrese el nombre de la empresa: ";
      $nombreEmpresa = esString();
      echo "\nIngrese la dirección de la empresa: ";
      $direccionEmpresa = trim(fgets(STDIN));
      $empresa = new Empresa();
      $empresa->cargar($nombreEmpresa, $direccionEmpresa, []);
      $empresa->insertar();
      break;

    case 5:
      //Modificar información de una empresa
      echo "\nIngrese el ID de la empresa a modificar: ";
      $idEmpresa = esNumero();
      $empresa = new Empresa();
      $empresa->buscar($idEmpresa);
      while ($empresa == false) {
        echo "\nEl ID ingresado no corresponde a ninguna empresa registrada. Ingrese un ID válido: ";
        $idEmpresa = esNumero();
        $empresa->buscar($idEmpresa);
      }
      echo "\n   1) Modificar nombre de la empresa.";
      echo "\n   2) Modificar dirección de la empresa.";
      echo "\n   3) Eliminar la empresa.";
      echo "\n   4) Volver al menú anterior.";
      do {
        echo "\nIngrese un número del 1 al 4 para elegir la opción: ";
        $opcion = trim(fgets(STDIN));
        if ($opcion <= 0 || $opcion > 4) {
          echo "\nPor favor, ingrese un número valido.\n";
        }
      } while ($opcion <= 0 || $opcion > 4);

      switch ($opcion) {
        case 1:
          echo "\nIngrese el nuevo nombre de la empresa.";
          echo "\nNombre: ";
          $nombreNuevo = esString();
          $empresa->setenombre($nombreNuevo);
          $empresa->modificar();
          echo "\nEl nuevo nombre de la empresa es " . $empresa->getenombre() . ".";
          break;

        case 2:
          echo "\nIngrese la nueva dirección de la empresa.";
          echo "\nDirección: ";
          $direccionNueva = esString();
          $empresa->setedireccion($direccionNueva);
          $empresa->modificar();
          echo "\nLa nueva direcicón de la empresa es " . $empresa->getedireccion() . ".";
          break;


        case 3:
          echo "\nIngrese el ID del viaje a eliminar: ";
          $idEmpresa = esNumero();
          $empresa = new Empresa();
          $empresa->buscar($idEmpresa);
          while ($empresa == false) {
            echo "\nEl ID ingresado no corresponde a ninguna empresa registrada. Ingrese un ID válido:";
            $idEmpresa = esNumero();
            $empresa->buscar($idEmpresa);
          }
          echo "\n" . $empresa;
          echo "\n¿Está segura/o que desea eliminar la empresa de ID " . $idEmpresa . "? Se eliminarán todos los datos asociados a la misma (viajes y pasajeros) (S/N)";
          $respuesta = trim(fgets(STDIN));
          $respuesta = strtolower($respuesta);
          while ($respuesta != "s" && $respuesta != "n") {
            echo "\nIndique si desea (S) o no (N) eliminar el viaje: ";
            $respuesta = trim(fgets(STDIN));
            $respuesta = strtolower($respuesta);
          }
          if ($respuesta == "s") {
            //Conseguir ID de todos los viajes de la empresa
            $viaje = new Viaje();
            $coleccionViajes = $viaje->listar("idempresa=" . $idEmpresa);
            for ($i = 0; $i < count($coleccionViajes); $i++) {
              $unViaje = $coleccionViajes[$i];
              $unID = $unViaje->getidviaje();
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

        default:
          break;
      }
      break;
  }

} while ($opcion != 7);