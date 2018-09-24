<?php

define('DBPATH', APPPATH.DS.'db');

class DB
{
    private $_dbname;

    private $_table;

    private $_result;

    private $_fopen = NULL;

    public function __construct($db)
    {
        if(is_null($db))
            $db = 'db';

        $this->_dbname = $db;
    }

    private function _folder()
    {
        if( !file_exists(DBPATH) )
            mkdir(DBPATH, 0777, true);

        if( !file_exists(DBPATH.DS.$this->_dbname))
            mkdir(DBPATH.DS.$this->_dbname, 0777, true);
 
        return DBPATH.DS.$this->_dbname.DS.$this->_table.'.json';
    }

    private function _read()
    {
        if(is_null($this->_fopen))
            $this->_open();

        $file = file($this->_folder());

        if(!empty($file))
        {
            $json = $file;

            if(is_array($json))
                $json = json_decode($json[0], true);
            else
                $json = json_decode(array($json), true);
            
            return $json;
        }
            
        return array();
    }

    private function _open()
    {
        $this->_fopen = fopen($this->_folder(), (file_exists($this->_folder()) ? 'r+' : 'w+'));

        return $this->_fopen;
    }

    private function _close()
    {
        if(!is_null($this->_fopen))
        {
            fclose($this->_fopen);
            $this->_fopen = NULL;
        }
    }

    private function _write($content)
    {
        $json = $this->_read();
       
        $json[] = $content;

        $insert = json_encode($json);

        fwrite($this->_open(), $insert);
    }

    private function _table($table)
    {
        $this->_table = $table;
    }

    private function _result()
    {
        $this->_close();

        return $this->_read();
    }

    private function _insert($content)
    {
        if(is_object($content))
            $content = (array) $content;

        if(is_null($content))
            throw new Exception("Content is null");
        
        if(is_array($content))
        {
            foreach ($content as $value) {
                $this->_write($value);
            }
        }
        else
        {
            $this->_write($content);
        }


        $this->_close();
    }

    private function _drop()
    {
        $this->_close();

        unlink($this->_folder());
    }

    public function insert($table, $content)
    {
        $this->_table($table);

        $this->_insert($content);

        return $this;
    }

    public function get($table)
    {
        $this->_table($table);

        return $this;
    }

    public function truncate($table)
    {
        $this->_table($table);

        $this->_drop();

        $this->_open();
        $this->_close();
    }

    public function result()
    {
        return $this->_result();
    }
}