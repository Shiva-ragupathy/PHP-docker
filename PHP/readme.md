## 📁 Project Structure

```text
learning-php-api/
├── Dockerfile
├── index.php       ← acts as the router
└── data/
    └── courses.json


## To build an image using this docker command
   sudo docker build /home/ubuntu/php-docker/ -t phpimg
   sudo docker container run -it -d -p 83:80 --name phpapp

Then copy the public ip and expose in the port of 83, we will get a php application.
