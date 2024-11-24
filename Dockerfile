# Use a PHP base image
FROM php:8.1-apache

# Copy project files
COPY . /var/www/html/

# Install required PHP extensions (e.g., PostgreSQL)
RUN docker-php-ext-install pgsql pdo pdo_pgsql

# Expose port 80
EXPOSE 80

CMD ["apache2-foreground"]
