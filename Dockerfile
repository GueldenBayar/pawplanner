# Wir nutzen ein offizielles PHP Image mit Apache
FROM php:8.2-apache

# Installiere Systemabhängigkeiten und PHP-Erweiterungen (für MySQL notwendig)
RUN docker-php-ext-install pdo pdo_mysql

# Aktiviere mod_rewrite für saubere URLs (falls du Routing nutzt)
RUN a2enmod rewrite

# Arbeitsverzeichnis im Container setzen
WORKDIR /var/www/html

# System Dependencies installieren
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP Extensions für MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Apache Config für Rewrite anpassen
RUN echo '<Directory /var/www/html>\n    AllowOverride All\n    Require all \
    granted\n</Directory>' > /etc/apache2/conf-available/docker.conf && \
    a2enconf docker

# Alle Dateien aus lokalem Verzeichnis in Container kopieren
COPY . .

# Setze die Berechtigungen für den Upload-Ordner (wichtig für Bilder!)
# Wir erstellen den Ordner vorab, damit keine Rechteprobleme entstehen
RUN mkdir -p /var/www/html/public/uploads && \
    chown -R www-data:www-data /var/www/html/public/uploads && \
    chmod -R 777 /var/www/html/public/uploads

# Port 80 freigeben
EXPOSE 80

# Apache starten
CMD ["apache2-foreground"]