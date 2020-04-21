<?php

class Hotel
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        select ID_hotel, hNaziv, hAdresa, hGrad, hDrzava, hPostanskiBroj, hGlavniBrojTelefona, 
        hZvjezdice, hMaxBrojGostiju from hotel
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        select ID_hotel,
        hNaziv, hAdresa, hGrad, hDrzava,
        hPostanskiBroj, hGlavniBrojTelefona, 
        hZvjezdice, hMaxBrojGostiju from hotel
        where ID_hotel=:ID_hotel');
        $izraz->execute(['ID_hotel'=>$sifra]);
        return $izraz->fetch();
    }

    public static function create()
    {
        $veza = DB::getInstanca();
     
        $izraz=$veza->prepare('insert into hotel
        (hNaziv,hAdresa,hGrad,hDrzava,hPostanskiBroj,hGlavniBrojTelefona,hZvjezdice,hMaxBrojGostiju) values 
        (:naziv,:adresa,:grad,:drzava,:postanskibroj,:glavnibrojtelefona,:zvjezdice,:maxbrojgostiju)');
        $izraz->execute($_POST);
    }

    public static function delete()
    {
            try{
                $veza = DB::getInstanca();
                $izraz=$veza->prepare('delete from hotel where ID_hotel=:ID_hotel');
                $izraz->execute($_GET);
            }catch(PDOException $e){
                echo $e->getMessage();
                return false;
            }
            return true;
    
    }

    public static function update(){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update hotel
        set hNaziv=:naziv,
        hAdresa=:adresa,hGrad=:grad,hDrzava=:drzava,hPostanskiBroj=:postanskibroj,
        hGlavniBrojTelefona=:glavnibrojtelefona,hZvjezdice=:zvjezdice,
        hMaxBrojGostiju=:maxbrojgostiju where ID_hotel=:sifra');
        $izraz->execute($_POST);
    }
}