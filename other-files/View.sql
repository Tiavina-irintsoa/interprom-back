-- View de l'équipe dans chaque tournoi détaillée
CREATE OR REPLACE VIEW v_equipe_tournoi_lib_comp AS
SELECT 
    et.id_equipe_tournoi,
    et.id_equipe,
    (et.code_equipe || ' - ' || e.nom_equipe)::varchar as nom_equipe,
    et.id_tournoi,
    t.nom as nom_tournoi,
    et.id_poule,
    p.nom as nom_poule,
    p.id_discipline,
    d.nom as nom_discipline
FROM
    equipe_tournoi et
    JOIN equipe e ON et.id_equipe = e.id_equipe
    JOIN tournoi t ON et.id_tournoi = t.id_tournoi
    JOIN poule p ON et.id_poule = p.id_poule
    JOIN discipline d ON p.id_discipline = d.id_discipline;

SELECT * FROM v_equipe_tournoi_lib_comp;
    
-- View de l'équipe dans chaque tournoi avec leur libéllé
CREATE OR REPLACE VIEW v_equipe_tournoi_lib AS
SELECT 
    et.id_equipe_tournoi,
    (et.code_equipe || ' - ' || e.nom_equipe)::varchar as nom_equipe ,
    t.nom as nom_tournoi,
    p.nom as nom_poule,
    d.nom as nom_discipline
FROM
    equipe_tournoi et
    JOIN equipe e ON et.id_equipe = e.id_equipe
    JOIN tournoi t ON et.id_tournoi = t.id_tournoi
    JOIN poule p ON et.id_poule = p.id_poule
    JOIN discipline d ON p.id_discipline = d.id_discipline;

SELECT * FROM v_equipe_tournoi_lib;

-- View affichant les matchs par discipline par tournoi ordonnée par date et heure prevision debut
CREATE OR REPLACE VIEW v_match_lib_orderd_by_date AS
SELECT
    m.id_match, 
    et1.id_tournoi,
    e1.nom_equipe as nom_equipe_1,
    e2.nom_equipe as nom_equipe_2,
    date_,
    debut_prevision,
    debut_reel,
    fin_prevision,
    fin_reel,
    d.nom as nom_discipline,
    score_equipe_1,
    score_equipe_2,
    tm.nom as nom_type_match,
    m.terrain
FROM
    match m
    JOIN equipe_tournoi et1 ON m.id_equipe_tournoi_1 = et1.id_equipe_tournoi
    JOIN equipe e1 ON et1.id_equipe = e1.id_equipe
    JOIN equipe_tournoi et2 ON m.id_equipe_tournoi_2 = et2.id_equipe_tournoi
    JOIN equipe e2 ON et2.id_equipe = e2.id_equipe
    JOIN discipline d ON m.id_discipline = d.id_discipline
    JOIN type_match tm ON m.id_type = tm.id_type_match
ORDER BY 
    m.date_, m.debut_prevision;
   
create view v_equipe_tournoi_t_lib as (
    select 
    id_equipe_tournoi, equipe.nom_equipe,id_tournoi
    from equipe_tournoi
    join equipe
        on equipe.id_equipe = equipe_tournoi.id_equipe
);

-- W N L equipe par match
CREATE OR REPLACE VIEW "public".v_resultat_par_equipe_tournoi AS  
SELECT r.id_equipe_tournoi,
    sum(r.point) AS points,
    sum(
        CASE
            WHEN (r.score_marque > r.score_encaisse) THEN 1
            ELSE 0
        END) AS w,
    sum(
        CASE
            WHEN (r.score_marque = r.score_encaisse) THEN 1
            ELSE 0
        END) AS n,
    sum(
        CASE
            WHEN (r.score_marque < r.score_encaisse) THEN 1
            ELSE 0
        END) AS l,
    count(*) AS mj,
    sum(COALESCE(r.score_marque, 0)) AS score_marque,
    sum(COALESCE(r.score_marque, 0) - COALESCE(r.score_encaisse, 0)) AS difference_score
   FROM resultat r
  GROUP BY r.id_equipe_tournoi;

CREATE OR REPLACE VIEW "public".v_all_resultat_par_equipe_tournoi AS  
    SELECT et.id_equipe_tournoi, 
        COALESCE(vr.points, 0) as points, COALESCE(vr.w, 0) AS w, 
        COALESCE(vr.n, 0) AS n, COALESCE(vr.l, 0) AS l,
        COALESCE(vr.mj, 0) AS mj, vr.score_marque, vr.difference_score
        FROM equipe_tournoi et
        LEFT JOIN v_resultat_par_equipe_tournoi vr ON vr.id_equipe_tournoi = et.id_equipe_tournoi

CREATE OR REPLACE VIEW v_equipe_participation_detail AS
SELECT
    e.id_equipe, e.nom_equipe, et.id_equipe_tournoi, et.code_equipe, d.nom as nom_discipline
FROM
    equipe_tournoi et
    JOIN equipe e ON et.id_equipe = e.id_equipe
    JOIN poule p ON et.id_poule = p.id_poule
    JOIN discipline d ON p.id_discipline = d.id_discipline;