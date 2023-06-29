<?php

include_once("BaseDatos.php");
include_once("clasePasajero.php");
include_once("claseResponsableV.php");
include_once("claseEmpresa.php");
class Viaje
{
  private $idViaje;
  private $vDestino;
  private $vCantMaxPasajeros;
  private $vImporte;
  private $coleccionPasajeros;
  private $objResponsable;
  private $objEmpresa;
  private $mensajeOperacion;

  public function __construct()
  {
    $this->idViaje = 0;
    $this->vDestino = "";
    $this->vCantMaxPasajeros = "";
    $this->objResponsable = "";
    $this->objEmpresa = "";
    $this->vImporte = "";
    $this->coleccionPasajeros = [];
  }

  public function setIDViaje($idViaje)
  {
    $this->idViaje = $idViaje;
  }

  public function getIDViaje()
  {
    return $this->idViaje;
  }

  public function setvDestino($vDestino)
  {
    $this->vDestino = $vDestino;
  }

  public function getvDestino()
  {
    return $this->vDestino;
  }

  public function setvCantMaxPasajeros($vCantMaxPasajeros)
  {
    $this->vCantMaxPasajeros = $vCantMaxPasajeros;
  }

  public function getvCantMaxPasajeros()
  {
    return $this->vCantMaxPasajeros;
  }

  public function setObjEmpresa($objEmpresa)
  {
    $this->objEmpresa = $objEmpresa;
  }
  public function getObjEmpresa()
  {
    return $this->objEmpresa;
  }

  public function setObjResponsable($objResponsable)
  {
    $this->objResponsable = $objResponsable;
  }
  public function getObjResponsable()
  {
    return $this->objResponsable;
  }

  public function setvImporte($vImporte)
  {
    $this->vImporte = $vImporte;
  }
  public function getvImporte()
  {
    return $this->vImporte;
  }

  public function setColeccionPasajeros($coleccionPasajeros)
  {
    $this->coleccionPasajeros = $coleccionPasajeros;
  }
  public function getColeccionPasajeros()
  {
    return $this->coleccionPasajeros;
  }

  public function setMensajeoperacion($mensajeOperacion)
  {
    $this->mensajeOperacion = $mensajeOperacion;
  }

  public function getMensajeOperacion()
  {
    return $this->mensajeOperacion;
  }

  public function __toString()
  {
    $objResponsable = new ResponsableV();
    $objEmpresa = new Empresa();

    return
      "\n-----VIAJE N° " . $this->getIDViaje() . "-----" .
      "\nDestino: " . $this->getvDestino() .
      "\nCantidad máxima de pasajeros: " . $this->getvCantMaxPasajeros() .
      "\nPertenece a la empresa con ID N° " . $objEmpresa->getIDEmpresa() .
      "\nNúmero de empleado a cargo: " . $objResponsable->getrNumeroEmpleado() .
      "\nImporte del viaje: " . $this->getvImporte() .
      "\nLista de pasajeros: \n" . $this->mostrarPasajeros() . "\n";
  }

  /**
   * Función para poder mostrar en pantalla la lista de pasajeros de un viaje.
   * @return string
   */
  public function mostrarPasajeros()
  {
    $listaPasajeros = $this->getColeccionPasajeros();
    $texto = " ";
    for ($i = 0; $i < count($listaPasajeros); $i++) {
      $texto = $texto . $listaPasajeros[$i];
    }
    return $texto;
  }

  public function cargar($idViaje, $destino, $cantMaxPasajeros, $objEmpresa, $objResponsable, $importe, $coleccionPasajeros)
  {
    $this->setIDViaje($idViaje);
    $this->setvDestino($destino);
    $this->setvCantMaxPasajeros($cantMaxPasajeros);
    $this->setObjEmpresa($objEmpresa);
    $this->setObjResponsable($objResponsable);
    $this->setvImporte($importe);
    $this->setColeccionPasajeros($coleccionPasajeros);
  }

  /**
   * Recupera los datos de un viaje por su ID
   * @param int $idViaje
   * @return bool
   */
  public function buscar($idViaje)
  {
    $base = new BaseDatos();
    $consultaViaje = "Select * from viaje where idviaje=" . $idViaje;
    $seEncontro = false;
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consultaViaje)) {
        if ($row2 = $base->Registro()) {

          $this->setIDViaje($idViaje);
          $this->setvDestino($row2['vdestino']);
          $this->setvCantMaxPasajeros($row2['vcantmaxpasajeros']);
          $objEmpresa = new Empresa();
          $objEmpresa->buscar($row2['idempresa']);
          $this->setObjEmpresa($objEmpresa);
          $objResponsable = new ResponsableV();
          $objResponsable->buscar($row2['rnumeroempleado']);
          $this->setObjResponsable($objResponsable);
          $this->setvImporte($row2['vimporte']);
          $objpasajero = new Pasajero();
          $coleccionPasajeros = $objpasajero->listar("idviaje=" . $idViaje);
          $this->setColeccionPasajeros($coleccionPasajeros);


          //Usar cargar
          /*
          $objEmpresa = new Empresa();
          $objEmpresa->buscar($row2['idempresa']);

          $objResponsable = new ResponsableV();
          $objResponsable->buscar($row2['rnumeroempleado']);

          $objpasajero = new Pasajero();
          $coleccionPasajeros = $objpasajero->listar("idviaje=" . $idViaje);

          $viaje = new Viaje();
          $viaje->cargar(
            $row2['idviaje'],
            $row2['vdestino'],
            $row2['vcantmaxpasajeros'],
            $objEmpresa,
            $objResponsable,
            $row2['vimporte'],
            $coleccionPasajeros
          );
          */

          $seEncontro = true;
        }

      } else {
        $this->setMensajeOperacion($base->getError());

      }
    } else {
      $this->setMensajeOperacion($base->getError());

    }
    return $seEncontro;
  }

  public function listar($condicion = "")
  {
    $arregloViajes = null;
    $base = new BaseDatos();
    $consultaViajes = "Select * from viaje ";
    if ($condicion != "") {
      $consultaViajes = $consultaViajes . ' where ' . $condicion;
    }
    $consultaViajes .= " order by vdestino ";
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consultaViajes)) {
        $arregloViajes = array();
        while ($row2 = $base->Registro()) {
          $idViaje = $row2['idviaje'];

          $objEmpresa = new Empresa();
          $objEmpresa->buscar($row2['idempresa']);

          $objResponsable = new ResponsableV();
          $objResponsable->buscar($row2['rnumeroempleado']);

          $objpasajero = new Pasajero();
          $coleccionPasajeros = $objpasajero->listar("idviaje=" . $idViaje);

          $viaje = new Viaje();
          $viaje->cargar(
            $row2['idviaje'],
            $row2['vdestino'],
            $row2['vcantmaxpasajeros'],
            $objEmpresa,
            $objResponsable,
            $row2['vimporte'],
            $coleccionPasajeros
          );
          array_push($arregloViajes, $viaje);

        }


      } else {
        $this->setmensajeoperacion($base->getError());

      }
    } else {
      $this->setmensajeoperacion($base->getError());

    }
    return $arregloViajes;
  }


  public function insertar()
  {
    $base = new BaseDatos();
    $seInserto = false;
    $consultaInsertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros,  idempresa, rnumeroempleado, vimporte) 
				VALUES ('" . $this->getvDestino() . "','" .
      $this->getvCantMaxPasajeros() . "','" .
      $this->getObjEmpresa()->getIDEmpresa() . "','" .
      $this->getObjResponsable()->getrNumeroEmpleado() . "','" .
      $this->getvImporte() . "')";


    if ($base->Iniciar()) {

      if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
        $this->setIDViaje($id);
        $seInserto = true;

      } else {
        $this->setMensajeOperacion($base->getError());

      }

    } else {
      $this->setMensajeOperacion($base->getError());

    }
    return $seInserto;
  }

  public function modificar()
  {
    $seModifico = false;
    $base = new BaseDatos();
    $consultaModifica = "UPDATE viaje SET vdestino='" . $this->getvDestino() .
      "',vcantmaxpasajeros='" . $this->getvCantMaxPasajeros() .
      "' ,idempresa='" . $this->getObjEmpresa()->getIDEmpresa() .
      "' ,rnumeroempleado='" . $this->getObjResponsable()->getrNumeroEmpleado() .
      "' ,vimporte='" . $this->getvImporte() .
      "' WHERE idviaje=" . $this->getIDViaje();

    if ($base->Iniciar()) {
      if ($base->Ejecutar($consultaModifica)) {
        $seModifico = true;
      } else {
        $this->setMensajeOperacion($base->getError());

      }
    } else {
      $this->setMensajeOperacion($base->getError());

    }
    return $seModifico;
  }

  public function eliminar()
  {
    $base = new BaseDatos();
    $seElimino = false;
    if ($base->Iniciar()) {
      $consultaBorra = "DELETE FROM viaje WHERE idviaje=" . $this->getIDViaje();
      if ($base->Ejecutar($consultaBorra)) {
        $seElimino = true;
      } else {
        $this->setMensajeOperacion($base->getError());

      }
    } else {
      $this->setMensajeOperacion($base->getError());

    }
    return $seElimino;
  }

}