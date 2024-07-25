# Použitie oficiálneho PHP obrazu s Apache
FROM php:8.1-apache

# Nastavenie pracovného adresára
WORKDIR /var/www/html

# Inštalácia potrebných PHP rozšírení
RUN docker-php-ext-install pdo pdo_mysql

# Skopírovanie lokálneho kódu do kontajnera
COPY . /var/www/html

# Inštalácia Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Nastavenie práv pre súbory a adresáre
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Exponovanie portu 80
EXPOSE 80

# Spustenie Apache servera
CMD ["apache2-foreground"]
