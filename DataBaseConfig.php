<?php

class DataBaseConfig
{
    public $servername;
    public $username;
    public $password;
    public $databasename;

    public function __construct()
    {

       /*$this->servername = 'remotemysql.com';
        $this->username = '7LHzcHuC1k';
        $this->password = 'VmMDKMmHnw';
        $this->databasename = '7LHzcHuC1k';*/
         $this->servername = 'localhost';
        $this->username = 'root';
        $this->password = '';
        $this->databasename = 'streaming';

    }
}

?>
