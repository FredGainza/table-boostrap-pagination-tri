# Table Bootstrap pour affichage bdd avec pagination et tri

[![shields](https://img.shields.io/badge/KoPaTiK-Agency-blue)](https://shields.io/)

Création d'une table bootstrap pour afficher l'extraction des données d'une table.  
Avec une pagination automatique, le choix de l'affichage, et la possibilité de tri croissant et décroissant sur chacune des colonnes.

![Exemple de table](https://www.fgainza.fr/img/divers/pagination-github.jpg?style=centerme "Exemple de table obtenue")

## Contenu

2 versions sont disponibles, au choix :

* une **version html** où il faut renseigner les valeurs des différentes variables;
* une **fonction** à insérer directement dans votre code à l'endroit souhaité;

Un fichier d'exemple entièrement commenté est également présent.

## Pré-requis

L'utilisation de ce script nécessite :

* Bootstrap;
* Font Awesome;

L'utilisation du fichier d'exemple nécessite :

* Une base de données de référence;  
Une bdd de 1500 entrées est fournie dans le dossier "test".

## Démarrage

Pour la **version html**:

* Mettre les valeurs souhaitées dans le fichier "html-table-bootstrap.php" et copier-coller l'ensemble du code

Pour la **version fonction**:

* Enregistrer le fichier "function-table-boostrap.php" dans votre projet
* Faire un appel de ce fichier dans votre fichie de travail
* Appeler la fonction `tableBootstrap()`.  
Si vous gardez les valeurs par défaut, il vous suffit simplement d'indiquer le nom de la database et de la table dans la fonction :

```php
tableBootstrap($dbname, $table,);
```

## Auteurs

* **Frédéric Gainza** _alias_ [@FredGainza](https://github.com/FredGainza)

## License

Ce projet est sous licence ``GNU General Public License v3.0`` - voir le fichier [LICENSE](LICENSE) pour plus d'informations
