<?php

class Zaposlenik
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare(' 
        
        select a.ID_zaposlenik, a.zIme, a.zPrezime, a.zIBAN, a.zAdresa, a.zBrojMobitela, a.zSpol, b.hNaziv as zHotel
        from zaposlenik a
        inner join hotel b
        on a.zHotelID = b.ID_hotel;
      
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select * 
        from zaposlenik where ID_zaposlenik=:ID_zaposlenik;
        
        ');
        $izraz->execute(['ID_zaposlenik'=>$sifra]);
        return $izraz->fetch();
    }

    public static function create($hotel)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into zaposlenik 
        (zIme,zPrezime,zAdresa,zIBAN,zBrojMobitela,zSpol,zHotelID) values 
        (\'\',\'\',\'\',\'\',\'\',\'\',:hotel)');
      
        $izraz->execute(['hotel'=>$hotel]);
        return $veza->lastInsertId();
    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('delete from zaposlenik where ID_zaposlenik=:ID_zaposlenik');
            $izraz->execute($_GET);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public static function update(){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update zaposlenik 
        set zIme=:ime,
        zPrezime=:prezime,zAdresa=:adresa,zIBAN=:iban,zBrojMobitela=:brojmobitela, zSpol=:spol,zHotelID=:hotel where ID_zaposlenik=:ID_zaposlenik');
        $izraz->execute([
            'ime' => $_POST['ime'],
            'prezime' => $_POST['prezime'],
            'adresa' => $_POST['adresa'],
            'iban' => $_POST['iban'],
            'brojmobitela' => $_POST['brojmobitela'],
            'spol' => $_POST['spol'],
            'hotel' => $_POST['hotel'],
            'ID_zaposlenik' => $_POST['ID_zaposlenik']
        ]);
    }

}