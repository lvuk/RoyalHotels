<?php

class GostController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'gost' .
    DIRECTORY_SEPARATOR;

    public function trazi()
    {
        
        $podaci = Gost::trazi($_GET['uvjet']);

        if(count($podaci)===0){
            $podaci = Gost::trazi($_GET['uvjet']);
        }

        $this->view->render($this->viewDir . 'index',[
            'podaci'=>$podaci,
            'uvjet' => $_GET['uvjet']
           ]);
    }

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Gost::readAll()
     ]);
    }

    public function novi()
    {
        $this->view->render($this->viewDir . 'novi',
            ['poruka'=>'Popunite sve tražene podatke']
        );
    }

    public function dodajnovi()
    {
        //prvo dođu sve silne kontrole
        Gost::create();
        $this->index();
    }

    public function obrisi()
    {
        //prvo dođu silne kontrole
        if(Gost::delete()){
            header('location: /gost/index');
        }
        
    }

    public function promjena()
    {
        $gost = Gost::read($_GET['ID_gost']);
        if(!$gost){
            $this->index();
            exit;
        }

        $this->view->render($this->viewDir . 'promjena',
            ['gost'=>$gost,
                'poruka'=>'Promjenite željene podatke']
        );
     
    }

    public function promjeni()
    {
        // I OVDJE DOĐU SILNE KONTROLE
        Gost::update();
        header('location: /gost/index');
    }
}