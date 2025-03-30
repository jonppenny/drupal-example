FROM creo/drupal:11.1.4

# Add sudo in order to run drupal CLI as the www-data user
RUN apt-get update && apt-get install -y sudo less

# Make env folder and file for reference
RUN mkdir -p /var/www/env

# Composer
RUN curl -sS https://getcomposer.org/installer -o /bin/composer-setup.php
RUN sudo php /bin/composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Drupal CLI
RUN curl -o /bin/drupal.phar https://drupalconsole.com/installer
RUN chmod +x /bin/drupal.phar
RUN sudo mv /bin/drupal.phar /usr/local/bin/drupal

# Install Drush within the Drupal project
WORKDIR /var/www/html
RUN composer require drush/drush

# Set Drush alias globally
RUN ln -s /var/www/html/vendor/bin/drush /usr/local/bin/drush

# Verify Drush installation
RUN drush --version || echo "Drush installation failed"

# Enable PHP intl
RUN apt-get update \
  && apt-get install -y zlib1g-dev libicu-dev g++ \
  && docker-php-ext-configure intl \
  && docker-php-ext-install intl \
  && docker-php-ext-enable intl

# Ensure Apache (www-data) owns the /var/www/html directory and make it writable
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

# Cleanup
RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN echo 'memory_limit = 2048M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;
