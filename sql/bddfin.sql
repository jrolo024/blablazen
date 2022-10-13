------------------------------------------------------------
--        Script Postgre 
------------------------------------------------------------

------------------------------------------------------------
-- Table: utilisateur
------------------------------------------------------------
CREATE TABLE utilisateur(
	pseudo      VARCHAR (50) NOT NULL ,
	nom         VARCHAR (50) NOT NULL ,
	password    VARCHAR (100) NOT NULL ,
	telephone   VARCHAR (10) NOT NULL  ,
	CONSTRAINT utilisateur_PK PRIMARY KEY (pseudo)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: ville
------------------------------------------------------------
CREATE TABLE ville(
	addresse       VARCHAR (50) NOT NULL ,
	ville          VARCHAR (50) NOT NULL ,
	code_postal    VARCHAR (5)  NOT NULL  ,
	CONSTRAINT ville_PK PRIMARY KEY (addresse)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: trajet
------------------------------------------------------------
CREATE TABLE trajet(
	id_trajet        SERIAL NOT NULL ,
	date_depart      TIMESTAMP  NOT NULL ,
	date_arrivee     TIMESTAMP  NOT NULL ,
	nb_places        INTEGER  NOT NULL ,
	prix             FLOAT  NOT NULL ,
	pseudo           VARCHAR (50) NOT NULL ,
	addresse_depart  VARCHAR (50) NOT NULL ,
	addresse_arrivee   VARCHAR (50) NOT NULL  ,
	CONSTRAINT trajet_PK PRIMARY KEY (id_trajet)

	,CONSTRAINT trajet_utilisateur_FK FOREIGN KEY (pseudo) REFERENCES utilisateur(pseudo)
	,CONSTRAINT trajet_ville0_FK FOREIGN KEY (addresse_depart) REFERENCES ville(addresse)
	,CONSTRAINT trajet_ville1_FK FOREIGN KEY (addresse_arrivee) REFERENCES ville(addresse)
)WITHOUT OIDS;


------------------------------------------------------------
-- Table: réserve
------------------------------------------------------------
CREATE TABLE reservation(
	pseudo      VARCHAR (50) NOT NULL ,
	id_trajet   INT  NOT NULL  ,
	CONSTRAINT reservation_PK PRIMARY KEY (pseudo,id_trajet)

	,CONSTRAINT reservation_utilisateur_FK FOREIGN KEY (pseudo) REFERENCES utilisateur(pseudo)
	,CONSTRAINT reservation_trajet0_FK FOREIGN KEY (id_trajet) REFERENCES trajet(id_trajet)
)WITHOUT OIDS;
------------------------------------------------------------
-- Insert utilisateu - en commentaire car possible erreur de primary key si ajout quand la base de données n'est pas vide et que les données existent déjàr
------------------------------------------------------------
--INSERT INTO utilisateur(pseudo, nom, password, telephone) VALUES('testV', 'titi', '$2y$10$HLljrd.xeSEx5UtUTqqhLeEyeJ.994s70GfN4fNg1giQJomedXBmG', '0725143698'); -- mdp = ministre
--INSERT INTO utilisateur(pseudo, nom, password, telephone) VALUES('jean', 'dujardin', '$2y$10$HLljrd.xeSEx5UtUTqqhLeEyeJ.994s70GfN4fNg1giQJomedXBmG', '0748591526');-- mdp = ministre
--INSERT INTO utilisateur(pseudo, nom, password, telephone) VALUES('marie', 'savant', '$2y$10$EK803DNsm4G8tVf2Fcd2SuuT2.JrSXrleEYxnyWZqc8SdXiBs5igi', '0326541578');-- mdp =bonjour
--INSERT INTO utilisateur(pseudo, nom, password, telephone) VALUES('paul', 'poire', '$2y$10$EK803DNsm4G8tVf2Fcd2SuuT2.JrSXrleEYxnyWZqc8SdXiBs5igi', '0754813542');-- mdp =bonjour
--INSERT INTO utilisateur(pseudo, nom, password, telephone) VALUES('pomme', 'chance', '$2y$10$Iqpk77rizwGqkVhuxTm8.urQ3McMOjzlSHx.AwGgMG/txELJPp1KO', '0874987632');-- mdp =guigui
--INSERT INTO utilisateur(pseudo, nom, password, telephone) VALUES('neige', 'montagne', '$2y$10$Iqpk77rizwGqkVhuxTm8.urQ3McMOjzlSHx.AwGgMG/txELJPp1KO', '0789787578');-- mdp =guigui
------------------------------------------------------------
------------------------------------------------------------
-- Insert utilisateur - en commentaire car possible erreur de primary key si ajout quand la base de données n'est pas vide et que les données existent déjà

--INSERT INTO ville(addresse, ville, code_postal) VALUES('caen', 'caen', '14118');
--INSERT INTO ville(addresse, ville, code_postal) VALUES('lille', 'lille', '59000');
--INSERT INTO ville(addresse, ville, code_postal) VALUES('toulouse', 'toulouse', '31000');
--INSERT INTO ville(addresse, ville, code_postal) VALUES('rennes', 'rennes', '35000');
--INSERT INTO ville(addresse, ville, code_postal) VALUES('brest', 'brest', '29200');
--INSERT INTO ville(addresse, ville, code_postal) VALUES('nantes', 'nantes', '44470');
------------------------------------------------------------
------------------------------------------------------------
-- Insert utilisateur - en commentaire car possible erreur de primary key dans ville donc pour éviter erreur quand ajout de trajet

--INSERT INTO trajet(pseudo, date_depart, date_arrivee, nb_places, prix, addresse_depart, addresse_arrivee) VALUES('testV', '2021-06-28 07:10:00', '2021-06-28 09:10:00', '3', '15', 'caen', 'paris');
--INSERT INTO trajet(pseudo, date_depart, date_arrivee, nb_places, prix, addresse_depart, addresse_arrivee) VALUES('jean', '2021-06-30 10:12:00', '2021-06-30 13:12:00', '5', '25', 'nantes', 'le havre');
--INSERT INTO trajet(pseudo, date_depart, date_arrivee, nb_places, prix, addresse_depart, addresse_arrivee) VALUES('marie', '2021-06-29 14:25:00', '2021-06-22 17:40:00', '2', '30', 'brest', 'rennes');
--INSERT INTO trajet(pseudo, date_depart, date_arrivee, nb_places, prix, addresse_depart, addresse_arrivee) VALUES('paul', '2021-06-29 12:25:00', '2021-06-29 18:35:00', '4', '22', 'brest', 'nantes');
--INSERT INTO trajet(pseudo, date_depart, date_arrivee, nb_places, prix, addresse_depart, addresse_arrivee) VALUES('pomme', '2021-06-30 13:52:00', '2021-06-29 18:35:00', '4', '22', 'brest', 'nantes');
--INSERT INTO trajet(pseudo, date_depart, date_arrivee, nb_places, prix, addresse_depart, addresse_arrivee) VALUES('neige', '2021-06-30 9:12:00', '2021-06-29 13:42:00', '4', '22', 'orléans', 'nantes');
------------------------------------------------------------
 

