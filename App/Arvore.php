<?php

//Se existe a classe Elemento carregada
if(!class_exists("Elemento"))
{
    require_once 'Elemento.php';
}

class Arvore
{
    // Atributos

    private $_raiz = NULL;

    private $_numNodos = 0;

    // Propriedades
    
    public function GetRaiz()
    {
        return $this->_raiz;
    }

    public function Count()
    {
        return (int) $this->_numNodos;
    }

    // Métodos

    public function Add($elem)
    {
        if(empty($elem))
            throw new Exception("Elemento é nulo!");
            
        if(!is_a($elem, 'Elemento'))
            $elem = new Elemento($elem);
        
        if($this->estaVazia())
            $this->AddRaiz($elem);
        else
            $this->addIn($this->GetRaiz(), $elem);
        

        return FALSE;
    }

    public function Existe($elem)
    {
        if(empty($elem))
            return FALSE;

        if(!is_a($elem, 'Elemento'))
            $elem = new Elemento($elem);

        return $this->existeIn($this->GetRaiz(), $elem);
    }

    private function existeIn($raiz, $elem)
    {
        if($raiz->GetIdentificador() === $elem->GetIdentificador())
            return TRUE;

        if($raiz->TemFilho())
        {
            if($raiz->TemFilhoEsquerda())
            {
                if($elem->GetIdentificador() <= $raiz->GetIdentificador())
                {
                    if($this->existeIn($raiz->GetElemEsquerda(), $elem) === TRUE)
                    {
                        return TRUE;
                    }

                }
            }

            if($raiz->TemFilhoDireita())
            {
                if($elem->GetIdentificador() > $raiz->GetIdentificador())
                {
                    if($this->existeIn($raiz->GetElemDireita(), $elem) === TRUE)
                    {
                        return TRUE;
                    }

                }
            }
        }

        return FALSE;
    }

    public function estaVazia()
    {
        if($this->GetRaiz() == NULL)
            return TRUE;
        else
            return FALSE;
    }

    private function addIn($raiz, $elem)
    {
        if($elem->GetIdentificador() <= $raiz->GetIdentificador())
        {
            if($raiz->TemFilhoEsquerda())
            {
                $this->addIn($raiz->GetElemEsquerda(), $elem);
            }
            else
            {
                $raiz->SetElemEsquerda($elem);

                $this->increment();
            }
        }
        else
        {
            if($raiz->TemFilhoDireita())
            {
                $this->addIn($raiz->GetElemDireita(), $elem);
            }
            else
            {
                $raiz->SetElemDireita($elem);

                $this->increment();
            }
        }
    }

    private function AddRaiz($elem)
    {
        $this->_raiz = $elem;

        $this->increment();
    }

    private function increment()
    {
        $this->_numNodos++;
    }

    public function hierarquica()
    {
        if(!$this->estaVazia())
            return $html = "<div id=\"arvore\">"
                            ."<ul class=\"inicio\">"
                                ."<li>"
                                    ."<span class=\"valor\">{$this->GetRaiz()->GetIdentificador()}</span>"

                                    ."{$this->hierarquicaInterna( $this->GetRaiz() )}"
                                ."</li>"
                            ."</ul>"
                        ."</div>";
    }

    private function hierarquicaInterna($raiz)
    { 
        $html = "";

        if($raiz->TemFilhoEsquerda())
        {
            $html .= "<ul class=\"esquerda\">"
                        ."<li>"
                            ."<span class=\"valor\">{$raiz->GetElemEsquerda()->GetIdentificador()}</span>"

                            ."{$this->hierarquicaInterna( $raiz->GetElemEsquerda() )}"
                        ."</li>"
                    ."</ul>";
        }
        
        if($raiz->TemFilhoDireita())
        {
            $html .= "<ul class=\"direita\">"
                        ."<li>"
                            ."<span class=\"valor\">{$raiz->GetElemDireita()->GetIdentificador()}</span>"

                            ."{$this->hierarquicaInterna( $raiz->GetElemDireita() )}"
                        ."</li>"
                    ."</ul>";
        }

        return $html;
    }

    // Listagem
    public function listar($ordem = NULL)
    {
        $ordens = 
            array(
                "preOrdem" => join(',', $this->preOrdem($this->GetRaiz())),
                "emOrdem" => join(',', $this->emOrdem($this->GetRaiz())),
                "posOrdem" => join(',', $this->posOrdem($this->GetRaiz()))
            );

        if( is_null($ordem) )
            return $ordens;
        
        if( is_array($ordem) )
        {
            $return = array();

            if( in_array('preOrdem', $ordem) )
                $return['preOrdem'] = $ordens['preOrdem'];

            if( in_array('emOrdem', $ordem) )
                $return['emOrdem'] = $ordens['emOrdem'];

            if( in_array('posOrdem', $ordem) )
                $return['posOrdem'] = $ordens['posOrdem'];

            return $return;
        }

        if( $ordem == 'preOrdem' )
            return $ordens['preOrdem'];

        if( $ordem == 'emOrdem' )
            return $ordens['emOrdem'];

        if( $ordem == 'posOrdem' )
            return $ordens['posOrdem'];
    }

    private function emOrdem($raiz) //ERD
    {
        $list = array();

        if( $raiz->TemFilhoEsquerda() )
        {
            $emOrdem = $this->emOrdem( $raiz->GetElemEsquerda() );

            $list = array_merge($list, $emOrdem);
        }

        $list[] = $raiz->GetIdentificador();

        if( $raiz->TemFilhoDireita() )
        {
            $emOrdem = $this->emOrdem( $raiz->GetElemDireita() );

            $list = array_merge($list, $emOrdem);
        }

        return $list;    
    }

    private function posOrdem($raiz) //EDR
    {
        $list = array();

        if( $raiz->TemFilhoEsquerda() )
        {
            $emOrdem = $this->posOrdem( $raiz->GetElemEsquerda() );

            $list = array_merge($list, $emOrdem);
        }

        if( $raiz->TemFilhoDireita() )
        {
            $emOrdem = $this->posOrdem( $raiz->GetElemDireita() );

            $list = array_merge($list, $emOrdem);
        }

        $list[] = $raiz->GetIdentificador();

        return $list;    
    }

    private function preOrdem($raiz) //RED
    {
        $list = array();

        $list[] = $raiz->GetIdentificador();

        if( $raiz->TemFilhoEsquerda() )
        {
            $emOrdem = $this->preOrdem( $raiz->GetElemEsquerda() );

            $list = array_merge($list, $emOrdem);
        }

        if( $raiz->TemFilhoDireita() )
        {
            $emOrdem = $this->preOrdem( $raiz->GetElemDireita() );

            $list = array_merge($list, $emOrdem);
        }

        return $list;    
    }

    // Métodos mágicos

    public function __invoke($elem)
    {
        $this->Add($elem);
    }

    public function __toString()
    {
        $ex = "A classe <b>Arvore</b> é a implementação de uma árvore binária em PHP<br>";
        $ex .= "Desenvolvido por <u>Eduardo Marques</u><br>";
        $ex .= "<br>Ulbra Campus Torres<br>Estrutura de dados 2";

        return $ex;
    }
}