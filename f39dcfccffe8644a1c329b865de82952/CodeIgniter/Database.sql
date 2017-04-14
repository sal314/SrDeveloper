DROP TABLE IF EXISTS size_geometry;
CREATE TABLE size_geometry (
   hg_size INT(10),
   hg_spaces INT(10),
   PRIMARY KEY (hg_size));

DROP TABLE IF EXISTS lines_geometry;
CREATE TABLE lines_geometry (
   l_number INT(10),
   l_size INT(10),
   PRIMARY KEY (l_number));

DROP TABLE IF EXISTS results;
CREATE TABLE results (
   hg_size INT(10),
   hg_percent INT(10),
   string VARCHAR(500),
   PRIMARY KEY (hg_size, hg_percent));

INSERT INTO size_geometry (hg_size, hg_spaces) VALUES (2, 4);
INSERT INTO size_geometry (hg_size, hg_spaces) VALUES (3, 9);
INSERT INTO size_geometry (hg_size, hg_spaces) VALUES (4, 16);
INSERT INTO size_geometry (hg_size, hg_spaces) VALUES (5, 25);
INSERT INTO size_geometry (hg_size, hg_spaces) VALUES (6, 36);
INSERT INTO size_geometry (hg_size, hg_spaces) VALUES (7, 49);
INSERT INTO size_geometry (hg_size, hg_spaces) VALUES (8, 64);
INSERT INTO size_geometry (hg_size, hg_spaces) VALUES (9, 81);
INSERT INTO size_geometry (hg_size, hg_spaces) VALUES (10, 100);

INSERT INTO lines_geometry (l_number, l_size) VALUES (1, 1);
INSERT INTO lines_geometry (l_number, l_size) VALUES (2, 3);
INSERT INTO lines_geometry (l_number, l_size) VALUES (3, 5);
INSERT INTO lines_geometry (l_number, l_size) VALUES (4, 7);
INSERT INTO lines_geometry (l_number, l_size) VALUES (5, 9);
INSERT INTO lines_geometry (l_number, l_size) VALUES (6, 11);
INSERT INTO lines_geometry (l_number, l_size) VALUES (7, 13);
INSERT INTO lines_geometry (l_number, l_size) VALUES (8, 15);
INSERT INTO lines_geometry (l_number, l_size) VALUES (9, 17);
INSERT INTO lines_geometry (l_number, l_size) VALUES (10, 19);






