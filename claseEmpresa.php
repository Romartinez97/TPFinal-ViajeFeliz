<?php

include_once("BaseDatos.php");
include_once("clasePasajero.php");
include_once("claseResponsableV.php");
include_once("claseViaje.php");

class Empresa
{
    private $idEmpresa;
    private $eNombre;
    private $eDireccion;
    private $coleccionViajes;
    private $mensajeOperacion;

    public function __construct()
    {

        $this->idEmpresa = 0;
        $this->eNombre = "";
        $this->eDireccion = "";
        $this->coleccionViajes = [];
    }

    public function setIDEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function getIDEmpresa()
    {
        return $this->idEmpresa;
    }

    public function seteNombre($eNombre)
    {
        $this->eNombre = $eNombre;
    }

    public function geteNombre()
    {
        return $this->eNombre;
    }

    public function seteDireccion($eDireccion)
    {
        $this->eDireccion = $eDireccion;
    }

    public function geteDireccion()
    {
        return $this->eDireccion;
    }
    public function setColeccionViajes($coleccionViajes)
    {
        $this->coleccionViajes = $coleccionViajes;
    }

    public function getColeccionViajes()
    {
        return $this->coleccionViajes;
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
            "\n-----EMPRESA N° " . $this->getIDEmpresa() . "-----" .
            "\nNombre de la empresa: " . $this->geteNombre() .
            "\nDirección: " . $this->geteDireccion() .
            "\nLista de viajes: " . $this->mostrarViajes() . "\n";
    }

    /**
     * Función para poder mostrar en pantalla la lista de viajes de una empresa.
     * @return string
     */
    public function mostrarViajes()
    {
        $listaViajes = $this->getColeccionViajes();
        $texto = " ";
        for ($i = 0; $i < count($listaViajes); $i++) {
            $texto = $texto . $listaViajes[$i];
        }
        return $texto;
    }

    public function cargar($idEmpresa, $eNombre, $eDireccion, $coleccionViajes)
    {
        $this->setIDEmpresa($idEmpresa);
        $this->seteNombre($eNombre);
        $this->seteDireccion($eDireccion);
        $this->setColeccionViajes($coleccionViajes);
    }

    /**
     * Recupera los datos de una empresa por su ID
     * @param int $idEmpresa
     * @return bool
     */
    public function buscar($idEmpresa)
    {
        $base = new BaseDatos();
        $consultaViaje = "Select * from empresa where idempresa=" . $idEmpresa;
        $seEncontro = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViaje)) {
                if ($row2 = $base->Registro()) {
                    $this->setIDEmpresa($idEmpresa);
                    $this->seteNombre($row2['enombre']);
                    $this->seteDireccion($row2['edireccion']);
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
        $arregloEmpresas = null;
        $base = new BaseDatos();
        $consultaEmpresas = "Select * from empresa ";
        if ($condicion != "") {
            $consultaEmpresas = $consultaEmpresas . ' where ' . $condicion;
        }
        $consultaEmpresas .= " order by enombre ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEmpresas)) {
                $arregloEmpresas = array();
                while ($row2 = $base->Registro()) {
                    $idEmpresa = $row2['idempresa'];

                    $objViaje = new Viaje();
                    $coleccionViajes = $objViaje->listar("idempresa=" . $idEmpresa);

                    $empresa = new Empresa();
                    $empresa->cargar(
                        $row2['idempresa'],
                        $row2['enombre'],
                        $row2['edireccion'],
                        $coleccionViajes
                    );
                    array_push($arregloEmpresas, $empresa);

                }


            } else {
                $this->setMensajeOperacion($base->getError());

            }
        } else {
            $this->setMensajeOperacion($base->getError());

        }
        return $arregloEmpresas;
    }


    public function insertar()
    {
        $base = new BaseDatos();
        $seInserto = false;
        $consultaInsertar = "INSERT INTO empresa(enombre, edireccion) 
				VALUES ('" . $this->geteNombre() . "','" .
            $this->geteDireccion() . "')";

        if ($base->Iniciar()) {

            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setIDEmpresa($id);
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
        $consultaModifica = "UPDATE empresa SET enombre='" . $this->geteNombre() .
            "',edireccion='" . $this->geteDireccion() .
            "' WHERE idempresa=" . $this->getIDEmpresa();
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
            $consultaBorra = "DELETE FROM empresa WHERE idempresa=" . $this->getIDEmpresa();
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