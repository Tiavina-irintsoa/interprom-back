-- update point basket dans la table resultat 3 gagnants, 2 null, 1 perdu
update resultat
set point = 1 
where id_match in (select id_match from match where id_discipline=2)
and score_marque < score_encaisse
;


-- ajout profil utilisateur;
alter table utilisateur add column profil varchar(200);
update utilisateur set profil = 'ADMIN';


