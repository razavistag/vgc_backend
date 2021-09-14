Deployment
- initiate .env file

>     -- assign DB
>     -- assign email configuration

- composer install
- generate an app key 
> $ php artisan key:generate

-- link the storage 

> $ php artisan storage:link

-- migrate db 

> $ php artisan migrate

-- install passport 

> $ php artisan passport:install

-- seed the data 

> $ php artisan db:seed

-- run the application 

> $ php artisan serve



Note
> PDOException::("SQLSTATE[42000]: Syntax error or access violation:1118 Row size too large (> 8126)

    

innodb_strict_mode = OFF in ->sql my.ini for solve

