-- Sexe
insert into rh_sexe (genre) values ('Homme'), ('Femme');

-- Expérience
insert into rh_experience (duree) values (0), (1), (3), (5), (10);

-- Langues
insert into rh_langue (langue) values ('Français'), ('Anglais'), ('Malgache');

-- Domaines
insert into rh_domaine (nomDomaine) values 
('Général'), 
('Technique'), 
('Informatique'), 
('Gestion'), 
('Commerce');

-- Degrés
insert into rh_degre (nomDegre) values 
('CEPE'),
('BEPC'),
('Baccalauréat'),
('Licence'),
('Master'),
('Doctorat');

-- Postes
insert into rh_poste (nomPoste) values 
('Développeur Web'),
('Comptable'),
('Responsable Commercial'),
('Technicien Réseau');

-- Statuts de candidature
insert into rh_status (nomStatus) values 
('non-lue'),
('lue'),
('entretien-non'),
('entretien-oui'),
('acceptée'),
('refusée');

-- Libellés de test/entretien (optionnel si tu veux rattacher ailleurs)
insert into rh_libelle (nom) values ('Test'), ('Entretien');

-- Candidats
insert into rh_candidat (nom, prenom, dateNaissance, adresse, mail, contact, idSexe, idExperience) values
('Rakoto', 'Jean', '1995-04-12', 'Antananarivo', 'jean.rakoto@email.com', '0321111111', 1, 3),
('Rasoa', 'Marie', '1998-08-25', 'Toamasina', 'marie.rasoa@email.com', '0322222222', 2, 2),
('Randria', 'Paul', '1990-01-10', 'Fianarantsoa', 'paul.randria@email.com', '0323333333', 1, 5),
('Raher', 'Clara', '2000-11-05', 'Antsirabe', 'clara.raher@email.com', '0324444444', 2, 1);

-- Candidats & langues
insert into rh_candidat_langue (idCandidat, idLangue) values
(1,1), (1,2),
(2,1), (2,3),
(3,1), (3,2), (3,3),
(4,1);

-- Diplômes des candidats
insert into rh_diplome (idCandidat, idDomaine, idDegre, anneeObtention) values
(1, 1, 3, 2014), -- Bac général
(1, 3, 4, 2018), -- Licence Informatique
(2, 1, 3, 2016), -- Bac général
(2, 4, 4, 2020), -- Licence Gestion
(3, 2, 3, 2008), -- Bac technique
(3, 3, 5, 2013), -- Master Informatique
(4, 1, 2, 2014), -- BEPC
(4, 5, 3, 2018); -- Bac commerce

-- Annonces
insert into rh_annonce (idPoste, ageMin, ageMax, idSexe, idExperience) values
(1, 20, 35, 1, 3), -- Développeur Web
(2, 22, 40, 2, 2), -- Comptable
(3, 25, 45, 1, 4), -- Responsable commercial
(4, 21, 38, 1, 2); -- Technicien Réseau

-- Diplômes requis pour les annonces
insert into rh_diplome_annonce (idAnnonce, idDomaine, idDegre) values
(1, 3, 4), -- Licence informatique pour Développeur
(2, 4, 4), -- Licence gestion pour Comptable
(3, 5, 3), -- Bac commerce pour Responsable commercial
(4, 2, 3); -- Bac technique pour Technicien Réseau

-- Langues exigées pour les annonces
insert into rh_langue_annonce (idAnnonce, idLangue) values
(1,2), -- Anglais pour développeur
(2,1), -- Français pour comptable
(3,1), (3,3), -- Français + Malgache pour commercial
(4,1); -- Français pour technicien

-- Lien candidats-postes (qui postule à quoi)
insert into rh_candidat_poste (idCandidat, idPoste) values
(1,1),
(2,2),
(3,1),
(4,3);

-- Status candidature
insert into rh_status_candidat (idCandidat, idStatus, dateStatus) values
(1, 2, '2025-09-01'), -- lue
(2, 1, '2025-09-02'),
(3, 5, '2025-09-03'),
(4, 5, '2025-09-04'); -- non lue

-- Exemple QCM domaine informatique
insert into rh_qcm (idDomaine) values (3);

insert into rh_question (question, idQcm) values
('Que signifie HTML ?', 1),
('Quel langage est utilisé pour le backend ?', 1);

insert into rh_reponse (reponse, idQuestion, points) values
('HyperText Markup Language', 1, 1),
('HighText Machine Language', 1, 0),
('PHP', 2, 1),
('CSS', 2, 0);

-- Exemple réponses candidats au QCM
insert into rh_candidat_reponse (idCandidat, idReponse, dateReponse) values
(1, 1, '2025-09-10'),
(1, 3, '2025-09-10'),
(3, 1, '2025-09-10'),
(3, 4, '2025-09-10');

UPDATE rh_poste 
SET descriPoste = 'Développe et maintient des sites web, maîtrise HTML, CSS, JavaScript et PHP'
WHERE idPoste = 1;

UPDATE rh_poste 
SET descriPoste = "Gère la comptabilité de l'entreprise : bilans, factures, fiscalité et paie"
WHERE idPoste = 2;

UPDATE rh_poste 
SET descriPoste = "Développe la stratégie commerciale, prospecte de nouveaux clients et assure le suivi des ventes"
WHERE idPoste = 3;

UPDATE rh_poste 
SET descriPoste = "Assure l'installation, la maintenance et le dépannage du réseau informatique"
WHERE idPoste = 4;

insert into rh_employe(idCandidat) values 
(3),
(4);

insert into rh_mouvement(nomMouvement) values
('embauche'),('demission');

insert into rh_employe_mouvement(idEmploye,idMouvement,dateMouvement) values 
(1,1,'2025-09-03'),
(2,1,'2025-09-04');

select *
from rh_employe emp
left join rh_candidat cdd 
    on emp.idCandidat = cdd.idCandidat
join rh_status_candidat st
    on st.idCandidat = cdd.idCandidat