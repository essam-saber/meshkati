

### Installation

The application require php 7.4 or above.

Install the dependencies and devDependencies and start the server.

```sh
# pull project repository from github
$ git clone https://github.com/essam-saber/meshkati.git
# get inside the project path
$ cd meshkati
# install project dependencies and the third party packages
$ composer install
# create database schema
$ php artisan migrate
# seed the required database data such as (credentials, pre defined values ...etc)
$ php artisan db:seed
```

### login credentials

``` 
default email: admin@meshkati.com
default password: 123456
```
