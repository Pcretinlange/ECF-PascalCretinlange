# ECF - Développeur Web et Web Mobile - Juin 2022

## I. Présentation du Projet
Hypnos est un groupe hôtelier fondé en 2004. Propriétaire de 7 établissements dans les quatre
coins de l’hexagone, chacun de ces hôtels s’avère être une destination idéale pour les couples
en quête d’un séjour romantique à deux.

Chaque suite au design luxueux inclut des services hauts de gamme (un spa privatif
notamment), de quoi plonger pleinement dans une atmosphère chic-romantique.

Hypnos souhaiterait ne pas dépendre uniquement de sites tiers comme Booking.com pour la
location de ses chambres. C’est pourquoi le groupe hôtelier aimerait être pourvu de son
propre système de réservation sur un nouveau site web.

Information importante : Le paiement n'est pas une fonctionnalité à envisager, car il se fait
obligatoirement sur place.


## II. Environnement technique
Serveur :

● Version PHP 8.0.13

● Extension PHP : PDO

● MariaDB 10.6.5

● MySQL 5.7.36

● Apache 2.4.51

● WAMP 3.2.6

Pour le front :

● HTML 5

● CSS 3

● Bootstrap

● JavaScript (JQuery)

Pour le back :

● PHP 8.1 sous PDO

● Symfony

● MySQL

Yarn : v1.22.17

Npm : 8.1.2


## III. Procédure d'isntallation du projet
`git clone https://github.com:Pcretinlange/ECF-PascalCretinlange.git`

- Vérification de l'existence d'un .env dans le dossier

`composer install` 

- Modification du fichier .env pour votre BDD puis :
`php bin/console doctrine:database:create`

`php bin/console doctrine:migrations:migrate`

`yarn install` ou `npm install`

`yarn dev` ou `npm run dev`

`symfony server:start`

- Il ne vous reste plus q'à créer un compte et modifier le ROLE dans la Base de Données.
- Avec cette modification de ROLE vous avez maintenant accès au Dashboard administrateur afin de créer/modifier ou supprimer des données.
