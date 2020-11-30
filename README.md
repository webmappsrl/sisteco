## sisteco
Repository dedicato al progetto BIGECO / Verticalizzazione per TIMESIS / SISTECO. 

### server requirements 
- composer version : 1.10.17
- php: 7.4.12
- postgress: 13.1

### Installazione Locale
Dopo aver effettuato ```git pull``` Configurare il DB Postgress in maniera adeguata per installare poter installare Sisteco:

#### configure db postgress 
- open postgress: ```pg_ctl -D /usr/local/var/postgres start```
- create db: ```createdb mydatabasename```
- connect db: ```psql mydatabasename```
- create estension postgis: ```CREATE EXTENSION postgis;```
- create estension hstore: ```CREATE EXTENSION hstore;```

a questo punto e possibile eseguire una migrations caricando gli utenti di default con il seed:
```
php artisan migrate --seed
```

###Test 

### test e2e with Cypress 
Cypress versione supportata per i test >= 6.0.0
install cypress
```
npm install cypress --save-dev
```
lauch cypress : 
```
npx cypress open
```
selezionare il test o i test da lanciare

per poter visualizzare il codice dei test basta andare sisteco/cypress/integration

### test Feature with Phpunit 
Phpunit viene supportata nativamente da Laravel
per lanciare tutti i Feature Test
```
vendor/bin/phpunit
```
lanciare il singolo test o singolo metodo : 
```
vendor/bin/phpunit --filter <nomeTest>
```
in alternativa e possibile lanciare i test anche da Laravel
```
php artisan test
```
per poter visualizzare il codice dei test basta andare sisteco/tests/

### Branch Develop
dove vengono caricate le feature per essere testate prima di essere portare in produzione

### Branch Main
progetto in produzione 











