# Wir nutzen ein offizielles PHP Image mit Apache
FROM php:8.2-apache

# Installiere Systemabhängigkeiten und PHP-Erweiterungen (für MySQL notwendig)
RUN docker-php-ext-install pdo pdo_mysql

# Aktiviere mod_rewrite für saubere URLs (falls du Routing nutzt)
RUN a2enmod rewrite

# Arbeitsverzeichnis im Container setzen
WORKDIR /var/www/html

# Setze die Berechtigungen für den Upload-Ordner (wichtig für Bilder!)
# Wir erstellen den Ordner vorab, damit keine Rechteprobleme entstehen
RUN mkdir -p /var/www/html/public/uploads && \
    chown -R www-data:www-data /var/www/html/public/uploads && \
    chmod -R 777 /var/www/html/public/uploads

# Port 80 freigeben
EXPOSE 80