*Télécharger Symfony sans composer -> composer create-project symfony/website-skeleton my_project_name"
*Télécharger Symfony avec composer -> symfony new --full my_project
-----------------------------------------------------------------------------------------------------
curl -sS https://get.symfony.com/cli/installer | bash -> Installez Symfony

symfony start:server -> Lancer le serveur
-----------------------------------------------------------------------------------------------------
Controller =
php bin/console make:controller BrandNewController -> Créer le controller

-----------------------------------------------------------------------------------------------------
Créer un BDD =
Dans le fichier .env modifier en =>
    DATABASE_URL="mysql://root:root@127.0.0.1:8889/NomDeLaBDD?serverVersion=5.7" -> Modifier la config pour se connecter a la BDD

-----------------------------------------------------------------------------------------------------
=> Lancer MAMP

-----------------------------------------------------------------------------------------------------
php bin/console doctrine:database:create -> Créer une BDD au nom spécifié dans le fichier .env
php bin/console make:entity NomDeLaTable -> Configuer une table (créer une entité)
	*Renseigner les nom des champs, VARCHAR, INT etc... 
        *Sauter la partie ID, car Symfony s'occupe d'incrémenter les ID

-----------------------------------------------------------------------------------------------------
Migration = Créer une table
php bin/console make:migration -> Créer un fichier de migration
php bin/console doctrine:migrations:migrate -> Migré le fichier pour créer la table

-----------------------------------------------------------------------------------------------------
Fixture = Insérer des données
composer require orm-fixtures --dev -> Télécharger le module Fixture pour chaque nouveau projet

php bin/console make:fixtures NomFixtures -> Créer des fixtures pour l'entity correspondante
php bin/console doctrine:fixtures:load -> Remplace les données dans la BDD ( --appen pour rajouter )

-----------------------------------------------------------------------------------------------------
composer require vich/uploader-bundle -> Télécharger Bundles pour upload des fichiers
	*Modifier les chemins d'upload d'image dans vich_uploader.yaml
	*Ajouter dans l'entité un private $image;
	*ajouter les fonction public getter et setter
	*modifier le form

-----------------------------------------------------------------------------------------------------
*Tous les fichier assets (js,css,scss,img) -> placer dans le dossier public
*Créer les pages dans le dossier templates
*Commentaire dans un fichier Twig {#azeaze#}

* Lorsque le projet est fini, modifier la ligne APP_ENV=dev -> "APP_ENV=prod" (pour cacher les erreurs en ligne)

-----------------------------------------------------------------------------------------------------

EasyAdmin = Interface administrative
['ROLE_ADMIN'] = admin@admin.com / admin2021
['ROLE_USER'] = toto@toto.com / toto999

composer require admin -> télécharger le bundle
	*Créer un dossier Admin dans src/Controller/Admin
symfony console make:admin:dashboard -> Créer le controller Dashboard
	*Cela génère un controller Dashboard dans le dossier src/Controller/Admin
symfony console make:admin:crud
	*faire un admin:crud pour toute les entité de la BDD
*Gérer la vue du Dashboard dans le controller :

*Cérer le role et l'hiérarchie de chacun dans sécurity.yaml

*Convertir les clé fk de la table Property en string
	-> dans Entity/Category & Type & User
	-> rajouter une public function __toString pour convertir la conversion de l'ID en string


DEPLOIEMENT DU SITE SYMFONY
-> sur o2switch -> categorie OUTILS -> Autorisation SSH
-> copier l'adresse IP actuelle puis le coller sur ajouter une nouvelle adresse IP
-> ajouter l'autorisation
-> sur FileZilla -> Fichier -> Gestionnaire des sites -> se connecter au serveur en SFTP (FTP & SSH) avec le numéros de port donner sur o2switch
-> ouvrir le terminal du dossier a déployer -> taper "ssh gkbe7114@chupacabra.o2switch.net (nom d'utilisateur @ nom du serveur) -> valider -> yes (on nous demande si on veut valider une clés)
-> taper le mot de passe d'acces au serveur o2switchgit
-> une fois connecter au serveur
-> créer un dossier a la racine en tapant mkir nom_du_projet
-> ouvrir un deuxième terminal NON CONNECTER EN SSH mais dans le dossier du projet
-> 
-> sur FileZilla -> se connecter au serveur en reprenant la procédure de connexion en SSH avec o2switch
-> créer la base de données
-> modifier le .env -> DATABASE_URL="mysql://gkbe7114:Juliekou0101@chupacabra.o2switch.net/gkbe7114_agence_code?serverVersion=mariadb-10.3.28"
		* nom d'utilisateur(gkbe7114) + mdp(Juliekou0101) + nom du serveur(chupacabra.o2switch.net) + nom BDD(gkbe7114_agence_code) + version du serveur(mariadb-10.3.28)
-> se connecter en SSH au serveur
-> télécharger apache-pack pour générer le fichier .htaccess sur le serveur SSH dans le dossier du projet AVANT LA MIS EN LIGNE-> composer require symfony/apache-pack
-> verifier la version de php sur o2switch et le projet, sinon le changer sur le cpanel serveur o2switch

-> transfère de projet avec git -> se connecter au serveur SSH -> dans le dossier du sous-domaine -> fait un git clone du repo GIT !!! Attention au fichier .gitignore (.env)
