CREATE TABLE loomad(
    id int PRIMARY KEY AUTO_INCREMENT,
    loomanimi varchar(25) unique,
    pilt text,
    varv varchar(20),
    synniaeg date);
CREATE TABLE autoremont(
 id int PRIMARY KEY AUTO_INCREMENT,
autoNr char(6),
varv varchar(16),
aasta int,
kasutaja varchar(25),
broneeritud_aeg datetime);
INSERT INTO autoremont(autoNr, varv, aasta, kasutaja, broneeritud_aeg)
VALUES('123AVC', 'white', 2012, 'Robin', '2023-12-5');
