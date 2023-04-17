DROP TABLE IF EXISTS Photo;

CREATE TABLE IF NOT EXISTS Photo
(
    idP          int(10) PRIMARY KEY AUTO_INCREMENT NOT NULL, # l'ID de la photo(sert aussi pour relier aux images, étant unique)
    dateS        DATETIME                           NOT NULL, # la date de soumission de la photo
    author       VARCHAR(100)                       NOT NULL, # l'auteur de la photo
    title        VARCHAR(100),                                #  le titre de la photo
    descriptionP TEXT                               NOT NULL, # la description de la photo
    dateP        DATE                               NOT NULL  # la date de prise
);
