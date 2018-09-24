<?php

class App
{
    public $arvore;

    protected $db;

    public function __construct()
    {
        $this->arvore = new Arvore();

        $this->db = new DB('arvore');

        if( !empty($this->db->get('arvore')->result()) )
            $this->load();

        if( !empty($_GET['action']) )
            $this->actions();
        
        $this->index();
    }

    public function index()
    {
        $arvore_binaria = new StdClass();

        $arvore_binaria->tabela = 
            array(
                "Raiz:"         => (!empty($this->arvore->GetRaiz()) ? $this->arvore->GetRaiz()->GetIdentificador() : ""),
                "Nº de nós:"    => $this->arvore->Count(),
                "Em Ordem:"     => $this->arvore->Listar('emOrdem'),
                "Pré Ordem:"    => $this->arvore->Listar('preOrdem'),
                "Pós Ordem:"    => $this->arvore->Listar('posOrdem'),
                "Menor Valor:"  => $this->arvore->GetMenor(),
                "Maior Valor:"  => $this->arvore->GetMaior()
            );

        $arvore_binaria->resumo = $this->arvore->GetResumo();

        require_once 'tela.php';
    }

    public function add( $elemento )
    {
        $this->db->insert('arvore', trim($elemento));

        $this->arvore->Add(trim($elemento));
        
        redirect();
    }

    public function reorder()
    {
        $arvore = $this->arvore->Reordenar();

        $this->db->truncate('arvore');

        $this->db->insert('arvore', $arvore->nos());

        redirect();
    }

    public function limpar()
    {
        $this->db->truncate('arvore');

        redirect();
    }

    public function existe()
    {
        if( $this->arvore->Existe($_POST['elemento']) )
        {
            new Alert('success', 'Elemento encontrado!');
        }
        else
        {
            new Alert('warning', 'Elemento não encontrado!');
        }

        redirect();
    }

    private function actions()
    {
        switch( $_GET['action'] )
        {
            case 'add':
                $this->Add( $_POST['elemento'] );
                break;
            case 'reorder':
                $this->Reorder();
                break;
            case 'limpar':
                $this->Limpar();
                break;
            case 'existe':
                $this->Existe();
                break;
        }
    }

    public function load()
    {
        $nodos = $this->db->get('arvore')->result();

        foreach ($nodos as $i => $no) {
            $this->arvore->Add($no);
        }
    }
    
}