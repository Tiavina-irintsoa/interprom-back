insert into discipline(nom) values('basketball');

insert into poule(nom,id_discipline) values('A',1);
insert into poule(nom,id_discipline) values('B',1);

insert into tournoi(nom) values('Inter prom 2024');

insert into type_match(nom,rang) values('Poule','1');
insert into type_match(nom,rang) values('1/8 de finale','2');
insert into type_match(nom,rang) values('1/4 de finale','3');
insert into type_match(nom,rang) values('Demi finale','4');
insert into type_match(nom,rang) values('Troisième place','5');
insert into type_match(nom,rang) values('Finale','6');

insert into utilisateur(nom,mdp) values('admin','admin');

insert into equipe(nom_equipe) values('P15A');
insert into equipe(nom_equipe) values('P15B');
insert into equipe(nom_equipe) values('P16A');
insert into equipe(nom_equipe) values('P16B');

insert into equipe_tournoi(id_equipe,id_tournoi,id_poule) values(1,1,1);
insert into equipe_tournoi(id_equipe,id_tournoi,id_poule) values(2,1,1);
insert into equipe_tournoi(id_equipe,id_tournoi,id_poule) values(3,1,2);
insert into equipe_tournoi(id_equipe,id_tournoi,id_poule) values(4,1,2);

insert into match
(id_equipe_tournoi_1,id_equipe_tournoi_2,date_,debut_prevision,debut_reel,fin_prevision,fin_reel,id_discipline,score_equipe_1,score_equipe_2,id_type)
values
(1,2,'2024-04-11','10:00:00','10:05:00','12:00:00','12:30:00',1,10,8,1);
insert into match
(id_equipe_tournoi_1,id_equipe_tournoi_2,date_,debut_prevision,debut_reel,fin_prevision,fin_reel,id_discipline,score_equipe_1,score_equipe_2,id_type)
values
(3,4,'2024-04-11','11:00:00',null,'13:00:00',null,1,0,0,1);

insert into resultat(id_equipe_tournoi,id_match,point,score_marque,score_encaisse) values(1,1,3,10,8);
insert into resultat(id_equipe_tournoi,id_match,point,score_marque,score_encaisse) values(2,1,0,8,10);
