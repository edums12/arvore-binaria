<?php

class Elemento
{
    private $_identificador = 0;

    private $_elemEsquerda = NULL;

    private $_elemDireita = NULL;

    public function __construct($pIdentificador)
    {
        $this->_identificador = $pIdentificador;
    }

    public function GetIdentificador()
    {
        return (int) $this->_identificador;
    }

    public function GetElemEsquerda()
    {
        return $this->_elemEsquerda;
    }

    public function GetElemDireita()
    {
        return $this->_elemDireita;
    }

    public function SetElemEsquerda($pElemEsquerda)
    {
        $this->_elemEsquerda = $pElemEsquerda;
    }

    public function SetElemDireita($pElemDireita)
    {
        $this->_elemDireita = $pElemDireita;
    }

    public function TemFilho()
    {
        if($this->GetElemDireita())
            return true;

        if($this->GetElemEsquerda())
            return true;

        return false;
    }

    public function TemFilhoEsquerda()
    {
        if($this->GetElemEsquerda())
            return true;

        return false;
    }

    public function TemFilhoDireita()
    {
        if($this->GetElemDireita())
            return true;

        return false;
    }

    public function __invoke($pIdentificador)
    {
        $this->__construct($pIdentificador);
    }
}