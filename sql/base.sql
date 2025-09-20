create database gesentreprise;
use gesentreprise;


create table rh_sexe (
    idSexe int auto_increment primary key,
    genre varchar(255)
);

create table rh_experience (
    idExperience int auto_increment primary key,
    duree int
);

create table rh_langue (
    idLangue int auto_increment primary key,
    langue varchar(255)
);

create table rh_candidat (
    idCandidat int auto_increment primary key,
    nom varchar(255),
    prenom varchar(255),
    dateNaissance date,
    adresse varchar(255),
    mail varchar(255),
    contact varchar(255),
    idSexe int,
    idExperience int,
    foreign key (idExperience) references rh_experience(idExperience),
    foreign key (idSexe) references rh_sexe(idSexe)
);

create table rh_candidat_langue (
    idCandidatLangue int auto_increment primary key,
    idCandidat int,
    idLangue int,
    foreign key (idCandidat) references rh_candidat(idCandidat),
    foreign key (idLangue) references rh_langue(idLangue)
);

create table rh_domaine (
    idDomaine int auto_increment primary key,
    nomDomaine varchar(255)
);

create table rh_degre (
    idDegre int auto_increment primary key,
    nomDegre varchar(255)
);

create table rh_diplome (
    idDiplome int auto_increment primary key,
    idCandidat int,
    idDomaine int,
    idDegre int,
    anneeObtention int,
    foreign key (idCandidat) references rh_candidat(idCandidat),
    foreign key (idDomaine) references rh_domaine(idDomaine),
    foreign key (idDegre) references rh_degre(idDegre)
);

create table rh_status (
    idStatus int auto_increment primary key,
    nomStatus varchar(255)
);

create table rh_status_candidat (
    idStatusCandidat int auto_increment primary key,
    idCandidat int,
    idStatus int,
    dateStatus date,
    foreign key (idCandidat) references rh_candidat(idCandidat),
    foreign key (idStatus) references rh_status(idStatus)
);

create table rh_poste (
    idPoste int auto_increment primary key,
    nomPoste varchar(255)
);

create table rh_candidat_poste (
    idCandidatPoste int auto_increment primary key,
    idCandidat int,
    idPoste int,
    foreign key (idCandidat) references rh_candidat(idCandidat),
    foreign key (idPoste) references rh_poste(idPoste)
);

create table rh_employe (
    idEmploye int auto_increment primary key,
    idCandidat int,
    foreign key (idCandidat) references rh_candidat(idCandidat)
);

create table rh_employe_poste(
    idEmployePoste int auto_increment primary key,
    idEmploye int,
    dateEmployePoste date,
    foreign key (idEmploye) references rh_employe(idEmploye),
    foreign key (idPoste) references rh_poste(idPoste)
);


create table rh_annonce (
    idAnnonce int auto_increment primary key,
    idPoste int,
    ageMin int,
    ageMax int,
    idSexe int,
    idExperience int,
    foreign key (idPoste) references rh_poste(idPoste),
    foreign key (idSexe) references rh_sexe(idSexe),
    foreign key (idExperience) references rh_experience(idExperience)
);

create table rh_diplome_annonce (
    idDiplomeAnnonce int auto_increment primary key,
    idAnnonce int,
    idDomaine int,
    idDegre int,
    foreign key (idAnnonce) references rh_annonce(idAnnonce),
    foreign key (idDomaine) references rh_domaine(idDomaine),
    foreign key (idDegre) references rh_degre(idDegre)
);

create table rh_langue_annonce (
    idLangueAnnonce int auto_increment primary key,
    idAnnonce int,
    idLangue int,
    foreign key (idAnnonce) references rh_annonce(idAnnonce),
    foreign key (idLangue) references rh_langue(idLangue)
);

create table rh_score_test (
    idScoreTest int auto_increment primary key,
    idCandidat int,
    note int,
    foreign key (idCandidat) references rh_candidat(idCandidat)
);


create table rh_score_entretien (
    idScoreEntretien int auto_increment primary key,
    idCandidat int,
    note int,
    foreign key (idCandidat) references rh_candidat(idCandidat)
);

create table rh_qcm (
    idQcm int auto_increment primary key,
    idDomaine int,
    foreign key (idDomaine) references rh_domaine(idDomaine)
);

create table rh_question (
    idQuestion int auto_increment primary key,
    question varchar(255),
    idQcm int,
    foreign key (idQcm) references rh_qcm(idQcm)
);

create table rh_reponse (
    idReponse int auto_increment primary key,
    reponse varchar(255),
    idQuestion int,
    points int,
    foreign key (idQuestion) references rh_question(idQuestion)
);

create table rh_candidat_reponse (
    idCandidatReponse int auto_increment primary key,
    idCandidat int,
    idReponse int,
    dateReponse date,
    foreign key (idCandidat) references rh_candidat(idCandidat),
    foreign key (idReponse) references rh_reponse(idReponse)
);

create table rh_mouvement (
    idMouvement int auto_increment primary key,
    nomMouvement varchar(255)
);

create table rh_employe_mouvement (
    idEmployeMouvement int auto_increment primary key,
    idEmploye int ,
    idMouvement int,
    foreign key (idEmploye) references rh_employe(idEmploye),
    foreign key (idMouvement) references rh_mouvement(idMouvement)
);

alter table rh_poste add idDomaine int;
alter table rh_poste add constraint fk_poste_domaine foreign key (idDomaine) references rh_domaine(idDomaine); 
alter table rh_poste add descriPoste text;
alter table rh_employe_mouvement add dateMouvement date;

