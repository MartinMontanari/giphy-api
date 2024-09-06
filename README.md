<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

--------------------------------------
## About the application
This is a simple Rest API that consumes Giphy's public API. The API is based on PHP8.2 and Laravel11.22.0, with Eloquent and MySQL and implements Oauth2.0 using Laravel Passport.

### Project structure

```
project-root/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   ├── Requests/
│   │   └── Kernel.php
│   ├── Models/
│   ├── Providers/
│   ├── Services/
│   └── Repositories/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── routes/
│   ├── api.php
│   └── channels.php
├── storage/
├── tests/
├── vendor/
├── .env
├── artisan
├── composer.json
└── phpunit.xml
```

--------------------------------------
## How to download and install the project

--------------------------------------
### Dependencies
First that all you need check if you have installed the followed dependencies:
- The following instructions and documentations that we share with you are for Linux based systems, but you can get the docs for Windows or macOS in the same websites. 
- [Git (official)](https://git-scm.com/downloads) or [Git (Digital Ocean)](https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-22-04): We have to use Git for branch managing and versioning.
- [Docker (Digital Ocean)](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04) and [Docker compose (Digital Ocean)](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-22-04): We have to use Docker and Docker Compose for container managing without operative systems limitations.
- [Composer (Digital Ocean)](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04): We have to use Composer for php dependencies managing
- We have to install php 8.2 and some other php packages, just need to open a new terminal and run the following command:`sudo apt install php8.2 php8.2-cli php8.2-common php8.2-mbstring php8.2-xml php8.2-mysql php8.2-zip php8.2-curl php8.2-gd php8.2-bcmath php8.2-fpm`
------------------------
### Repository cloning
Open a new terminal (linux/macOS) or a GitBash or PowerShell (Windows) and clone the repository with one of the following commands:
- `git@github.com:MartinMontanari/giphy-api-wrapper.git` / if you have configured the SSH key in your GitHub account.
- `https://github.com/MartinMontanari/giphy-api-wrapper.git` / if you haven't configured the SSH key in your GitHub account you could clone it by HTTPS and use your credentials.
- `https://github.com/MartinMontanari/giphy-api-wrapper` / if you haven't configured a GitHub account you should download the code as ZIP file clicking the green button <> Code.
------------------------
### Running the application
1 - Go to the folder where you're downloaded/cloned the application.

2 - Create a `.env` file at the root folder and just copy/paste the `.env.example` data. 

3 - Once you're done, open a new terminal/PowerShell and run the command ➜  `./vendor/bin/sail up`.
- That's should create the docker environment and running the application. But It's not working yet.

4 - At the root folder you should open a new terminal/PowerShell and run the command ➜  ` ./vendor/bin/sail artisan migrate`

- That's should run Sail's migrations.

5 - Once there are done, you should execute ➜  `./vendor/bin/sail artisan key:generate`.

6 -

7 - Now you could test the health check opening a web browser and going to the URL `http://localhost/` and the API should return
```
// 20240905200940
// http://localhost/

{
"Laravel": "11.22.0"
}
```

The API is licenced by [MIT license](https://opensource.org/licenses/MIT).
