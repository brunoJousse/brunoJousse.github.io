#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
DROP TABLE IF EXISTS Reserver,Itineraire,Utilisateur;

#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE Utilisateur(
        pseudo       Varchar (64) NOT NULL ,
        nom          Varchar (64) NOT NULL ,
        prenom       Varchar (64) NOT NULL ,
        mdp 			varchar(300) NOT NULL,
        admin        Bool NOT NULL ,
        telephone    varchar (10) NOT NULL ,
        mail         Varchar (256) ,
        nbAnnulation Int NOT NULL ,
        PRIMARY KEY (pseudo )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Itineraire
#------------------------------------------------------------

CREATE TABLE Itineraire(
        idItineraire   int (11) Auto_increment  NOT NULL ,
        paysDepart     Varchar (64) NOT NULL ,
        villeDepart     Varchar (64) NOT NULL ,
        rueDepart     Varchar (64) NOT NULL ,
        paysArrivee    Varchar (64) NOT NULL ,
        villeArrivee    Varchar (64) NOT NULL ,
        rueArrivee    Varchar (64) NOT NULL ,
        dateDepart     DATETIME NOT NULL ,
        nbPassagersMax Int NOT NULL ,
        nbPassager     Int ,
        prix           Int NOT NULL ,
        pseudo         Varchar (64) NOT NULL ,
        smoke Bool NOT NULL,
        pet Bool NOT NULL,
        bagage Bool NOT NULL,
        active	Bool NOT NULL,
        PRIMARY KEY (idItineraire )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Reserver
#------------------------------------------------------------

CREATE TABLE Reserver(
        nbReservation Int NOT NULL ,
        pseudo        Varchar (64) NOT NULL ,
        idItineraire  Int NOT NULL ,
        PRIMARY KEY (pseudo ,idItineraire )
)ENGINE=InnoDB;

ALTER TABLE Itineraire ADD CONSTRAINT FK_Itineraire_pseudo FOREIGN KEY (pseudo) REFERENCES Utilisateur(pseudo) ON DELETE CASCADE;
ALTER TABLE Reserver ADD CONSTRAINT FK_Reserver_pseudo FOREIGN KEY (pseudo) REFERENCES Utilisateur(pseudo) ON DELETE CASCADE;
ALTER TABLE Reserver ADD CONSTRAINT FK_Reserver_idItineraire FOREIGN KEY (idItineraire) REFERENCES Itineraire(idItineraire) ON DELETE CASCADE;
