Test wizishop
--------------

Le test a éte codé sur Symfony 2.8

1) Créer la base de donnée

php app/console doctrine:database:create

2) Mettre à les jour les tables

php app/console doctrine:schema:udpate --dump-sql
php app/console doctrine:schema:udpate --force

3) Charger les fixtures des produits

php app/console doctrine:fixtures:load

4) Installer les assets

php app/console assets:install
php app/console assetic:dump
