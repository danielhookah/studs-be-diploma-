# Diplom

Description

## Install the Application

Run this command from the directory in which you want to install your new Slim Framework application.

```
composer create-project slim/slim-skeleton [my-app-name]
cd app-name
composer install
```

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writable.

### Database
create
```
vendor/bin/doctrine-migrations generate
vendor/bin/doctrine-migrations diff
vendor/bin/doctrine-migrations migrate
```
update only
```
vendor/bin/doctrine-migrations diff
vendor/bin/doctrine-migrations migrate
```


## Update

