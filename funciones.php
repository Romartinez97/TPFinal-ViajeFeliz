<?php

include_once("claseViaje.php");
include_once("clasePasajero.php");
include_once("claseResponsableV.php");

/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/

/**
 * Muestra el menú de opciones para que el usuario interactue
 * @return int
 */
function seleccionarOpcion()
{
  echo "\n -------- MENÚ --------\n";
  echo "\n   1) Cargar información de un viaje.";
  echo "\n   2) Modificar información de un viaje.";
  echo "\n   3) Ver información de un viaje.";
  echo "\n   4) Cargar información de una empresa.";
  echo "\n   5) Modificar información de una empresa.";
  echo "\n   6) Ver información de una empresa.";
  echo "\n   7) Salir.";
  do {
    echo "\nIngrese un número del 1 al 7 para elegir la opción: ";
    $opcion = trim(fgets(STDIN));
    if ($opcion <= 0 || $opcion > 7) {
      echo "\nPor favor, ingrese un número valido.\n";
    }
  } while ($opcion <= 0 || $opcion > 7);

  return $opcion;
}

/**
 * Función para verificar que la variable ingresada es numérica (entero) en su totalidad.
 * @return int
 */
function esNumero()
{
  //int $numero
  $numero = trim(fgets(STDIN));
  while (!is_numeric($numero)) {
    echo "\nEl dato requerido debe estar compuesto solo por números: ";
    $numero = trim(fgets(STDIN));
  }
  return $numero;
}

/**
 * Función para verificar que la variable ingresada es un string en su totalidad.
 * @return string
 */
function esString()
{
  //string $palabra
  $palabra = trim(fgets(STDIN));
  while (!is_string($palabra)) {
    echo "\nEl dato requerido debe estar compuesto solo por letras: ";
    $palabra = trim(fgets(STDIN));
  }
  return $palabra;  
}