<?php

include_once("BaseDatos.php");
include_once("claseResponsableV.php");
include_once("claseViaje.php");
include_once("claseEmpresa.php");
class Pasajero
{
  private $pnombre;
  private $papellido;
  private $pdocumento;
  private $ptelefono;
  private $idviaje;
  private $mensajeoperacion;

  public function __construct()
  {

    $this->pdocumento = "";
    $this->pnombre = "";
    $this->papellido = "";
    $this->ptelefono = "";
    $this->idviaje = "";
  }

  public function setpnombre($pnombre)
  {
    $this->pnombre = $pnombre;
  }

  public function getpnombre()
  {
    return $this->pnombre;
  }

  public function setpapellido($papellido)
  {
    $this->papellido = $papellido;
  }

  public function getpapellido()
  {
    return $this->papellido;
  }

  public function setpdocumento($pdocumento)
  {
    $this->pdocumento = $pdocumento;
  }

  public function getpdocumento()
  {
    return $this->pdocumento;
  }

  public function setptelefono($ptelefono)
  {
    $this->ptelefono = $ptelefono;
  }

  public function getptelefono()
  {
    return $this->ptelefono;
  }

  public function setidviaje($idviaje)
  {
    $this->idviaje = $idviaje;
  }

  public function getidviaje()
  {
    return $this->idviaje;
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
      "\nNombre: " . $this->getpnombre() . " " . $this->getpapellido() .
      "\nDNI N° " . $this->getpdocumento() .
      "\nTeléfono N° " . $this->getptelefono() .
      "\nID del viaje: " . $this->getidviaje() . "\n";
  }

  public function cargar($documento, $nombre, $apellido, $telefono, $idviaje)
  {
    $this->setpdocumento($documento);
    $this->setpnombre($nombre);
    $this->setpapellido($apellido);
    $this->setptelefono($telefono);
    $this->setidviaje($idviaje);
  }

  /**
   * Recupera los datos de un pasajero por su documento
   * @param int $documento
   * @return bool
   */
  public function buscar($documento)
  {
    $base = new BaseDatos();
    $consultaPasajero = "Select * from pasajero where pdocumento=" . $documento;
    $seEncontro = false;
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consultaPasajero)) {
        if ($row2 = $base->Registro()) {
          $this->setpdocumento($documento);
          $this->setpnombre($row2['pnombre']);
          $this->setpapellido($row2['papellido']);
          $this->setptelefono($row2['ptelefono']);
          $this->setidviaje($row2['idviaje']);
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
    $arregloPersona = null;
    $base = new BaseDatos();
    $consultaPersonas = "Select * from pasajero ";
    if ($condicion != "") {
      $consultaPersonas = $consultaPersonas . ' where ' . $condicion;
    }
    $consultaPersonas .= " order by papellido";
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consultaPersonas)) {
        $arregloPersona = array();
        while ($row2 = $base->Registro()) {

          $documento = $row2['pdocumento'];
          $nombre = $row2['pnombre'];
          $apellido = $row2['papellido'];
          $telefono = $row2['ptelefono'];
          $idviaje = $row2['idviaje'];

          $pasajero = new Pasajero();
          $pasajero->cargar($documento, $nombre, $apellido, $telefono, $idviaje);
          array_push($arregloPersona, $pasajero);

        }


      } else {
        $this->setmensajeoperacion($base->getError());

      }
    } else {
      $this->setmensajeoperacion($base->getError());

    }
    return $arregloPersona;
  }


  public function insertar()
  {
    $base = new BaseDatos();
    $seInserto = false;
    $consultaInsertar = "INSERT INTO pasajero(pdocumento, pnombre, papellido,  ptelefono, idviaje) 
				VALUES (" . $this->getpdocumento() . ",'" . $this->getpapellido() . "','" . $this->getpnombre() . "','" . $this->getptelefono() . "','" . $this->getidviaje() . "')";

    if ($base->Iniciar()) {

      if ($base->Ejecutar($consultaInsertar)) {

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
    $consultaModifica = "UPDATE pasajero SET pnombre='" . $this->getpnombre() .
      "',papellido='" . $this->getpapellido() .
      "' ,ptelefono='" . $this->getptelefono() .
      "',idviaje='" . $this->getidviaje() .
      "' WHERE pdocumento=" . $this->getpdocumento();
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
      $consultaBorra = "DELETE FROM pasajero WHERE pdocumento=" . $this->getpdocumento();
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