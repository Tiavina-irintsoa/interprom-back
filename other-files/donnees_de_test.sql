insert into discipline(nom) values('basketball');

insert into poule(nom,id_discipline) values('A',1);
insert into poule(nom,id_discipline) values('B',1);

insert into tournoi(nom) values('interprom2024');

insert into type_match(nom,rang) values('poule','');
insert into type_match(nom,rang) values('quart','');
insert into type_match(nom,rang) values('demi','');
insert into type_match(nom,rang) values('finale','');

insert into utilisateur(nom,mdp) values('admin','admin');

insert into equipe(nom_equipe,id_poule) values('P15A',1);
insert into equipe(nom_equipe,id_poule) values('P15B',1);
insert into equipe(nom_equipe,id_poule) values('P16A',2);
insert into equipe(nom_equipe,id_poule) values('P16B',2);

insert into equipe_tournoi(id_equipe,id_tournoi) values(1,1);
insert into equipe_tournoi(id_equipe,id_tournoi) values(2,1);
insert into equipe_tournoi(id_equipe,id_tournoi) values(3,1);
insert into equipe_tournoi(id_equipe,id_tournoi) values(4,1);

insert into match
(id_equipe_tournoi_1,id_equipe_tournoi_2,date_,debut_prevision,debut_reel,fin_prevision,fin_reel,id_discipline,score_equipe_1,score_equipe_2,id_type)
values
(1,2,'2024-04-11','10:00:00','10:05:00','12:00:00','12:30:00',1,10,8,1);
insert into match
(id_equipe_tournoi_1,id_equipe_tournoi_2,date_,debut_prevision,debut_reel,fin_prevision,fin_reel,id_discipline,score_equipe_1,score_equipe_2,id_type)
values
(3,4,'2024-04-11','11:00:00',null,'13:00:00',null,1,0,0,1);

insert into resultat(id_equipe,id_match,point,score_marque,score_encaisse) values(1,1,3,10,8);
insert into resultat(id_equipe,id_match,point,score_marque,score_encaisse) values(2,1,0,8,10);
