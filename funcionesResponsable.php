<?php

//Armar un menú con todas las opciones referidas a los responsables:
//- Agregar un responsable (verificar que no se repita uno ya creado, puede ser verificando el número de licencia)
//- Modificar un responsable (¿misma verificación que arriba?)
//- Eliminar un responsable
function menuResponsables(){
echo "\n----------MENÚ DE RESPONSABLES----------\n";
echo "\n 1) Agregar un responsable.";
echo "\n 2) Modificar información de un responsable.";
echo "\n 3) Ver información de un responsable.";
echo "\n 4) Ver lista de todos los responsables registrados.";
echo "\n 5) Eliminar un responsable.";
echo "\n 6) Salir.";
}