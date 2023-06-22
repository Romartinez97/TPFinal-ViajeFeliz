<?php

include_once("BaseDatos.php");
include_once("clasePasajero.php");
include_once("claseResponsableV.php");
include_once("claseEmpresa.php");
class Viaje
{
  private $idviaje;
  private $vdestino;
  private $vcantmaxpasajeros;
  private $idempresa;
  private $rnumeroempleado;
  private $vimporte;
  private $coleccionpasajeros;
  private $mensajeoperacion;

  public function __construct()
  {

    $this->idviaje = "";
    $this->vdestino = "";
    $this->vcantmaxpasajeros = "";
    $this->idempresa = "";
    $this->rnumeroempleado = "";
    $this->vimporte = "";
    $this->coleccionpasajeros = [];
  }

  public function setidviaje($idviaje)
  {
    $this->idviaje = $idviaje;
  }

  public function getidviaje()
  {
    return $this->idviaje;
  }

  public function setvdestino($vdestino)
  {
    $this->vdestino = $vdestino;
  }

  public function getvdestino()
  {
    return $this->vdestino;
  }

  public function setvcantmaxpasajeros($vcantmaxpasajeros)
  {
    $this->vcantmaxpasajeros = $vcantmaxpasajeros;
  }

  public function getvcantmaxpasajeros()
  {
    return $this->vcantmaxpasajeros;
  }

  public function setidempresa($idempresa)
  {
    $this->idempresa = $idempresa;
  }
  public function getidempresa()
  {
    return $this->idempresa;
  }

  public function setrnumeroempleado($rnumeroempleado)
  {
    $this->rnumeroempleado = $rnumeroempleado;
  }
  public function getrnumeroempleado()
  {
    return $this->rnumeroempleado;
  }

  public function setvimporte($vimporte)
  {
    $this->vimporte = $vimporte;
  }
  public function getvimporte()
  {
    return $this->vimporte;
  }

  public function setcoleccionpasajeros($coleccionpasajeros)
  {
    $this->coleccionpasajeros = $coleccionpasajeros;
  }
  public function getcoleccionpasajeros()
  {
    return $this->coleccionpasajeros;
  }

  public function setmensajeoperacion($mensajeoperacion)
  {
    $this->mensajeoperacion = $mensajeoperacion;
  }

  public function getmensajeoperacion()
  {
    return $this->mensajeoperacion;
  }

  public function __toString()
  {
    return
      "\nID viaje N°: " . $this->getidviaje() .
      "\nDestino: " . $this->getvdestino() .
      "\nCantidad máxima de pasajeros: " . $this->getvcantmaxpasajeros() .
      "\nID empresa N° " . $this->getidempresa() .
      "\nNúmero de empleado a cargo: " . $this->getrnumeroempleado() .
      "\nImporte del viaje: " . $this->getvimporte() .
      "\nLista de pasajeros: " . $this->mostrarPasajeros() . "\n";
  }

  /**
   * Función para poder mostrar en pantalla la lista de pasajeros de un viaje.
   * @return string
   */
  public function mostrarPasajeros()
  {
    $listaPasajeros = $this->getcoleccionpasajeros();
    $texto = " ";
    for ($i = 0; $i < count($listaPasajeros); $i++) {
      $texto = $texto . $listaPasajeros[$i];
    }
    return $texto;
  }

  public function cargar($destino, $cantmaxpasajeros, $idempresa, $numeroempleado, $importe, $coleccionpasajeros)
  {
    $this->setvdestino($destino);
    $this->setvcantmaxpasajeros($cantmaxpasajeros);
    $this->setidempresa($idempresa);
    $this->setrnumeroempleado($numeroempleado);
    $this->setvimporte($importe);
    $this->setcoleccionpasajeros($coleccionpasajeros);
  }

  /**
   * Recupera los datos de un viaje por su ID
   * @param int $idviaje
   * @return bool
   */
  public function buscar($idviaje)
  {
    $base = new BaseDatos();
    $consultaViaje = "Select * from viaje where idviaje=" . $idviaje;
    $seEncontro = false;
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consultaViaje)) {
        if ($row2 = $base->Registro()) {
          $this->setidviaje($idviaje);
          $this->setvdestino($row2['vdestino']);
          $this->setvcantmaxpasajeros($row2['vcantmaxpasajeros']);
          $this->setidempresa($row2['idempresa']);
          $this->setrnumeroempleado($row2['rnumeroempleado']);
          $this->setvimporte($row2['vimporte']);
          $objpasajero = new Pasajero();
          $coleccionpasajeros = $objpasajero->listar("idviaje=" . $idviaje);
          $this->setcoleccionpasajeros($coleccionpasajeros);
          $seEncontro = true;
        }

      } else {
        $this->setmensajeoperacion($base->getError());

      }
    } else {
      $this->setmensajeoperacion($base->getError());

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
    $consultaViajes .= "order by vdestino";
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consultaViajes)) {
        $arregloViajes = array();
        while ($row2 = $base->Registro()) {
          $idviaje = $row2['idviaje'];
          $destino = $row2['vdestino'];
          $cantmaxpasajeros = $row2['vcantmaxpasajeros'];
          $idempresa = $row2['idempresa'];
          $numeroempleado = $row2['rnumeroempleado'];
          $importe = $row2['vimporte'];
          $objpasajero = new Pasajero();
          $coleccionpasajeros = $objpasajero->listar("idviaje=" . $idviaje);
          $this->setcoleccionpasajeros($coleccionpasajeros);

          $viaje = new Viaje();
          $viaje->cargar($destino, $cantmaxpasajeros, $idempresa, $numeroempleado, $importe, $coleccionpasajeros);
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
				VALUES ('" . $this->getvdestino() . "','" .
      $this->getvcantmaxpasajeros() . "','" .
      $this->getidempresa() . "','" .
      $this->getrnumeroempleado() . "','" .
      $this->getvimporte() . "')";


    if ($base->Iniciar()) {

      if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
        $this->setidviaje($id);
        $seInserto = true;

      } else {
        $this->setmensajeoperacion($base->getError());

      }

    } else {
      $this->setmensajeoperacion($base->getError());

    }
    return $seInserto;
  }

  public function modificar()
  {
    $seModifico = false;
    $base = new BaseDatos();
    $consultaModifica = "UPDATE viaje SET vdestino='" . $this->getvdestino() .
      "',vcantmaxpasajeros='" . $this->getvcantmaxpasajeros() .
      "' ,idempresa='" . $this->getidempresa() .
      "' ,rnumeroempleado='" . $this->getrnumeroempleado() .
      "' ,vimporte='" . $this->getvimporte() .
      "' ,colecionpasajeros='" . $this->getcoleccionpasajeros() .
      "' WHERE idviaje=" . $this->getidviaje();
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consultaModifica)) {
        $seModifico = true;
      } else {
        $this->setmensajeoperacion($base->getError());

      }
    } else {
      $this->setmensajeoperacion($base->getError());

    }
    return $seModifico;
  }

  public function eliminar()
  {
    $base = new BaseDatos();
    $seElimino = false;
    if ($base->Iniciar()) {
      $consultaBorra = "DELETE FROM viaje WHERE idviaje=" . $this->getidviaje();
      if ($base->Ejecutar($consultaBorra)) {
        $seElimino = true;
      } else {
        $this->setmensajeoperacion($base->getError());

      }
    } else {
      $this->setmensajeoperacion($base->getError());

    }
    return $seElimino;
  }

}