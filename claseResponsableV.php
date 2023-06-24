<?php

include_once("BaseDatos.php");
include_once("clasePasajero.php");
include_once("claseViaje.php");
include_once("claseEmpresa.php");

class ResponsableV
{
  private $rNumeroEmpleado;
  private $rNumeroLicencia;
  private $rNombre;
  private $rApellido;
  private $mensajeOperacion;

  public function __construct()
  {

    $this->rNumeroEmpleado = "";
    $this->rNumeroLicencia = "";
    $this->rNombre = "";
    $this->rApellido = "";
  }

  public function setrNumeroEmpleado($rNumeroEmpleado)
  {
    $this->rNumeroEmpleado = $rNumeroEmpleado;
  }

  public function getrNumeroEmpleado()
  {
    return $this->rNumeroEmpleado;
  }

  public function setrNumeroLicencia($rNumeroLicencia)
  {
    $this->rNumeroLicencia = $rNumeroLicencia;
  }

  public function getrNumeroLicencia()
  {
    return $this->rNumeroLicencia;
  }

  public function setrNombre($rNombre)
  {
    $this->rNombre = $rNombre;
  }

  public function getrNombre()
  {
    return $this->rNombre;
  }

  public function setrApellido($rApellido)
  {
    $this->rApellido = $rApellido;
  }
  public function getrApellido()
  {
    return $this->rApellido;
  }

  public function setMensajeOperacion($mensajeOperacion)
  {
    $this->mensajeOperacion = $mensajeOperacion;
  }

  public function getMensajeOperacion()
  {
    return $this->mensajeOperacion;
  }

  public function __toString()
  {
    return
      "\n-----EMPLEADO N° " . $this->getrNumeroEmpleado() . "-----" .
      "\nNombre: " . $this->getrNombre() .
      "\nApellido: " . $this->getrApellido() .
      "\nLicencia N° " . $this->getrNumeroLicencia() . "\n";
  }

  public function cargar($rNumeroLicencia, $rNombre, $rApellido)
  {
    $this->setrNumeroLicencia($rNumeroLicencia);
    $this->setrNombre($rNombre);
    $this->setrApellido($rApellido);
  }

  /**
   * Recupera los datos de un responsable por su número de empleado
   * @param int $numeroEmpleado
   * @return bool
   */
  public function buscar($numeroEmpleado)
  {
    $base = new BaseDatos();
    $consultaResponsable = "Select * from responsable where rnumeroempleado=" . $numeroEmpleado;
    $seEncontro = false;
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consultaResponsable)) {
        if ($row2 = $base->Registro()) {
          $this->setrNumeroEmpleado($numeroEmpleado);
          $this->setrNumeroLicencia($row2['rnumerolicencia']);
          $this->setrNombre($row2['rnombre']);
          $this->setrApellido($row2['rapellido']);
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
          /*
          $numeroempleado = $row2['rnumeroempleado'];
          $numerolicencia = $row2['rnumerolicencia'];
          $nombre = $row2['rnombre'];
          $apellido = $row2['rapellido'];
          */
          $responsable = new ResponsableV();
          $responsable->cargar(
            $row2['rnumerolicencia'],
            $row2['rnombre'],
            $row2['rapellido']
          );
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
				VALUES ('" . $this->getrNumeroLicencia() . "','" . $this->getrNombre() . "','" . $this->getrApellido() . "')";

    if ($base->Iniciar()) {

      if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
        $this->setrNumeroEmpleado($id);
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
    $consultaModifica = "UPDATE responsable SET rnumerolicencia='" . $this->getrNumeroLicencia() .
      "',rnombre='" . $this->getrNombre() .
      "' ,rapellido='" . $this->getrApellido() .
      "' WHERE rnumeroempleado=" . $this->getrNumeroEmpleado();
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
      $consultaBorra = "DELETE FROM responsable WHERE rnumeroempleado=" . $this->getrNumeroEmpleado();
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