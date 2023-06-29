<?php

include_once("BaseDatos.php");
include_once("claseResponsableV.php");
include_once("claseViaje.php");
include_once("claseEmpresa.php");
class Pasajero
{
  private $pNombre;
  private $pApellido;
  private $pDocumento;
  private $pTelefono;
  private $idViaje;
  private $mensajeOperacion;

  public function __construct()
  {

    $this->pDocumento = "";
    $this->pNombre = "";
    $this->pApellido = "";
    $this->pTelefono = "";
    $this->idViaje = "";
  }

  public function setpNombre($pNombre)
  {
    $this->pNombre = $pNombre;
  }

  public function getpNombre()
  {
    return $this->pNombre;
  }

  public function setpApellido($pApellido)
  {
    $this->pApellido = $pApellido;
  }

  public function getpApellido()
  {
    return $this->pApellido;
  }

  public function setpDocumento($pDocumento)
  {
    $this->pDocumento = $pDocumento;
  }

  public function getpDocumento()
  {
    return $this->pDocumento;
  }

  public function setpTelefono($pTelefono)
  {
    $this->pTelefono = $pTelefono;
  }

  public function getpTelefono()
  {
    return $this->pTelefono;
  }

  public function setIDViaje($idViaje)
  {
    $this->idViaje = $idViaje;
  }

  public function getIDViaje()
  {
    return $this->idViaje;
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
      "\n-----PASAJERO----" .
      "\nNombre: " . $this->getpNombre() .
      "\nApellido: " . $this->getpApellido() .
      "\nDNI N° " . $this->getpDocumento() .
      "\nTeléfono N° " . $this->getpTelefono() .
      "\nAsociado al viaje N° " . $this->getIDViaje() . "\n";
  }

  public function cargar($documento, $nombre, $apellido, $telefono, $idViaje)
  {
    $this->setpDocumento($documento);
    $this->setpNombre($nombre);
    $this->setpApellido($apellido);
    $this->setpTelefono($telefono);
    $this->setIDViaje($idViaje);
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
          $this->setpDocumento($documento);
          $this->setpNombre($row2['pnombre']);
          $this->setpApellido($row2['papellido']);
          $this->setpTelefono($row2['ptelefono']);
          $this->setIDViaje($row2['idviaje']);
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
    $arregloPersona = null;
    $base = new BaseDatos();
    $consultaPersonas = "Select * from pasajero ";
    if ($condicion != "") {
      $consultaPersonas .= ' where ' . $condicion;
    }
    $consultaPersonas .= " order by papellido ";   
    if ($base->Iniciar()) {
      if ($base->Ejecutar($consultaPersonas)) {
        $arregloPersona = array();
        while ($row2 = $base->Registro()) {

          $pasajero = new Pasajero();
          $pasajero->cargar(
            $row2['pdocumento'],
            $row2['pnombre'],
            $row2['papellido'],
            $row2['ptelefono'],
            $row2['idviaje']
          );
          array_push($arregloPersona, $pasajero);

        }


      } else {
        $this->setMensajeOperacion($base->getError());

      }
    } else {
      $this->setMensajeOperacion($base->getError());

    }
    return $arregloPersona;
  }


  public function insertar()
  {
    $base = new BaseDatos();
    $seInserto = false;
    $consultaInsertar = "INSERT INTO pasajero(pdocumento, pnombre, papellido,  ptelefono, idviaje) 
				VALUES (" . $this->getpDocumento() . ",'" .
      $this->getpNombre() . "','" .
      $this->getpApellido() . "','" .
      $this->getpTelefono() . "','" .
      $this->getIDViaje() . "')";

    if ($base->Iniciar()) {

      if ($base->Ejecutar($consultaInsertar)) {

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
    $consultaModifica = "UPDATE pasajero SET pnombre='" . $this->getpNombre() .
      "',papellido='" . $this->getpApellido() .
      "' ,ptelefono='" . $this->getpTelefono() .
      "',idviaje='" . $this->getIDViaje() .
      "' WHERE pdocumento=" . $this->getpDocumento();
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
      $consultaBorra = "DELETE FROM pasajero WHERE pdocumento=" . $this->getpDocumento();
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