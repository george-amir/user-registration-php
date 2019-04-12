# PHP User Registration

## Installation
### Create the database
create a database and run this sql to create a users table
```
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
```
### Clone the repo.
```
git clone https://github.com/george-amir/user-registration-php.git
```

### Cd into repo directory
```
cd user-registration-php
```

### Composer Install
```
composer install
```

### Config database connection
Edit config.php with your database connection info
```
return [
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'user_registration',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
];
```

### Run the server
```
php -S localhost:8000
```
