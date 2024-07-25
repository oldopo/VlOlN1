# VlOlN1 Aplication

## Inštalácia
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

4. Spustite docker kontainer:
   ```bash
   docker-compose up

5. Databáza a tabuľka sa importujte automaticky z:
   ```text
   sql/database.sql

6. Spustenie (Uistite sa, že beží docker desktop)
    ```bash
    docker-compose up

7. Testovanie
   ```bash
    vendor/bin/phpunit

8. Vytvorenie Survey, prístup na formulár:
   ```href
   http://localhost:8000/survey

9. Zobrazenie Results, výpis výsledkov:
   ```href
   http://localhost:8000/results
