<?php

class HotelController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'hotel' .
    DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Hotel::readAll()
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
        Hotel::create();
        $this->index();
    }

    public function obrisi()
    {
        //prvo dođu silne kontrole
        if(Hotel::delete()){
            header('location: /hotel/index');
        }
        
    }

    public function promjena()
    {
        $hotel = Hotel::read($_GET['ID_hotel']);
        if(!$hotel){
            $this->index();
            exit;
        }

        $this->view->render($this->viewDir . 'promjena',
            ['hotel'=>$hotel,
                'poruka'=>'Promjenite željene podatke']
        );
     
    }

    public function promjeni()
    {
        // I OVDJE DOĐU SILNE KONTROLE
        Hotel::update();
        header('location: /hotel/index');
    }
}