-- WE JUST TRUNCATE AND ADD ALL DATA AFTER, DON'T FORGET TO REGISTER NEW STUDENT
TRUNCATE TABLE resultat RESTART IDENTITY cascade;
TRUNCATE TABLE match RESTART IDENTITY cascade;
TRUNCATE TABLE equipe_tournoi RESTART IDENTITY cascade;
TRUNCATE TABLE equipe RESTART IDENTITY cascade;
TRUNCATE TABLE type_match RESTART IDENTITY cascade;
TRUNCATE TABLE tournoi RESTART IDENTITY cascade;
TRUNCATE TABLE poule RESTART IDENTITY cascade;
TRUNCATE TABLE discipline RESTART IDENTITY cascade;

-- Insertion des tournois
INSERT INTO tournoi VALUES
(1, 'Inter Prom 2024');
ALTER SEQUENCE tournoi_id_tournoi_seq RESTART 2;

-- Insertion des discipline
INSERT INTO discipline VALUES
(1, 'Volley'),
(2, 'Basket'),
(3, 'Foot');
ALTER SEQUENCE discipline_id_discipline_seq RESTART 4;

-- Insertion des poules
INSERT INTO poule VALUES
(1, 'A', 1),
(2, 'B', 1),
(3, 'A', 2),
(4, 'B', 2),
(5, 'C', 2),
(6, 'A', 3),
(7, 'B', 3),
(8, 'C', 3);
ALTER SEQUENCE poule_id_poule_seq RESTART 9;

-- Insertion des équipes
INSERT INTO equipe VALUES
(1, 'P17A'),
(2, 'P17B'),
(3, 'P16A'),
(4, 'P16B'),
(5, 'P15A'),
(6, 'P15B'),
(7, 'P14'),
(8, 'P13'),
(9, 'P12'),
(10, 'DES P2'),
(11, 'DES P3'),
(12, 'DES P4'),
(13, 'M1'),
(14, 'M2'),
(15, 'Profs'),
(16, 'BICI'),
(17, 'Anciens'),
(18, 'P17 A1'),
(19, 'P17 A2');
ALTER SEQUENCE equipe_id_equipe_seq RESTART 20;


-- Insertion participation des équipes aux tournoi
INSERT INTO equipe_tournoi 
(id_equipe_tournoi, id_equipe, id_tournoi, id_poule, code_equipe)
VALUES
-- Volley Groupe A
(1, 5, 1, 1, 'A1'),
(2, 3, 1, 1, 'A2'),
(3, 7, 1, 1, 'A3'),
(4, 18, 1, 1, 'A4'),
-- Volley Groupe B
(5, 10, 1, 2, 'B1'),
(6, 6, 1, 2, 'B2'),
(7, 4, 1, 2, 'B3'),
(8, 19, 1, 2, 'B4'),
-- Basket Groupe A
(9, 3, 1, 3, 'A1'),
(10, 12, 1, 3, 'A2'),
(11, 6, 1, 3, 'A3'),
(12, 11, 1, 3, 'A4'),
-- Basket Groupe B
(13, 1, 1, 4, 'B1'),
(14, 10, 1, 4, 'B2'),
(15, 14, 1, 4, 'B3'),
(16, 7, 1, 4, 'B4'),
(17, 13, 1, 4, 'B5'),
-- Basket Groupe C
(18, 4, 1, 5, 'C1'),
(19, 2, 1, 5, 'C2'),
(20, 5, 1, 5, 'C3'),
(21, 17, 1, 5, 'C4'),
-- Foot Groupe A
(22, 3, 1, 6, 'A1'),
(23, 15, 1, 6, 'A2'),
(24, 5, 1, 6, 'A3'),
(25, 12, 1, 6, 'A4'),
(26, 8, 1, 6, 'A5'),
-- Foot Groupe B
(27, 1, 1, 7, 'B1'),
(28, 6, 1, 7, 'B2'),
(29, 7, 1, 7, 'B3'),
(30, 11, 1, 7, 'B4'),
(31, 16, 1, 7, 'B5'),
-- Foot Groupe B
(32, 10, 1, 8, 'C1'),
(33, 2, 1, 8, 'C2'),
(34, 4, 1, 8, 'C3'),
(35, 9, 1, 8, 'C4');

ALTER SEQUENCE equipe_tournoi_id_equipe_tournoi_seq RESTART 36;

-- Insertion des types de matchs
INSERT INTO type_match VALUES
(1, 'Phase de poules', 1),
(2, 'Huitième de Finale', 2),
(3, 'Quart de Finale', 3),
(4, 'Demi-Finale', 4),
(5, 'Finale', 5);

ALTER SEQUENCE type_match_id_type_match_seq RESTART 6;

-- Insertion des programmes de match
ALTER SEQUENCE match_id_match_seq RESTART 1;
INSERT INTO match
(id_equipe_tournoi_1, id_equipe_tournoi_2, date_, debut_prevision, fin_prevision, id_discipline, score_equipe_1, score_equipe_2, id_type, terrain) 
VALUES 
-- Phase de poules volley
(5, 8, '12-04-2024', '08:00', '08:30', 1, 0, 0, 1, 'Terrain 1'),
(1, 4, '12-04-2024', '08:30', '09:00', 1, 0, 0, 1, 'Terrain 1'),
(6, 7, '12-04-2024', '09:00', '09:30', 1, 0, 0, 1, 'Terrain 1'),
(2, 3, '12-04-2024', '09:30', '10:00', 1, 0, 0, 1, 'Terrain 1'),
(5, 7, '12-04-2024', '10:00', '10:30', 1, 0, 0, 1, 'Terrain 1'),
(1, 3, '12-04-2024', '10:30', '11:00', 1, 0, 0, 1, 'Terrain 1'),
(6, 8, '12-04-2024', '11:00', '11:30', 1, 0, 0, 1, 'Terrain 1'),
(2, 4, '12-04-2024', '11:30', '12:00', 1, 0, 0, 1, 'Terrain 1'),
(5, 6, '12-04-2024', '12:00', '12:30', 1, 0, 0, 1, 'Terrain 1'),
(1, 2, '12-04-2024', '12:30', '13:00', 1, 0, 0, 1, 'Terrain 1'),
(7, 8, '12-04-2024', '13:00', '13:30', 1, 0, 0, 1, 'Terrain 1'),
(3, 4, '12-04-2024', '13:30', '14:00', 1, 0, 0, 1, 'Terrain 1'),
-- Phase de poules basket
(14, 17, '12-04-2024', '08:00', '08:25', 2, 0, 0, 1, 'Terrain 1'),
(15, 16, '12-04-2024', '08:00', '08:25', 2, 0, 0, 1, 'Terrain 2'),
(18, 21, '12-04-2024', '08:25', '08:50', 2, 0, 0, 1, 'Terrain 1'),
(19, 20, '12-04-2024', '08:25', '08:50', 2, 0, 0, 1, 'Terrain 2'),
(13, 15, '12-04-2024', '08:50', '09:15', 2, 0, 0, 1, 'Terrain 1'),
(16, 14, '12-04-2024', '08:50', '09:15', 2, 0, 0, 1, 'Terrain 2'),
(9, 11, '12-04-2024', '09:15', '09:40', 2, 0, 0, 1, 'Terrain 1'),
(12, 10, '12-04-2024', '09:15', '09:40', 2, 0, 0, 1, 'Terrain 2'),
(13, 17, '12-04-2024', '09:40', '10:05', 2, 0, 0, 1, 'Terrain 1'),
(14, 15, '12-04-2024', '09:40', '10:05', 2, 0, 0, 1, 'Terrain 2'),
(18, 20, '12-04-2024', '10:05', '10:30', 2, 0, 0, 1, 'Terrain 1'),
(21, 19, '12-04-2024', '10:05', '10:30', 2, 0, 0, 1, 'Terrain 2'),
(9, 10, '12-04-2024', '10:30', '10:55', 2, 0, 0, 1, 'Terrain 1'),
(11, 12, '12-04-2024', '10:30', '10:55', 2, 0, 0, 1, 'Terrain 2'),
(13, 16, '12-04-2024', '10:55', '11:20', 2, 0, 0, 1, 'Terrain 1'),
(17, 15, '12-04-2024', '10:55', '11:20', 2, 0, 0, 1, 'Terrain 2'),
(18, 19, '12-04-2024', '11:20', '11:45', 2, 0, 0, 1, 'Terrain 1'),
(20, 21, '12-04-2024', '11:20', '11:45', 2, 0, 0, 1, 'Terrain 2'),
(9, 12, '12-04-2024', '11:45', '12:10', 2, 0, 0, 1, 'Terrain 1'),
(10, 11, '12-04-2024', '11:45', '12:10', 2, 0, 0, 1, 'Terrain 2'),
(13, 14, '12-04-2024', '12:10', '12:35', 2, 0, 0, 1, 'Terrain 1'),
(16, 17, '12-04-2024', '12:10', '12:35', 2, 0, 0, 1, 'Terrain 2'),
-- Phase de poules Foot
(23,26,'2024-04-12','08:00','08:20',3,0,0,1,'Terrain 1'),
(28,31,'2024-04-12','08:20','08:40',3,0,0,1,'Terrain 1'),
(32,35,'2024-04-12','08:40','09:00',3,0,0,1,'Terrain 1'),
(22,26,'2024-04-12','09:00','09:20',3,0,0,1,'Terrain 1'),
(27,31,'2024-04-12','09:20','09:40',3,0,0,1,'Terrain 1'),
(32,34,'2024-04-12','09:40','10:00',3,0,0,1,'Terrain 1'),
(22,25,'2024-04-12','10:00','10:20',3,0,0,1,'Terrain 1'),
(27,30,'2024-04-12','10:20','10:40',3,0,0,1,'Terrain 1'),
(32,33,'2024-04-12','10:40','11:00',3,0,0,1,'Terrain 1'),
(22,24,'2024-04-12','11:00','11:20',3,0,0,1,'Terrain 1'),
(27,29,'2024-04-12','11:20','11:40',3,0,0,1,'Terrain 1'),
(22,23,'2024-04-12','11:40','12:00',3,0,0,1,'Terrain 1'),
(27,28,'2024-04-12','12:00','12:20',3,0,0,1,'Terrain 1'),
(24,25,'2024-04-12','08:00','08:20',3,0,0,1,'Terrain 2'),
(29,30,'2024-04-12','08:20','08:40',3,0,0,1,'Terrain 2'),
(33,34,'2024-04-12','08:40','09:00',3,0,0,1,'Terrain 2'),
(23,24,'2024-04-12','09:00','09:20',3,0,0,1,'Terrain 2'),
(28,29,'2024-04-12','09:20','09:40',3,0,0,1,'Terrain 2'),
(35,33,'2024-04-12','09:40','10:00',3,0,0,1,'Terrain 2'),
(26,24,'2024-04-12','10:00','10:20',3,0,0,1,'Terrain 2'),
(31,29,'2024-04-12','10:20','10:40',3,0,0,1,'Terrain 2'),
(34,35,'2024-04-12','10:40','11:00',3,0,0,1,'Terrain 2'),
(25,23,'2024-04-12','11:00','11:20',3,0,0,1,'Terrain 2'),
(30,28,'2024-04-12','11:20','11:40',3,0,0,1,'Terrain 2'),
(25,26,'2024-04-12','11:40','12:00',3,0,0,1,'Terrain 2'),
(30,31,'2024-04-12','12:00','12:20',3,0,0,1,'Terrain 2');

INSERT INTO match
(id_match, id_equipe_tournoi_1, id_equipe_tournoi_2, date_, debut_prevision, fin_prevision, id_discipline, score_equipe_1, score_equipe_2, id_type, terrain) 
VALUES 
(DEFAULT, 28,31,'2024-04-12','08:20','08:40',3,0,0,1,'Terrain 1');