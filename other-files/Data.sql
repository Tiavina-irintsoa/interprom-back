CREATE DATABASE madaebvx_itusport;
\c madaebvx_itusport;

CREATE ROLE madaebvx_ituser WITH LOGIN PASSWORD '{wlks7jdg^Pr';
GRANT ALL PRIVILEGES ON DATABASE madaebvx_itusport TO madaebvx_ituser;

CREATE  TABLE "public".discipline ( 
	id_discipline        serial  NOT NULL  ,
	nom                  varchar  NOT NULL  ,
	CONSTRAINT pk_discipline PRIMARY KEY ( id_discipline )
 );

CREATE  TABLE "public".equipe ( 
	id_equipe            serial  NOT NULL  ,
	nom_equipe           varchar  NOT NULL  ,
	CONSTRAINT pk_equipe PRIMARY KEY ( id_equipe )
 ); 

CREATE  TABLE "public".poule ( 
	id_poule             serial  NOT NULL  ,
	nom                  varchar  NOT NULL  ,
	id_discipline        serial    ,
	CONSTRAINT pk_poule PRIMARY KEY ( id_poule ),
	CONSTRAINT fk_poule_discipline FOREIGN KEY ( id_discipline ) REFERENCES "public".discipline( id_discipline )   
 );

CREATE  TABLE "public".tournoi ( 
	id_tournoi           serial  NOT NULL  ,
	nom                  varchar  NOT NULL  ,
	CONSTRAINT pk_tournoi PRIMARY KEY ( id_tournoi )
 );

CREATE  TABLE "public".type_match ( 
	id_type_match        serial  NOT NULL  ,
	nom                  varchar  NOT NULL  ,
	rang                 varchar  NOT NULL  ,
	CONSTRAINT pk_type_match PRIMARY KEY ( id_type_match )
 );

CREATE  TABLE "public".utilisateur ( 
	id                   serial  NOT NULL  ,
	nom                  varchar  NOT NULL  ,
	mdp                  varchar  NOT NULL  ,
	CONSTRAINT pk_utilisateur PRIMARY KEY ( id )
 );

CREATE  TABLE "public".equipe_tournoi ( 
	id_equipe_tournoi    serial  NOT NULL  ,
	id_equipe            integer  NOT NULL  ,
	id_tournoi           integer  NOT NULL  ,
	id_poule             integer  NOT NULL  ,
	CONSTRAINT pk_equipe_tournoi PRIMARY KEY ( id_equipe_tournoi ),
	CONSTRAINT fk_equipe_tournoi_equipe FOREIGN KEY ( id_equipe ) REFERENCES "public".equipe( id_equipe )   ,
	CONSTRAINT fk_equipe_tournoi_tournoi FOREIGN KEY ( id_tournoi ) REFERENCES "public".tournoi( id_tournoi )   ,
	CONSTRAINT fk_equipe_tournoi_poule FOREIGN KEY ( id_poule ) REFERENCES "public".poule( id_poule )   
 );

CREATE  TABLE "public"."match" ( 
	id_match             serial  NOT NULL  ,
	id_equipe_tournoi_1  integer  NOT NULL  ,
	id_equipe_tournoi_2  integer  NOT NULL  ,
	date_                date DEFAULT CURRENT_DATE NOT NULL  ,
	debut_prevision      time DEFAULT CURRENT_TIME NOT NULL  ,
	debut_reel           time DEFAULT CURRENT_TIME   ,
	fin_prevision        time DEFAULT CURRENT_TIME NOT NULL  ,
	fin_reel             time DEFAULT CURRENT_TIME   ,
	id_discipline        integer  NOT NULL  ,
	score_equipe_1       integer    ,
	score_equipe_2       integer    ,
	id_type              integer  NOT NULL  ,
	CONSTRAINT pk_match PRIMARY KEY ( id_match ),
	CONSTRAINT fk_match_equipe_tournoi FOREIGN KEY ( id_equipe_tournoi_1 ) REFERENCES "public".equipe_tournoi( id_equipe_tournoi )   ,
	CONSTRAINT fk_match_equipe_tournoi_0 FOREIGN KEY ( id_equipe_tournoi_2 ) REFERENCES "public".equipe_tournoi( id_equipe_tournoi )   ,
	CONSTRAINT fk_match_discipline FOREIGN KEY ( id_discipline ) REFERENCES "public".discipline( id_discipline )   ,
	CONSTRAINT fk_match_type_match FOREIGN KEY ( id_type ) REFERENCES "public".type_match( id_type_match )   
 );

CREATE  TABLE "public".resultat ( 
	id_resultat          serial  NOT NULL  ,
	id_equipe_tournoi    integer  NOT NULL  ,
	id_match             integer  NOT NULL  ,
	point                integer  NOT NULL  ,
	score_marque         integer  NOT NULL  ,
	score_encaisse       integer  NOT NULL  ,
	CONSTRAINT pk_resultat PRIMARY KEY ( id_resultat ),
	CONSTRAINT fk_resultat_match FOREIGN KEY ( id_match ) REFERENCES "public"."match"( id_match )   ,
	CONSTRAINT fk_resultat_equipe_tournoi FOREIGN KEY ( id_equipe_tournoi ) REFERENCES "public".equipe_tournoi( id_equipe_tournoi )   
 );
