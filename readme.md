Nette Web Project
=================

Welcome to the Nette Web Project! This is a basic skeleton application built using
[Nette](https://nette.org), ideal for kick-starting your new web projects.

Nette is a renowned PHP web development framework, celebrated for its user-friendliness,
robust security, and outstanding performance. It's among the safest choices
for PHP frameworks out there.

If Nette helps you, consider supporting it by [making a donation](https://nette.org/donate).
Thank you for your generosity!


Requirements
------------

This Web Project is compatible with Nette 3.2 and requires PHP 8.1.


## Inštalácia
------------

1. Naklonujte repozitár:
   ```bash
   git clone https://github.com/oldopo/VlOlN1.git
   cd VlOlN1

2. Nainštalujte závislosti:
   ```bash
   composer install

3. Simulačná databáza definovaná v test local súbor pre pripojenie k databáze:
   ```text
   config/local.neon

4. Databáza a tabuľka sa importujte automaticky z:
   ```text
   sql/database.sql

5. Spustenie (Uistite sa, že beží docker desktop)
    ```bash
    docker-compose up -d

6. Testovanie
   ```bash
    vendor/bin/phpunit

7. Vytvorenie Survey, prístup na formulár:
   ```href
   http://localhost:8080/survey

8. Zobrazenie Results, výpis výsledkov:
   ```href
   http://localhost:8080/results
