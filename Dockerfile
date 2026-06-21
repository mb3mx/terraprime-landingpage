# Base Image
FROM --platform=linux/amd64 httpd:latest

# Copiar todo el proyecto al directorio raíz de Apache
COPY . /usr/local/apache2/htdocs/

# Exponer puerto HTTP
EXPOSE 80
