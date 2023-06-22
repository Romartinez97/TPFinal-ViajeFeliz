<?php

include_once("BaseDatos.php");
include_once("clasePasajero.php");
include_once("claseResponsableV.php");
include_once("claseViaje.php");

class Empresa
{
    private $idempresa;
    private $enombre;
    private $edireccion;
    private $coleccionviajes;
    private $mensajeoperacion;

    public function __construct()
    {

        $this->idempresa = "";
        $this->enombre = "";
        $this->edireccion = "";
        $this->coleccionviajes = [];
    }

    public function setidempresa($idempresa)
    {
        $this->idempresa = $idempresa;
    }

    public function getidempresa()
    {
        return $this->idempresa;
    }

    public function setenombre($enombre)
    {
        $this->enombre = $enombre;
    }

    public function getenombre()
    {
        return $this->enombre;
    }

    public function setedireccion($edireccion)
    {
        $this->edireccion = $edireccion;
    }

    public function getedireccion()
    {
        return $this->edireccion;
    }
    public function setcoleccionviajes($coleccionviajes)
    {
        $this->coleccionviajes = $coleccionviajes;
    }

    public function getcoleccionviajes()
    {
        return $this->coleccionviajes;
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
            "\nID empresa N°: " . $this->getidempresa() .
            "\nNombre de la empresa: " . $this->getenombre() .
            "\nDirección: " . $this->getedireccion() .
            "\nLista de viajes: " . $this->mostrarViajes() . "\n";
    }

    /**
     * Función para poder mostrar en pantalla la lista de viajes de una empresa.
     * @return string
     */
    public function mostrarViajes()
    {
        $listaViajes = $this->getcoleccionviajes();
        $texto = " ";
        for ($i = 0; $i < count($listaViajes); $i++) {
            $texto = $texto . $listaViajes[$i];
        }
        return $texto;
    }

    public function cargar($enombre, $edireccion, $coleccionviajes)
    {
        $this->setenombre($enombre);
        $this->setedireccion($edireccion);
        $this->setcoleccionviajes($coleccionviajes);
    }

    /**
     * Recupera los datos de una empresa por su ID
     * @param int $idempresa
     * @return bool
     */
    public function Buscar($idempresa)
    {
        $base = new BaseDatos();
        $consultaViaje = "Select * from empresa where idempresa=" . $idempresa;
        $seEncontro = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViaje)) {
                if ($row2 = $base->Registro()) {
                    $this->setidempresa($idempresa);
                    $this->setenombre($row2['enombre']);
                    $this->setedireccion($row2['edireccion']);
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
                    $idempresa = $row2['idempresa'];
                    $enombre = $row2['enombre'];
                    $edireccion = $row2['edireccion'];

                    $empresa = new Empresa();
                    $empresa->cargar($idempresa, $enombre, $edireccion);
                    array_push($arregloEmpresas, $empresa);

                }


            } else {
                $this->setmensajeoperacion($base->getError());

            }
        } else {
            $this->setmensajeoperacion($base->getError());

        }
        return $arregloEmpresas;
    }


    public function insertar()
    {
        $base = new BaseDatos();
        $seInserto = false;
        $consultaInsertar = "INSERT INTO empresa(enombre, edireccion) 
				VALUES ('" . $this->getenombre() . "','" .
            $this->getedireccion() . "')";

        if ($base->Iniciar()) {

            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setidempresa($id);
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
        $consultaModifica = "UPDATE empresa SET enombre='" . $this->getenombre() .
            "',edireccion='" . $this->getedireccion() .
            "' WHERE idempresa=" . $this->getidempresa();
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
            $consultaBorra = "DELETE FROM empresa WHERE idempresa=" . $this->getidempresa();
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