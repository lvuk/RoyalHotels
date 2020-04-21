<?php

class Gost
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        select ID_gost, gIme, gPrezime, gAdresa,
        gGrad, gDrzava, gSpol from gost
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        select ID_gost, 
        gIme, gPrezime, gAdresa, gGrad,
        gKontaktBroj from gost
        where ID_gost=:ID_gost');
        $izraz->execute(['ID_gost'=>$sifra]);
        return $izraz->fetch();
    }

    public static function create()
    {
        $veza = DB::getInstanca();

        $izraz=$veza->prepare('insert into gost
        (gIme,gPrezime,gAdresa,gGrad,gDrzava,gSpol,gKontaktBroj) values 
        (:ime,:prezime,:adresa,:grad,:drzava,:spol,:kontakt)');
        $izraz->execute($_POST);
    }

    public static function delete()
    {
            try{
                $veza = DB::getInstanca();
                $izraz=$veza->prepare('delete from gost where ID_gost=:ID_gost');
                $izraz->execute($_GET);
            }catch(PDOException $e){
                echo $e->getMessage();
                return false;
            }
            return true;
    
    }

    public static function update(){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update gost 
        set gIme=:ime,
        gPrezime=:prezime,
        gGrad=:grad,
        gAdresa=:adresa,
        gSpol=:spol,
        gDrzava=:drzava,
        gKontaktBroj=:kontakt
        where ID_gost=:sifra');
        $izraz->execute($_POST);
    }

    public static function trazi($uvjet)
    {
        
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select ID_gost, gIme, gPrezime, gAdresa,
        gGrad, gDrzava, gSpol from gost
        where concat(gIme, gPrezime,\' \', 
        \' \',\' \',\' \',) like :uvjet 
        ');
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->execute();

        return $izraz->fetchAll();
    }
}