# Use a imagem base do PHP com Apache
FROM php:7.1-apache

# Instale extensões PHP necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copie seu código para o diretório do Apache
COPY . /var/www/html/

# Defina as permissões apropriadas
RUN chown -R www-data:www-data /var/www/html/

# Exponha a porta 80
EXPOSE 80