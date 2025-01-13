FROM php:7.4-apache

# Set working directory
WORKDIR /var/www/html

# Copy your PHP files into the container
COPY . /var/www/html/

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Expose port 80 for the web server
EXPOSE 80
