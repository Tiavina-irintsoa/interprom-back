-- View de l'équipe dans chaque tournoi détaillée
CREATE VIEW v_equipe_tournoi_lib_comp AS
SELECT 
    et.id_equipe_tournoi,
    et.id_equipe,
    e.nom_equipe,
    et.id_tournoi,
    t.nom as nom_tournoi,
    et.id_poule,
    p.nom as nom_poule
FROM
    equipe_tournoi et
    JOIN equipe e ON et.id_equipe = e.id_equipe
    JOIN tournoi t ON et.id_tournoi = t.id_tournoi
    JOIN poule p ON et.id_poule = p.id_poule;
   
SELECT * FROM v_equipe_tournoi_lib_comp;
    
-- View de l'équipe dans chaque tournoi avec leur libéllé
CREATE VIEW v_equipe_tournoi_lib AS
SELECT 
    et.id_equipe_tournoi,
    e.nom_equipe,
    t.nom as nom_tournoi,
    p.nom as nom_poule
FROM
    equipe_tournoi et
    JOIN equipe e ON et.id_equipe = e.id_equipe
    JOIN tournoi t ON et.id_tournoi = t.id_tournoi
    JOIN poule p ON et.id_poule = p.id_poule;
    
SELECT * FROM v_equipe_tournoi_lib;
   