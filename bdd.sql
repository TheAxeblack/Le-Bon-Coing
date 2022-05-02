DROP TABLE IF EXISTS user;

CREATE TABLE IF NOT EXISTS user
(
    id     INTEGER PRIMARY KEY AUTOINCREMENT,
    genre  VARCHAR(255),
    prenom VARCHAR(255),
    nom    VARCHAR(255),
    date_n TEXT,
    pseudo VARCHAR(255),
    mdp    VARCHAR(255),
    email  VARCHAR(255),
    statut INT DEFAULT 0
);

INSERT INTO user (genre, prenom, nom, date_n, pseudo, mdp, email, statut)
VALUES ('n-b', 'SuperUser', 'ofDoom', '2000-01-01', 'SuperUser', '', 'senisonn@gmail.com', 1);
INSERT INTO user (genre, prenom, nom, date_n, pseudo, mdp, email, statut)
VALUES ('homme', 'Jack', 'Cry', '2002-05-04', 'ouizdzd', 'ouizdzd', 'senisonn@gmail.com', 0);

DROP TABLE IF EXISTS annonce_p;

CREATE TABLE IF NOT EXISTS annonce_p
(
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    id_u        INTEGER,
    nom         VARCHAR(255) NOT NULL,
    type        VARCHAR(255),
    date_post   TEXT,
    image1      VARCHAR(255) NOT NULL,
    image2      VARCHAR(255)  DEFAULT NULL,
    image3      VARCHAR(255)  DEFAULT NULL,
    description VARCHAR(5000) DEFAULT NULL,
    prix        INT          NOT NULL,
    c_postal    INT          NOT NULL,
    FOREIGN KEY (id_u) REFERENCES user (id)
);
