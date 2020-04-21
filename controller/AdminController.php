<?php

class AdminController extends AutorizacijaController
{
    public function __construct()
    {
        parent::__construct();
        if($_SESSION['operater']->oUloga!=='admin'){
            $ic = new IndexController();
            $ic->odjava();
            exit;
           
        }
    }
}