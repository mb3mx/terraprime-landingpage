# Base Image
FROM --platform=linux/amd64 httpd:latest

# Cambiar puerto de Apache a 8081 para coexistir con Traefik en red host
RUN sed -i 's/Listen 80/Listen 8081/' /usr/local/apache2/conf/httpd.conf

# Copiar todo el proyecto al directorio raíz de Apache
COPY . /usr/local/apache2/htdocs/

EXPOSE 8081
