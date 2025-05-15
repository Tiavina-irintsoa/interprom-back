CREATE OR REPLACE VIEW "public".v_resultat_par_equipe_tournoi_view_vaovao AS  
select 
coalesce(r.id_equipe_tournoi, e.id_equipe_tournoi) id_equipe_tournoi,
coalesce(sum(r.point), 0) AS points,
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
    count(r.id_resultat) AS mj,
    sum(COALESCE(r.score_marque, 0)) AS score_marque,
    sum(COALESCE(r.score_marque, 0) - COALESCE(r.score_encaisse, 0)) AS difference_score
from 
equipe_tournoi e
left join resultat r on e.id_equipe_tournoi = r.id_equipe_tournoi
  GROUP BY r.id_equipe_tournoi, e.id_equipe_tournoi;