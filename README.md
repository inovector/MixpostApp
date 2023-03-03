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


## Server configuration

**Please do not skip the server setup step as it is important for Mixpost to work well.**

### Installing FFmpeg

Mixpost has the ability to generate images from video while uploading a video file. This would not be possible without
FFmpeg installed on your server.

You need to follow FFmpeg installation instructions on their [official website](https://ffmpeg.org/download.html).

### Installing Supervisor
You need to configure a process monitor with Supervisor. To install Supervisor on Ubuntu, you may use the following command: 

```bash
sudo apt-get install supervisor
```

### Configuring Supervisor

Supervisor configuration files are typically stored in the `/etc/supervisor/conf.d`. Create the file `mixpost-horizon.conf` inside of `conf.d` folder and put this configuration content:

```bash
[program:mixpost_horizon]
process_name=%(program_name)s
command=php /path-to-your-project/artisan horizon
autostart=true
autorestart=true
user=your_user_name
redirect_stderr=true
stdout_logfile=/path-to-your-project/storage/logs/horizon.log
stopwaitsecs=3600
```

### Cron Setup
Don't forget to add a cron that running the scheduler:

`* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`