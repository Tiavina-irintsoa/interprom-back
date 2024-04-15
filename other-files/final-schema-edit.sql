
-- Ajout du colonne code_equipe dans le table equipe_tournoi
ALTER TABLE equipe_tournoi ADD COLUMN code_equipe VARCHAR(5);

-- Modification type de donnée du type du match
ALTER TABLE type_match ALTER COLUMN rang SET DATA TYPE INTEGER USING rang::integer;

-- Ajout colonne terrain dans match
ALTER TABLE match ADD COLUMN terrain VARCHAR(100);

-- View affichant les matchs par discipline par tournoi ordonnée par date et heure prevision debut
CREATE OR REPLACE VIEW v_match_lib_orderd_by_date AS
SELECT
    m.id_match, 
    et1.id_tournoi,
    ( et1.code_equipe || ' - ' || e1.nom_equipe )::varchar as nom_equipe_1 ,
    ( et2.code_equipe || ' - ' || e2.nom_equipe )::varchar as nom_equipe_2,
    date_,
    debut_prevision,
    debut_reel,
    fin_prevision,
    fin_reel,
    d.nom as nom_discipline,
    score_equipe_1,
    score_equipe_2,
    tm.nom as nom_type_match,
    m.id_discipline,
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

DROP VIEW v_equipe_tournoi_lib;

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

-- Remove all results not in classements match
DELETE FROM 
	resultat 
WHERE 
	id_resultat 
IN (
	SELECT 
		r.id_resultat 
	FROM 
    	resultat r
    	JOIN match m ON r.id_match = m.id_match
	WHERE m.id_type != 1
);