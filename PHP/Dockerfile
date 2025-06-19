# Use the official Apache HTTPD image from Docker Hub
FROM: ubuntu:latest
MAINTAINER SHIVA
LABEL version="1.0"

# Install Apache, PHP, and required PHP modules
RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php php-mysql && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*
# Remove the default index.html file provided by Apache
RUN rm -f /var/www/html/index.html

# Copy your application files to the container
COPY index.php /var/www/html/index.php  

# Expose port 80 to access the web server
EXPOSE 80

# Start Apache in the foreground
ENTRYPOINT ["apachectl", "-D", "FOREGROUND"]
