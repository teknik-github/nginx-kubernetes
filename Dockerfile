FROM jkaninda/nginx-php-fpm:8.3
COPY index.php /var/www/html
RUN mkdir /mnt/nfs && chmod 777 /mnt/nfs
