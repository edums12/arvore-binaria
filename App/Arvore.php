<?php

/**
 * Árvore binaria
 * 
 * Aplicação de código aberto desenvolvido em PHP
 * 
 * Colaboração em: Github
 * 
 * @package ArvoreBinaria
 * @author Eduardo Marques
 * @since Versão 1.0.0
 * 
 * @copyright 2018 Eduardo - ArvoreBinaria | Estrutura de Dados II
 */


/**
 * ---------------------------------------------------------------
 * CLASSE - ARVORE PHP
 * ---------------------------------------------------------------
 * 
 * Classe para manter todos os controles de uma árvore binária
 * 
 * @author Eduardo <marqueseduardo72130@gmail.com>
 *  */

    const AB_VERSAO = '1.0.0';

    const SEPARADOR_LISTA = ' > ';

/**
 * Se a classe Elemento não foi carregada ainda, ele carrega
 */
if(file_exists(APPPATH.DS.'App'.DS.'Elemento.php'))
{
    if(!class_exists("Elemento"))
    {
        require_once(APPPATH.DS.'App'.DS.'Elemento.php');
    }
}
else
{
    throw new Exception("Não é possível continuar sem a Classe - Elemento.php");
}

class Arvore
{
    /**
     * Varíavel 'privada' que contém a raíz da Árvore
     *
     * @var Elemento
     */

    private $_raiz = NULL;

    /**
     * Variável 'privada' que armazena a quantidade nós da árvore
     *
     * @var integer
     */
    
    private $_numNodos = 0;

    /* Varíavel 'Array' 'privado' que armazena todas as ações realizadas */
    private $_resumo = array();
    
    /**
     * Função para retornar a raíz da árvore
     *
     * @return Elemento 'Raiz'
     */
    public function GetRaiz()
    {
        return $this->_raiz;
    }

    /**
     * Função para retornar o resumo
     * 
     * @return array 'Resumo'
     */
    public function GetResumo()
    {
        return $this->_resumo;
    }

    /**
     * Função para retornar o número de 'Elementos' adicionados na Árvore
     *
     * @return int
     */
    public function Count()
    {
        return (int) $this->_numNodos;
    }

    /**
     * Função para Adicionar um elemento a uma Àrvore
     *
     * @param Elemento $elem
     * @return boolean
     */
    public function Add($elem)
    {
        /* Se o $elem for nulo é retornada uma Alert */
        if( empty($elem) )
        {
            new Alert("warning", "Elemento é nulo!");
            redirect();
        }
            
        /* Se o $elem não for da classe 'Elemento' é instanciado em um 'Elemento' */
        if( !is_a($elem, 'Elemento') )
        {
            $elem = new Elemento($elem);
        }
        
        /* Se a Árvore estiver vazia, é adicionada uma raíz e iniciada a Árvore */
        if( $this->Vazia() )
        {
            $this->AddRaiz($elem);
        }
        else /* Se não, é adicionado um elemento interno à Árvore */
        {
            $this->addIn($this->GetRaiz(), $elem);
        }
        

        return TRUE;
    }

    /**
     * Função para verificar se existem o 'Elemento' na Árvore
     *
     * @param Elemento $elem
     * @return boolean
     */
    public function Existe($elem)
    {
        /* Se o $elem for nulo é retornada uma Alert */
        if( empty($elem) )
        {
            new Alert("warning", "Elemento é nulo!");
            redirect();
        }

        if( $this->Vazia() )
        {
            new Alert("warning", "Lista vazia!");
            redirect();
        }

        /* Se o $elem não for da classe 'Elemento' é instanciado em um 'Elemento' */
        if( !is_a($elem, 'Elemento') )
        {
            $elem = new Elemento($elem);
        }

        /* Se Existe o 'Elemento' em contexto */
        $find = $this->existeIn($this->GetRaiz(), $elem);
        if( !empty($find) )
        {
            return $elem;
        }
        else
        {
            return FALSE;
        }
    }

    public function Vazia()
    {
        if($this->GetRaiz() == NULL)
            return TRUE;
        else
            return FALSE;
    }

    public function Listar($ordem = NULL)
    {
        if($this->Vazia())
            return null;

        $ordens = 
            array(
                "preOrdem"  => join(SEPARADOR_LISTA, $this->preOrdem($this->GetRaiz())),
                "emOrdem"   => join(SEPARADOR_LISTA, $this->emOrdem($this->GetRaiz())),
                "posOrdem"  => join(SEPARADOR_LISTA, $this->posOrdem($this->GetRaiz()))
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

    public function GetMenor(){
        $emOrdem = $this->Listar('emOrdem');

        if( !is_null($emOrdem) )
        {
            return explode(SEPARADOR_LISTA, $emOrdem)[0]; 
        }
        else
        {
            return null;
        }
    }

    public function GetMaior()
    {
        $emOrdem = $this->Listar('emOrdem');

        if( !is_null($emOrdem) )
        {
            return explode(SEPARADOR_LISTA, $emOrdem)[$this->Count() - 1]; 
        }
        else
        {
            return null;
        }
    }

    public function Reordenar()
    {
        if( !$this->Vazia() && $this->Count() >= 2)
        {
            $emOrdem = explode(SEPARADOR_LISTA, $this->Listar('emOrdem'));

            $PosCentral = 0;

            if( count($emOrdem) % 2 == 0 )
            {
                $PosCentral = intval((count($emOrdem) / 2) + 1);
            }
            else
            {
                $PosCentral = intval(count($emOrdem) / 2);
            }

            $Raiz = $emOrdem[ $PosCentral ];

            $Arvore = new Arvore();

            $Arvore->Add($Raiz);

            foreach ($emOrdem as $posicao => $elemento) {
                if( $posicao != ($PosCentral - 1) )
                {
                    $Arvore->Add($elemento);
                }
            }

            if( $this->Count() == $Arvore->Count() )
            {
                return $Arvore;
            }
            else
            {
                new Alert("warning", "Não foi possível concluir a operação!");
                redirect();
            }
        }
        else
        {
            new Alert("warning", "Não é possível reordernar uma árvore vazia ou com apenas um elemento!");
            redirect();
        }
    }

    public function nos()
    {
        return explode(SEPARADOR_LISTA, $this->Listar('emOrdem'));
    }


    /**
     * Funções privadas...
     */
    private function existeIn($raiz, $elem)
    {
        if($raiz->GetIdentificador() === $elem->GetIdentificador())
            return $elem;

        if($raiz->TemFilho())
        {
            if($raiz->TemFilhoEsquerda())
            {
                if($elem->GetIdentificador() <= $raiz->GetIdentificador())
                {
                    if($this->existeIn($raiz->GetElemEsquerda(), $elem) === $elem)
                    {
                        return $elem;
                    }

                }
            }

            if($raiz->TemFilhoDireita())
            {
                if($elem->GetIdentificador() > $raiz->GetIdentificador())
                {
                    if($this->existeIn($raiz->GetElemDireita(), $elem) === $elem)
                    {
                        return $elem;
                    }

                }
            }
        }

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

                $this->_resumo[] = "{$elem->GetIdentificador()} adicionado à esquerda de {$raiz->GetIdentificador()}";

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

                $this->_resumo[] = "{$elem->GetIdentificador()} adicionado à direita de {$raiz->GetIdentificador()}";

                $this->increment();
            }
        }
    }

    private function AddRaiz($elem)
    {
        $this->_raiz = $elem;

        $this->_resumo[] = "{$elem->GetIdentificador()} adicionado como raiz.";

        $this->increment();
    }

    private function increment()
    {
        $this->_numNodos++;
    }

    private function emOrdem($raiz) //ERD
    {
        $list = array();

        if( $raiz->TemFilhoEsquerda() )
            $list = array_merge($list, $this->emOrdem($raiz->GetElemEsquerda()));

        $list[] = $raiz->GetIdentificador();

        if( $raiz->TemFilhoDireita() )
            $list = array_merge($list, $this->emOrdem($raiz->GetElemDireita()));

        return $list;    
    }

    private function posOrdem($raiz) //EDR
    {
        $list = array();

        if( $raiz->TemFilhoEsquerda() )
            $list = array_merge($list, $this->posOrdem($raiz->GetElemEsquerda()));

        if( $raiz->TemFilhoDireita() )
            $list = array_merge($list, $this->posOrdem($raiz->GetElemDireita()));

        $list[] = $raiz->GetIdentificador();

        return $list;    
    }

    private function preOrdem($raiz) //RED
    {
        $list = array();

        $list[] = $raiz->GetIdentificador();

        if( $raiz->TemFilhoEsquerda() )
            $list = array_merge($list, $this->preOrdem($raiz->GetElemEsquerda()));

        if( $raiz->TemFilhoDireita() )
            $list = array_merge($list, $this->preOrdem($raiz->GetElemDireita()));

        return $list;    
    }

    /**
     * Funções mágicas...
     */
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