# Étape de construction
FROM php:8.2-fpm-alpine AS builder

# Définir le répertoire de travail
WORKDIR /app

# Installer les dépendances système
RUN apk add --no-cache curl git unzip libzip-dev \
    && docker-php-ext-install zip pdo_mysql

# Copier les fichiers nécessaires au projet
COPY composer.json composer.lock ./

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer les dépendances PHP
RUN composer install --no-dev --ignore-platform-reqs --no-scripts --no-autoloader

# Copier le reste des fichiers du projet
COPY . .

COPY env.txt .env

# Générer l'autoloader optimisé et exécuter les scripts post-installation
RUN composer dump-autoload --optimize \
    && composer install --no-dev --ignore-platform-reqs


# Exposer le port par défaut de PHP-FPM
EXPOSE 9000

# Commande de démarrage
CMD ["php-fpm"]
