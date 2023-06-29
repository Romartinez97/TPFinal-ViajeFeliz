<?php

include_once("BaseDatos.php");
include_once("funciones.php");
include_once("menuResponsables.php");
include_once("menuPasajeros.php");
include_once("menuViajes.php");
include_once("menuEmpresas.php");

// Carga de datos
/*
$objEmpresa = new Empresa();
$objEmpresa->cargar(28, "Chevallier", "Avenida Argentina 123", []);
$objEmpresa->insertar();

$objResponsable1 = new ResponsableV();
$objResponsable1->cargar(60, 123, "Pablo", "Rey");
$objResponsable1->insertar();

$objResponsable2 = new ResponsableV();
$objResponsable2->cargar(61, 324, "Enzo", "Pérez");
$objResponsable2->insertar();

$objViaje1 = new Viaje();
$objViaje1->cargar(30, "Buenos Aires", 50, $objEmpresa, $objResponsable1, 15000, []);
$objViaje1->insertar();

$objViaje2 = new Viaje();
$objViaje2->cargar(31, "Mendoza", 50, $objEmpresa, $objResponsable1, 20000, []);
$objViaje2->insertar();

$objViaje3 = new Viaje();
$objViaje3->cargar(32,"Salta", 50, $objEmpresa, $objResponsable2, 25000, []);
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
*/

/**************************************/
/********* PROGRAMA PRINCIPAL *********/
/**************************************/

do {
  echo "\n -------- MENÚ --------\n";
  echo "\n   1) Menú de responsables.";
  echo "\n   2) Menú de pasajeros.";
  echo "\n   3) Menú de viajes.";
  echo "\n   4) Menú de empresas.";
  echo "\n   5) Salir.";
  $opcion = validarOpcion(5);

  switch ($opcion) {
    case 1:
      menuResponsables();
      break;

    case 2:
      menuPasajeros();
      break;

    case 3:
      menuViajes();
      break;

    case 4:
      menuEmpresas();
      break;

    default:
      break;

  }
} while ($opcion != 5);