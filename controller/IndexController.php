<?php

class IndexController extends Controller
{

    public function prijava()
    {
        $this->view->render('prijava',[
            'poruka'=>'Unesite pristupne podatke',
            'email'=>''
        ]);
    }
    
    public function era()
    {
        $this->view->render('era');
    }

    public function autorizacija()
    {
        if(!isset($_POST['email']) || 
        !isset($_POST['lozinka'])){
            $this->view->render('prijava',[
                'poruka'=>'Nisu postavljeni pristupni podaci',
                'email' =>''
            ]);
            return;
        }

        if(trim($_POST['email'])==='' || 
        trim($_POST['lozinka'])===''){
            $this->view->render('prijava',[
                'poruka'=>'Pristupni podaci obavezno',
                'email'=>$_POST['email']
            ]);
            return;
        }

        $veza = DB::getInstanca();

        $izraz = $veza->prepare('select * from operater 
                      where oEmail=:email;');
        $izraz->execute(['email'=>$_POST['email']]);
        //$rezultat=$izraz->fetch(PDO::FETCH_OBJ);
        $rezultat=$izraz->fetch();
        if($rezultat==null){
            $this->view->render('prijava',[
                'poruka'=>'Ne postojeći korisnik',
                'email'=>$_POST['email']
            ]);
            return;
        }

        if(!password_verify($_POST['lozinka'],$rezultat->oLozinka)){
            $this->view->render('prijava',[
                'poruka'=>'Neispravna kombinacija email i lozinka',
                'email'=>$_POST['email']
            ]);
            return;
        }
        unset($rezultat->oLozinka);
        $_SESSION['operater']=$rezultat;
        //$this->view->render('privatno' . DIRECTORY_SEPARATOR . 'nadzornaPloca');
        $npc = new NadzornaplocaController();
        $npc->index();
    }

    public function odjava()
    {
        unset($_SESSION['operater']);
        session_destroy();
        $this->index();
    }

    public function index()
    {
        $poruka='hello iz kontrolera';
        $kod=22;

       
        $this->view->render('pocetna',[
            'p'=>$poruka,
            'k'=>$kod]
        );


    }

    public function registracija()
    {
        $this->view->render('registracija');
    }
  
    public function registrirajnovi()
    {
        //prvo dođu sve silne kontrole
        Operater::registrirajnovi();
        $this->view->render('registracijagotova');
    }

    public function zavrsiregistraciju()
    {
        Operater::zavrsiregistraciju($_GET['id']);
        $this->view->render('prijava');
    }

    public function test()
    {
     echo password_hash('123456',PASSWORD_BCRYPT);
      // echo md5('mojaMala'); NE KORISTITI
    } 
}