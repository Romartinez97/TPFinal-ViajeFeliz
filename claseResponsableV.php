<?php

include_once("BaseDatos.php");
include_once("clasePasajero.php");
include_once("claseViaje.php");
include_once("claseEmpresa.php");

class ResponsableV
{
  private $rnumeroempleado;
  private $rnumerolicencia;
  private $rnombre;
  private $rapellido;
  private $mensajeoperacion;

  public function __construct()
  {

    $this->rnumeroempleado = "";
    $this->rnumerolicencia = "";
    $this->rnombre = "";
    $this->rapellido = "";
  }

  public function setrnumeroempleado($rnumeroempleado)
  {
    $this->rnumeroempleado = $rnumeroempleado;
  }

  public function getrnumeroempleado()
  {
    return $this->rnumeroempleado;
  }

  public function setrnumerolicencia($rnumerolicencia)
  {
    $this->rnumerolicencia = $rnumerolicencia;
  }

  public function getrnumerolicencia()
  {
    return $this->rnumerolicencia;
  }

  public function setrnombre($rnombre)
  {
    $this->rnombre = $rnombre;
  }

  public function getrnombre()
  {
    return $this->rnombre;
  }

  public function setrapellido($rapellido)
  {
    $this->rapellido = $rapellido;
  }
  public function getrapellido()
  {
    return $this->rapellido;
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
      "\nNombre: " . $this->getrnombre() . " " . $this->getrapellido() .
      "\nEmpleado N° " . $this->getrnumeroempleado() .
      "\nLicencia N° " . $this->getrnumerolicencia() . "\n";
  }

  public function cargar($rnumerolicencia, $rnombre, $rapellido)
  {
    $this->setrnumerolicencia($rnumerolicencia);
    $this->setrnombre($rnombre);
    $this->setrapellido($rapellido);
  }

  /**
   * Recupera los datos de un responsable por su número de empleado
   * @param int $numeroempleado
   * @return bool
   */
  public function Buscar($numeroempleado)
  {
    $base = new BaseDatos();
    $consultaResponsable = "Select * from responsable where rnumeroempleado=" . $numeroempleado;
    $seEncontro = false;
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consultaResponsable)) {
        if ($row2 = $base->Registro()) {
          $this->setrnumeroempleado($numeroempleado);
          $this->setrnumerolicencia($row2['rnumerolicencia']);
          $this->setrnombre($row2['rnombre']);
          $this->setrapellido($row2['rapellido']);
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
    $arregloResponsable = null;
    $base = new BaseDatos();
    $consultaResponsables = "Select * from responsable ";
    if ($condicion != "") {
      $consultaResponsables = $consultaResponsables . ' where ' . $condicion;
    }
    $consultaResponsables .= " order by rapellido ";
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consultaResponsables)) {
        $arregloResponsable = array();
        while ($row2 = $base->Registro()) {

          $numeroempleado = $row2['rnumeroempleado'];
          $numerolicencia = $row2['rnumerolicencia'];
          $nombre = $row2['rnombre'];
          $apellido = $row2['rapellido'];

          $responsable = new ResponsableV();
          $responsable->cargar($numeroempleado, $numerolicencia, $nombre, $apellido);
          array_push($arregloResponsable, $responsable);

        }


      } else {
        $this->setmensajeoperacion($base->getError());

      }
    } else {
      $this->setmensajeoperacion($base->getError());

    }
    return $arregloResponsable;
  }


  public function insertar()
  {
    $base = new BaseDatos();
    $seInserto = false;
    $consultaInsertar = "INSERT INTO responsable(rnumerolicencia, rnombre,  rapellido) 
				VALUES ('" . $this->getrnumerolicencia() . "','" . $this->getrnombre() . "','" . $this->getrapellido() . "')";

    if ($base->Iniciar()) {

      if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
        $this->setrnumeroempleado($id);
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
    $consultaModifica = "UPDATE responsable SET rnumerolicencia='" . $this->getrnumerolicencia() .
      "',rnombre='" . $this->getrnombre() .
      "' ,rapellido='" . $this->getrapellido() .
      "' WHERE rnumeroempleado=" . $this->getrnumeroempleado();
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
      $consultaBorra = "DELETE FROM responsable WHERE rnumeroempleado=" . $this->getrnumeroempleado();
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