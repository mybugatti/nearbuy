---
title: Documentation
subtitle: Pour les développeurs
---
# Introduction

Bienvenue sur la documentation à destination des développeurs du projet NearBuy. Vous trouverez dans cette documentation différentes explications sur la conception des différentes fonctionnalités du projet NearBuy.
Cette documentation comporte plusieurs parties, l'une se focalise sur le code Back-End, deux autres sur le code Front-End (application mobile et application web).

Seuls certains aspects spécifiques à ce projet seront abordés dans la documentation. Il est donc recommandé d'avoir de bonnes connaissances dans les frameworks Symfony2/3, Angular2 et Ionic2.

# Installation

```shell
composer install
```

```shell
php bin/console doctrine:database:create
```

```shell
php bin/console doctrine:schema:update --force
```

```shell
php bin/console doctrine:fixtures:load
```

```shell
npm install
```

```shell
sudo npm install -g gassetic
```

```shell
gassetic build --env=prod
```

# Back-End

Le code Back-End a été conçu sur Symfony 3 et remplit plusieurs fonctions :

- définir la structure de la base de données via des modèles s'appuyant sur l'ORM doctrine
- propulser un site vitrine accompagné de la gestion de son compte destiné aux utilisateurs
- propulser une API destinée aux applications web et mobile
- rendre disponible l'application web via une URL

## Bundle de données

La base de données est conçue via des modèles doctrine. Ces modèles sont regroupés dans un bundle dédié appelé DataBundle.

### Les entités

L'ensemble des entités destinées à contenir les informations utiles au service NearBuy sont définies sous le namespace `NearBuy\DataBundle\Entity`.

#### FOSUserBundle

La pièce maîtresse de la base de données est la table user propulsé par le bundle `FOS\UserBundle`.

#### Annotations de modèle doctrine

Ces entités sont conçues dans le format d'annotations PHP. Les informations du modèle doctrine sont ainsi intégrées à la classe de l'entité via des annotations.

Exemple :

```php
/**
 * @var string
 *
 * @ORM\Column(name="color", type="string", length=7, nullable=false)
 *
 * @JMS\Expose
 * @JMS\Groups({"category", "promotion"})
 */
private $color;
```

#### Autres annotations

Vous pouvez voir que toutes les annotations ne sont pas sous le namespace `ORM`.
D'autres annotations sont utiles à d'autres fins que la définition d'un modèle Doctrine.

Les annotations sous le namespace `JMS` sont utilisées pour le processus de sérialisation utile à l'api.
La sérialisation permet ici la traduction d'une instance d'une entité en données JSON ou XML par exemple.

Ces annotations sont ainsi utiles au bundle `JMS\SerializerBundle` afin de contrôler par exemple les données "affichées" `@JMS\Expose`.

### Les types

Vous trouverez sous le namespace `NearBuy\DataBundle\Type` plusieurs définitions de Types doctrine personnalisés.

L'ensemble des Types existants sous ce namespace reposent sur le bundle `Fresh\DoctrineEnumBundle`.
Ils  permettent de donner à un champ d'une table : le type ENUM et une liste de valeurs possibles.
Les valeurs possibles sont aussi utilisées lors de la construction d'un formulaire via le formBuilder de Symfony.

Ces Types permettent ainsi de définir des listes de choix utiles pour les modèles doctrines comme pour les formulaires.

Il est nécessaire de référencer les Types personnalisés dans la configuration `config.yml`

```yml
doctrine:
    dbal:
        types:
            ReductionType: NearBuy\DataBundle\Type\ReductionType
            ValidationType: NearBuy\DataBundle\Type\ValidationType
            EmploymentRoleType: NearBuy\DataBundle\Type\EmploymentRoleType
```

### Les fixtures

Des fixtures permettent la mise en place rapide de données de test.

## Bundle API

Un bundle est entièrement dédié à la mise en place de l'api utile aux applications web et mobile.

Il contient en grande partie la logique permettant les actions CRUD sur l'api. Elle repose principalement sur les *contrôleurs* et les *formtypes*.

### FOSRestBundle

L'ensemble des contrôleurs du bundle reposent sur le contrôleur du `FOS\RestBundle` et sur ces annotations.
Il permet, entre autres, la sérialisation systématique des données en sortie de chaque action.
Chaque action est définie via une annotation selon une route et une méthode.

Exemple: 

```php
/**
 * User registration.
 *
 * @ApiDoc(
 *   resource = true,
 *   input = "NearBuy\ApiBundle\Form\AccountType",
 *   statusCodes = {
 *     200 = "Returned when successful",
 *     400 = "Returned when the form has errors"
 *   }
 * )
 * @Rest\Post("register")
 */
```

Note : Chaque action est accompagnée d'une annotation ApiDoc fournie par le bundle `Nelmio\ApiDocBundle` utile pour la documentation de l'api.


### Oauth

L'API est protégée par un système d'authentification OAuth 2 fourni par le bundle `FOS\OauthServerBundle`.
Ce système repose sur plusieurs entités utiles à la mémorisation des différents tokens attribués aux utilisateurs.

Une fixture est disponible pour mettre en place des tokens clients fixes.
Ces tokens fixes sont utilisés par les applications clientes (web et mobile).

#### Récupération des tokens

5 informations doivent être fournies dans l'entête d'une requête vers l'API :

- grant_type = password
- client_id = *oauth2_client.id*_*oauth2_client.random_id*
- client_secret = *oauth2_client.secret_id*
- username
- password

Exemple :

```shell
$ http POST http://localhost:8000/app_dev.php/oauth/v2/token \
    grant_type=password \
    client_id=1_X8W5ePRb98ThJyXZXwH7bH7Lk4xtpYj5Q3ARX6qKzQKXXwGrpe \
    client_secret=dKtuFQTXCmd99B6BgvJc3CD74oKLmdJNQz29zthrPz2JXyrYt2 \
    username=admin \
    password=admin
HTTP/1.1 200 OK
Cache-Control: no-store, private
Connection: close
Content-Type: application/json
...

{
    "access_token": "MDFjZGI1MTg4MTk3YmEwOWJmMzA4NmRiMTgxNTM0ZDc1MGI3NDgzYjIwNmI3NGQ0NGE0YTQ5YTVhNmNlNDZhZQ",
    "expires_in": 3600,
    "refresh_token": "ZjYyOWY5Yzg3MTg0MDU4NWJhYzIwZWI4MDQzZTg4NWJjYzEyNzAwODUwYmQ4NjlhMDE3OGY4ZDk4N2U5OGU2Ng",
    "scope": null,
    "token_type": "bearer"
}
```
À l'issue de cette requête, vous devriez recevoir un **access_token** et un **refresh_token**.

#### Utilisation du token

Vous devez passer dans l'entête des prochaines requêtes :

Authorization:Bearer **access_token**

Exemple :

```shell
$ http GET http://localhost:8000/app_dev.php/api/* \
    "Authorization:Bearer MDFjZGI1MTg4MTk3YmEwOWJmMzA4NmRiMTgxNTM0ZDc1MGI3NDgzYjIwNmI3NGQ0NGE0YTQ5YTVhNmNlNDZhZQ"
HTTP/1.1 200 OK
Cache-Control: no-cache
Connection: close
Content-Type: application/json
...

{
    "hello": "world"
}
```




# Les services

Les services remplissent un rôle d'interface entre l'API et les deux applications (web et mobile). 
Les deux applications étant basées sur des technologies aux fonctionnements similaires (Angular 2 et Ionic 2), il est logique que les services soient communs aux deux applications.

## BaseService

Tous les services se basent sur un service parent "BaseService" qui fournit des fonctionnalités communes à tous les services : 

- La définition des entêtes avec la définition de l'entête "Authorization" en lui passant le token nécessaire à l'accès à l'API ainsi que la définition du "Content-type"
- Une fonction permettant de formater les données avant de les envoyer à l'API
- La définition de l'URL de l'API ainsi que du préfixe présent avant chaque donnée
- La gestion des erreurs
- Des fonctions permettant l'accès aux URL des différentes entités sur l'API par l'utilisation du nom de service (convention de nommage)

Ces fonctions de base peuvent être redéfinies dans les services enfants si cela est nécessaire pour un fonctionnement spécifique.

## Les différents services

Il existe un service pour chaque entité présente dans l'API proposant la plupart du temps les 5 actions suivantes : 

- Obtenir toutes les entrées de l'entité
- Obtenir une entrée de l'entité en se basant sur un identifiant
- Ajouter une entrée de cette entité
- Modifier une entrée de cette entité
- Supprimer une entrée de cette entité

Il existe ensuite des services qui ne respectent pas cette structure et gèrent des fonctionnements particuliers tels que le RegisterService qui gère la création d'utilisateurs.

## Utilisation des services

Ces différents services sont basés sur le principe des promesses ([Promise](https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Objets_globaux/Promise)) qui est utilisé dans nos deux applications.
Ce principe permet d'attendre le résultat d'un appel à l'API afin d'effectuer un traitement par la suite, sans bloquer le déroulement du reste du code.
Voici un exemple d'appel à un service pour obtenir les promotions : 

```js
PromotionService.getPromotions().then(
    promotions => {
        // Traitement avec l'objet promotions contenant les entrées des promotions
    }
)
```

Un autre exemple d'appel à la fonction d'ajout de promotion : 

```js
// L'objet newPromotion contient les informations de la promotion à ajouter
PromotionService.create(newPromotion).then( 
    new_promotion => {
        // traitement avec l'objet new_promotion contenant la nouvelle promotion ayant été ajoutée en base
    }
```




# Dashboard Angular 2

Le dashboard a été conçu sur Angular 2  et possède plusieurs fonctionnalités :

- Présentation de différents résultats et statistiques
- Affichage des différentes entités qu'un professionnel peut avoir à gérer
- Ajout, modification et suppression de ces entités via des appels à l'API (par le biais des services)

## Installation

```shell
npm install
```

```shell
git submodule init
```

```shell
git submodule update
```

```shell
git submodule foreach git pull origin master
```

Pour lancer un serveur de développement local accessible sur le port 3000 (http://localhost:3000/): 

```shell
npm start
```

Pour build le projet : 

```shell
npm run prebuild:prod && npm run build:prod
```

Le dossier contenant le résultat du build est le dossier "dist" présent à la racine du projet.
Après le build, il est nécessaire de changer le base href dans le index.html présent dans le dossier dist si vous ne vous trouvez pas à la racine de votre serveur web.
Par exemple, si vous accédez au dashboard depuis l'URL "localhost/nearbuy/dashboard/dist/", il faudra remplir la balise base href comme ceci : 
                                                      
```html
<base href="/nearbuy/dashboard/dist/">
```


## Les pages

L'organisation du projet Angular 2 est organisée autour des différentes pages. La grande majorité du code fonctionnel est présent dans le dossier "src/app/pages".
Chaque dossier présent correspond soit à une catégorie présente dans le menu gauche du dashboard, soit à une page en particulier, ou bien à un module importé dans une de ces pages.

Tous ces dossiers possèdent la même structure : 

- Un fichier de routing (détaillé par la suite)
- Un fichier de module, qui déclare le module, ainsi que les différents sous-module
- Un fichier définissant le "component" qui contiendra le code fonctionnel
- Un fichier SCSS définissant le style du module
- Un fichier HTML contenant la structure de la page du module

Dans le cas des dossiers concernant les entités gérables dans le dashboard, on trouvera aussi des sous-dossiers "add", "edit" et "list", qui gèrent respectivement la page d'ajout, d'édition et de liste des entités.
Chacun de ces sous-modules contiendra simplement un fichier "component", un fichier HTML et un fichier SCSS.

## Le routing

Le routing permet de définir les routes des différentes pages, et se gère à deux endroits différents :

Dans le fichier pages.routing, on trouvera toutes les routes menant aux différents modules principaux.
Puis, un fichier de routing présent dans chaque dossier correspondant à une page, permet de définir les routes des sous-modules (sous-pages).

Ces routes peuvent par la suite être affectées à une entrée du menu présent sur la gauche dans le fichier pages.menu (présent à la racine du dossier "pages").
