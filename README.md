[<img src="./art/standwithua.png" />](https://supportukrainenow.org)

* * *

[<img src="./art/logo.svg" alt="Logo Mixpost" />](https://mixpost.app)


# Welcome to Mixpost

Mixpost it's the coolest Self-hosted social media management software. 

Easily create, schedule, publish, and manage social media content in one place, with no limits or monthly subscription fees. More details on [mixpost.app](https://mixpost.app/).

Join our community:

- [Discord](https://discord.gg/5YdseZnK2Z)
- [Facebook Private Group](https://www.facebook.com/groups/inovector)

## About Mixpost Lite

Mixpost Lite is the free version of Mixpost.

This repository is the standalone application with the [Laravel Package of Mixpost Lite](https://github.com/inovector/mixpost) pre-installed and configured.

Mixpost has 3 packages:

- Lite (Personal use only)
- Pro Team (Business use)
- Pro SaaS (Launch your own SaaS and start generating revenue)

Do you want a more advanced version? **Mixpost Pro** is under development and will be released soon. Sign up to be notified when it's released [mixpost.app](https://mixpost.app/).

## Requirements

* PHP 8.1 or higher
* Database (eg: MySQL, PostgresSQL, SQLite)
* Redis 6.2 or higher
* Web Server (eg: Apache, Nginx, IIS)
* URL Rewrite (eg: mod_rewrite for Apache)

## Installation

Install Mixpost Lite with composer:

```bash
composer create-project inovector/MixpostApp
```

### Configure the app url

You will need to modify the value of the APP_URL in the `.env` file to your project URL.

For example: `APP_URL=https://your-domain.com`

### Configure the database

You will need to modify the values of the DB_* entries in the `.env` file to make sure they are aligned with your database.

Then, run migration to create all tables.

```bash
php artisan migrate
```

### Create the first user

After that you can create an initial user by executing:

```bash
php artisan mixpost-auth:create
```

You can log in to Mixpost at `/mixpost` using the user account you created.


## Server configuration (Manual)

*Please do not skip the server configuration step as it is important for Mixpost to work well.*

[Server configuration Guide](https://docs.inovector.com/books/server-configuration-mixpost)

***

## Docker Installation

<img src="./art/docker.webp" width="200px" alt="Logo Docker" />

<br>

**We provide you two methods of installing the Mixpost using Docker:**

 - Pull Docker image.
 - Build Docker image on your machine and have full control.

## Pull Docker image
This is the most suitable method, see image on [docker hub](https://hub.docker.com/r/inovector/mixpost), there are also the installation instructions. You can use [Portainer](https://www.portainer.io/) to install Mixpost Lite or simply by creating a `docker-composer.yml` file.

## Build Docker Image on your machine
You can build a docker image that will have all server configurations and start the containers.

This method is mostly for developers. If you decide to install Mixpost using this method, it means that you know what you are doing.

Download the latest version of Mixpost Lite from [here](https://github.com/inovector/MixpostApp/releases), copy .env.example to `.env`, and fill in all the necessary values:
```env
APP_PORT=80
UID=1000 // Your local user id, you can find it this way: id -u
GID=1000 // Your local group id, you can find it this way: id -g

DB_HOST=127.0.0.1
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
```

**Important**: the `DB_HOST` must be `mysql` and `REDIS_HOST` must be `redis`.

*Attention! If you have already installed the project with composer `composer create-project inovector/MixpostApp`, you can avoid step **3** below.*

### 1. Build Mixpost Lite image & Run the containers:
```bash
docker-compose up -d
```

IMORTANT NOTE!

If you are logged in as the **root** user on your machine, you must make sure that the user in the container is the owner of the files:

```bash
docker-compose exec -it app bash

# If the command above cannot log you into the container:
# `docker ps`, and identify the mixpost container name
# docker exec -it {mixpost_container_name} bash

chown -R mixpost:mixpost /var/www/html

exit
```

### 2. Make the binary `mixpost` file executable:
```bash
chmod +x ./docker/mixpost
```
This binary will help you to avoid the long command `docker-compose exec -it -u mixpost app`. If you don't want to use this binary, you are free to use docker-compose command.

### 3. Execute these commands one by one to setup Mixpost Lite:

```bash
./docker/mixpost composer install
./docker/mixpost php artisan key:generate
./docker/mixpost php artisan mixpost:setup-gitignore
./docker/mixpost php artisan queue:batches-table
./docker/mixpost php artisan storage:link
./docker/mixpost php artisan queue:restart
```

If you are reading for production, you cache the config and routes:

```bash
./docker/mixpost php artisan config:cache
./docker/mixpost php artisan route:cache
```

Do not forget to restart the queue after caching: `./docker/mixpost php artisan queue:restart`

### 4. And then you can migrate all tables:

```bash
./docker/mixpost php artisan migrate
```

### 5. Create the first user:
```bash
./docker/mixpost php artisan mixpost-auth:create
```

You can log in to Mixpost at `/mixpost` using the user account you created.