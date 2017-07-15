# NEARBUY PROJECT #
### IONIC 2 app + Symfony3 API ###

### Party 1 : INSTALLATION IONIC2 ###
### Getting Started ###
First clone the nearbuy project :

* cd <DocumentRoot> 
* git clone nearbuy

### Getting Started Client NEARBUY MOBILE ###

* cd client

### Installing dependencies ###
Run : 

* `npm install` from the project root.
* `ionic serve` in a terminal from the project root.

Navigate to `http://localhost:8100/`

### Party 2 : INSTALLATION SYMFONY3 ###
### Getting Started Server NEARBUY ###

* cd server

### Installing dependencies ###
Run : 

* `composer install` from the project root.
* `php bin/console doctrine:database:create`
* `php bin/console doctrine:schema:update --force`
* `php bin/console doctrine:fixture:load`
* `npm install`
* `npm install -g gassetic`
* `gassetic build --env=prod`

Navigate to `http://localhost:8000/`

Enjoy!
