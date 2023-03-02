[<img src="./art/standwithua.png" />](https://supportukrainenow.org)

* * *

[<img src="./art/logo.svg" alt="Logo Mixpost" />](https://mixpost.app)


# Welcome to Mixpost

Mixpost is a Self-hosted social media management software.

This is the standalone application with the [Mixpost Lite package](https://github.com/inovector/mixpost) pre-installed and configured.

**Mixpost Pro is under development and will be released soon. Sign up to be notified when it's
released [mixpost.app](https://mixpost.app/)**

Join our community:

- [Discord](https://discord.gg/5YdseZnK2Z)
- [Facebook Private Group](https://www.facebook.com/groups/inovector)

## Requirements

* Laravel Framework [^9.0, ^10.0]
* PHP 8.1 or higher
* Database (eg: MySQL, PostgresSQL, SQLite)
* Redis 6.2 or higher
* Web Server (eg: Apache, Nginx, IIS)
* URL Rewrite (eg: mod_rewrite for Apache)

## Installation

You may use Composer to install Mixpost:

```bash
composer create-project inovector/MixpostApp
```

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

You can use the user you created to log in to Mixpost at `/mixpost`.


## Server configuration

You need to create a supervisor configuration:

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

Don't forget to add a cron that running the scheduler:

`* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`

### Installation of FFmpeg

Mixpost has the ability to generate images from video while uploading a video file. This would not be possible without
FFmpeg installed on your server.

You need to follow FFmpeg installation instructions on their [official website](https://ffmpeg.org/download.html).