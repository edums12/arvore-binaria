<?php

class App
{
    public $arvore;

    public function __construct()
    {
        $this->arvore = new Arvore();

        $this->index();
    }

    public function index()
    {
        $this->arvore->add(2);
        $this->arvore->add(4);
        $this->arvore->add(10);
        $this->arvore->add(5);
        $this->arvore->add(34);
        $this->arvore->add(3);
        $this->arvore->add(12);
        $this->arvore->add(1);

        $valor = 3;
        
        echo "Contém o valor $valor na árvore? " . ($this->arvore->Existe($valor) ? 'Sim' : 'Não');
        
        $arvore = $this->arvore->hierarquica();

        require_once 'tela.php';
    }
}