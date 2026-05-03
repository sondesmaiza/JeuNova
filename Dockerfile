# ─── Stage: PHP + Apache (Alpine-based for minimal footprint) ───────────────
FROM php:8.2-apache

# Install only required PHP extensions + system deps
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libzip-dev \
        zip \
        unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        gd \
        zip \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod rewrite headers

# PHP memory optimisations for low-RAM VPS
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Apache: listen on port 5000, remove default site, add custom vhost
COPY docker/apache.conf /etc/apache2/sites-available/jeunova.conf
RUN sed -i 's/Listen 80/Listen 5000/' /etc/apache2/ports.conf \
    && a2dissite 000-default.conf \
    && a2ensite jeunova.conf

# Copy application source
COPY . /var/www/html/

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

EXPOSE 5000

CMD ["apache2-foreground"]
