<?php
class ZaposlenikController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'zaposlenik' .
    DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Zaposlenik::readAll(),
         'hoteli'=>Hotel::readAll()
     ]);
    }

    public function obrisi()
    {
        //prvo dođu silne kontrole
        if(Zaposlenik::delete()){
            header('location: /zaposlenik/index');
        }
        
    }

    public function promjena()
    {
        $zaposlenik = Zaposlenik::read($_GET['ID_zaposlenik']);
        if(!$zaposlenik){
            $this->index();
            exit;
        }

        $this->detalji($zaposlenik);
    }

    public function promjeni()
    {
        // I OVDJE DOĐU SILNE KONTROLE
        print_r($_POST);
        Zaposlenik::update();
        $this->index();
    }

    public function novi()
    {
        if(!isset($_POST['hotel']) || 
        $_POST['hotel']=='0'){
            $this->view->render($this->viewDir . 'index',[
                'podaci'=>Zaposlenik::readAll(),
                'hoteli' => Hotel::readAll(),
                'alertPoruka'=>'Morate odabrati hotel'
            ]);
            return;
        }

        $IDNovogZaposlenika=Zaposlenik::create($_POST['hotel']);
        $zaposlenik = Zaposlenik::read($IDNovogZaposlenika);
        $this->detalji($zaposlenik);
    }

   

    private function detalji($zaposlenik)
    {
        $this->view->render($this->viewDir . 'detalji',[
            'zaposlenik'=>$zaposlenik,
            'hoteli' => Hotel::readAll()
            ]);
    }
}