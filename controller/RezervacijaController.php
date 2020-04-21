<?php
class RezervacijaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'rezervacija' .
    DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Rezervacija::readAll(),
         'hoteli'=>Hotel::readAll()
     ]);
    }

    public function obrisi()
    {
        //prvo dođu silne kontrole
        if(Rezervacija::delete()){
            header('location: /rezervacija/index');
        } 
    }

    public function promjena()
    {
        $rezervacija = Rezervacija::read($_GET['ID_rezervacija']);
        if(!$zaposlenik){
            $this->index();
            exit;
        }

        $this->detalji($rezervacija);
    }

    public function promjeni()
    {
        // I OVDJE DOĐU SILNE KONTROLE
        Rezervacija::update();
        $this->index();
    }

    public function novi()
    {
        if(!isset($_POST['hotel']) || 
        $_POST['hotel']=='0'){
            $this->view->render($this->viewDir . 'index',[
                'podaci'=>Rezervacija::readAll(),
                'hoteli' => Hotel::readAll(),
                'alertPoruka'=>'Morate odabrati hotel'
            ]);
            return;
        }

        $IDNovaRezervacije=Rezervacija::create($_POST['hotel'],$_POST['gost']);
        $rezervacija = Rezervacija::read($IDNovaRezervacije);
        $this->detalji($rezervacija);

        
    }

   

    private function detalji($rezervacija)
    {
        $this->view->render($this->viewDir . 'detalji',[
            'rezervacija'=>$rezervacija,
            'hoteli' => Hotel::readAll(),
            'gosti' => Gost::readAll(),
            ]);
    }
}