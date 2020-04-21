<?php

class Rezervacija
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare(' 
        
        select a.ID_rezervacija, a.rBrojGostiju,
        a.rDatumOd, a.rDatumDo, a.rSoba, a.rPlaceno,
        b.hNaziv as rHotel,
        c.gPrezime as rGost
        from rezervacija a 
        inner join hotel b on a.rHotelID = b.ID_hotel
        left join gost c on a.rGostID = c.ID_gost;
      
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select * from rezervacija
        where ID_rezervacija=:ID_rezervacija;
        
        ');
        $izraz->execute(['ID_rezervacija'=>$sifra]);
        return $izraz->fetch();
    }

    public static function create($hotel, $gost)
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into rezervacija
        (rHotelID,rDatumOD,rDatumDO,rSoba,rGostID,rBrojGostiju,rPlaceno) values 
        (:hotel,\'\',\'\',\'\',:gost,\'\',\'\')');
      
        $izraz->execute(['hotel'=>$hotel,
                         'gost'=>$gost     
        ]);
        return $veza->lastInsertId();
    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('delete from rezervacija where ID_rezervacija=:ID_rezervacija');
            $izraz->execute($_GET);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public static function update(){
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('update rezervacija 
        set 
        rHotelID=:hotel,
        rDatumOd=:datumod,
        rDatumDo=:datumdo,
        rSoba=:soba, 
        rGostID=:gost,
        rBrojGostiju=:brojgostiju, 
        rPlaceno=:placeno 
        
        where ID_rezervacija=:ID_rezervacija');
        
        $izraz->execute([
            'hotel' => $_POST['hotel'],
            'datumod' => $_POST['datumod'],
            'datumdo' => $_POST['datumdo'],
            'soba' => $_POST['soba'],
            'gost' => $_POST['gost'],
            'brojgostiju' => $_POST['brojgostiju'],
            'placeno' => $_POST['placeno'],
            'ID_rezervacija' => $_POST['ID_rezervacija']
        ]);
    }

}