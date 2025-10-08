FROM php:8.2-apache

# Install required dependencies for mysqli and pdo_mysql
RUN apt-get update && apt-get install -y \
        default-mysql-client \
        default-libmysqlclient-dev \
        && docker-php-ext-install mysqli pdo_mysql \
        && docker-php-ext-enable mysqli pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# Copy custom php.ini for production
COPY php.ini /usr/local/etc/php/

# Copy custom VirtualHost config
COPY config/myapp.conf /etc/apache2/sites-available/000-default.conf

# Enable rewrite module and site
RUN a2ensite 000-default.conf


# Start Apache in foreground
CMD ["apache2-foreground"]
