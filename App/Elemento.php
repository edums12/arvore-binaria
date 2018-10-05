<?php

class Elemento
{
    private $_identificador = 0;

    private $_elemEsquerda = NULL;

    public $_elemDireita = NULL;

    private $_pai = NULL;

    public function __construct($pIdentificador)
    {
        $this->_identificador = $pIdentificador;
    }

    public function GetIdentificador()
    {
        return (int) $this->_identificador;
    }

    public function SetIdentificador($pIdentificador)
    {
        $this->_identificador = (int) $pIdentificador;
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

    public function TemApenasUmFilho()
    {
        return ($this->TemFilhoDireita() xor $this->TemFilhoEsquerda());
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

    public function TemPai()
    {
        return $this->_pai != NULL;
    }

    public function SetPai($pPai)
    {
        $this->_pai = $pPai;
    }

    public function GetPai()
    {
        return $this->_pai;
    }

    public function FilhoDaEsquerda()
    {
        if( !empty($this->GetPai()->GetElemEsquerda()) && ($this->GetPai()->GetElemEsquerda()->GetIdentificador() == $this->GetIdentificador()) )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function FilhoDaDireita()
    {
        if( !empty($this->GetPai()->GetElemDireita()) && ($this->GetPai()->GetElemDireita()->GetIdentificador() == $this->GetIdentificador()) )
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function __invoke($pIdentificador)
    {
        $this->__construct($pIdentificador);
    }
}