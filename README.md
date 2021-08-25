# tmdb
A laravel package that helps you to retrieve data form https://api.themoviedb.org/ easily.

# Getting Start

- Install the package to your laravel project.
```
composer require naythukhant/tmdb
```


- Add TMDB_TOKEN which can be accessed at https://api.themoviedb.org/ to your .env 

- Add NayThuKhant\TMDB\TMDBServiceProvider::class to the providers array of config/app.php
```
     /*
     * Package Service Providers...
     */

     NayThuKhant\TMDB\TMDBServiceProvider::class,
```

- If you want to publish the configs, then run the following command.
```
php artisan vendor:publish --tag=tmdb
```


