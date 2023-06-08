to run the program, you must first install [docker](https://www.docker.com/) and docker compose plugin

write in terminal following commands
1) `docker-compose build`
2) `docker-compose up -d`

then you need to 'migrate' the migrations

first we need to know <fpm> container id
`docker ps`

then write the id instead of example
`docker exec -it <container-id> /bin/bash`

when we get into the container, we need to write

`php artisan migrate`

that's all

in the project you can find a file called _**hello-news(postman dump).json**_.That is json endpoints. You can import it into postman as a collection

If you want to run unit tests, in environments (.env) change key DB_HOST from mysql to localhost or 127.0.0.1
