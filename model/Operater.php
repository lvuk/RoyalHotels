<?php

class Operater
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select ID_operater, 
        oIme, oPrezime, oUloga, oEmail from operater');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select ID_operater, 
        oIme, oPrezime, oUloga, oEmail from operater
        where ID_operater=:ID_operater');
        $izraz->execute(['ID_operater'=>$sifra]);
        return $izraz->fetch();
    }

    public static function create()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into operater 
        (oEmail,oLozinka,oIme,oPrezime,oUloga) values 
        (:email,:lozinka,:ime,:prezime,:uloga)');
        unset($_POST['lozinkaponovo']);
        $_POST['lozinka'] = 
             password_hash($_POST['lozinka'],PASSWORD_BCRYPT);
        $izraz->execute($_POST);
    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('delete from operater where ID_operater=:ID_operater');
            $izraz->execute($_GET);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public static function update(){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update operater 
        set oEmail=:email,oIme=:ime,
        oPrezime=:prezime,oUloga=:uloga where ID_operater=:sifra');
        $izraz->execute($_POST);
    }

    public static function registrirajnovi()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into operater 
        (oEmail,oLozinka,oIme,oPrezime,oUloga,oSessionid) values 
        (:email,:lozinka,:ime,:prezime,:uloga,:sessionid)');
        unset($_POST['lozinkaponovo']);

        $_POST['lozinka'] = 
             password_hash($_POST['lozinka'],PASSWORD_BCRYPT);
        $_POST['sessionid'] = session_id();
        $_POST['uloga'] = 'operater';
        //print_r($_POST)
    }

}