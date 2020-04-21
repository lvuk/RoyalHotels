drop DATABASE if exists RoyalHotels;
create DATABASE RoyalHotels default character set utf8;
use RoyalHotels;

# D:\xampp\mysql\bin\mysql.exe -uedunova -pedunova --default_character_set=utf8 < D:\RoyalHotelsPHP\royal.hotels.hr\royalHotels.sql

create TABLE operater(
    ID_operater int NOT NULL PRIMARY KEY auto_increment,
    oIme varchar(50) NOT NULL,
    oPrezime varchar(50) NOT NULL,
    oUloga varchar(50) NOT NULL,
    oLozinka char(60) not null,
    oEmail varchar(50) not null,
    oSessionid  varchar(100)
);


create TABLE hotel(
    ID_hotel int NOT NULL PRIMARY KEY auto_increment,
    hNaziv varchar (50) NOT NULL,
    hAdresa varchar (100) NOT NULL,
    hGrad varchar (100) NOT NULL,
    hDrzava varchar (100) NOT NULL,
    hPostanskiBroj varchar (50) NOT NULL,
    hGlavniBrojTelefona varchar (50) NOT NULL,
    hZvjezdice int NOT NULL,
    hMaxBrojGostiju int NOT NULL
);

create TABLE zaposlenik(
    ID_zaposlenik int NOT NULL PRIMARY KEY auto_increment,
    zIme varchar (50) NOT NULL, 
    zPrezime varchar(50) NOT NULL,
    zIBAN varchar (21) NOT NULL,
    zAdresa varchar (100) NOT NULL,
    zBrojMobitela varchar (50),
    zSpol varchar (50),
    zHotelID int  
); 

create TABLE rezervacija(
    ID_rezervacija int NOT NULL PRIMARY KEY auto_increment,
    rHotelID int,
    rDatumOd datetime NOT NULL,
    rDatumDo datetime NOT NULL,
    rSoba int NOT NULL,
    rGostID int,
    rBrojGostiju int NOT NULL,
    rPlaceno boolean NOT NULL
);

create TABLE gost(
    ID_gost int NOT NULL PRIMARY KEY auto_increment,
    gIme varchar (50) NOT NULL,
    gPrezime varchar (50) NOT NULL,
    gAdresa varchar (100) NOT NULL,
    gGrad varchar (50),
    gDrzava varchar (50),
    gSpol varchar (50),
    gKontaktBroj varchar (50) NOT NULL
); 



#FOREIGN KEY _ zaposlenik
ALTER TABLE zaposlenik add FOREIGN KEY (zHotelID) REFERENCES hotel(ID_hotel);

#FOREIGN KEY _ rezervacija 
ALTER TABLE rezervacija add FOREIGN KEY (rHotelID) REFERENCES hotel(ID_hotel);
ALTER TABLE rezervacija add FOREIGN KEY (rGostID) REFERENCES gost(ID_gost);

