# ETD Search
## Setup
If on a Windows machine, setup WSL and install Ubuntu
* https://docs.microsoft.com/en-us/windows/wsl/install
* https://ubuntu.com/wsl

Install apache2:
* https://ubuntu.com/tutorials/install-and-configure-apache#2-installing-apache
Run it by typing:
```bash
sudo service apache2 start
```

Install Elasticsearch and then start it.
* https://www.digitalocean.com/community/tutorials/how-to-install-and-configure-elasticsearch-on-ubuntu-18-04

Run Elasticsearch by typing:
```bash
sudo service elasticsearch start
```

Download the [zip file](https://drive.google.com/file/d/1cn9WzmkP7g1A_Za2GxUqFnxjaGSshiJZ/view?usp=sharing) and then extract it. Next, go into the extracted directory and run the following command:
```bash
./script
```
This indexes all of the Elasticsearch entries.

Install and set up MySQL if not already installed
* https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-ubuntu-18-04

Run MySQL by typing:
```bash
sudo service mysql start
```

Once you have MySQL running, create the following tables by pasting these commands:

```sql

CREATE DATABASE etdsearch

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3

CREATE TABLE `favorites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `dissertation_id` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3

CREATE TABLE `liked_dissertations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `dissertation_id` varchar(500) DEFAULT NULL,
  `likes` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3

CREATE TABLE `search_history` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `abstract` varchar(1000) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `beg_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `date_searched` datetime DEFAULT NULL,
  `normal_search` varchar(255) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3

CREATE TABLE `tags` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `dissertation` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3

CREATE TABLE `user_likes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `dissertation_id` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3

CREATE TABLE `user_list_items` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `list` varchar(255) DEFAULT NULL,
  `dissertation_id` varchar(500) DEFAULT NULL,
  `user` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3

CREATE TABLE `user_lists` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3
```

## Tweaks for local machine
This website is being hosted on a server, which requires certain configurations. Because of this, you may need to change a few things to have the website run accurately on your local machine. Go to the constants.php file to change certain variable values. You may want to include constants.php into the .gitignore file if you plan on pushing updates to the github repo.

For example, SQL_SERVER, SQL_USERNAME, and SQL_PASSWORD should be based on where you are running your SQL server and your SQL user credentials. If you're running it locally, SQL_SERVER should most likely be set to "localhost". Same with Elasticsearch.

The ReCAPTCHA feature requires you to be using a URL that starts with 127.0.0.1 instead of localhost. However, if you have trouble getting this to work right, you can go to src/auth/login_action.php and edit the script so that it doesn't check the ReCAPTCHA. You do this by removing the
```php
if ($response->success) {
}
```
statement, but not everything inside of the statement.

For the registration script, you would just remove
```php
if ($response->success) {
        $captcha_confirmed = true;
    } else {
        echo 3;
    }
```

and replace it with
```php
$captcha_confirmed = true;
```
## Using the website
Move the clone directory to /var/www/html/

Once running, access the website through: http://127.0.0.1/etdui/public/views/index.php or http://localhost/ETD-Search/public/views/index.php

Before entering the website, you must enter the admin password: 313ctr1c1+y

## Contact
If you have any questions, send me an email: [wshie002@odu.edu](mailto:wshie002@odu.edu)

## Useful links
[Elasticsearch PHP API](https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/index.html)

[MySQL PHP API](https://www.w3schools.com/php/php_mysql_intro.asp)