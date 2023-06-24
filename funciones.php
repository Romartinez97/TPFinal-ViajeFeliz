<?php

/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/

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

/**
 * Función para validar la opción elegida por el usuario teniendo en cuenta cuántas opciones hay disponibles
 * @param int $cantidadOpciones
 * @return int
 */
function validarOpcion($cantidadOpciones){
  do {
    echo "\nIngrese un número del 1 al ".$cantidadOpciones." para elegir una opción: ";
    $opcion = esNumero();
    if ($opcion <= 0 || $opcion > $cantidadOpciones) {
      echo "\nPor favor, ingrese un número valido (del 1 al ".$cantidadOpciones.")\n";
    }
  } while ($opcion <= 0 || $opcion > $cantidadOpciones);

  return $opcion;
}