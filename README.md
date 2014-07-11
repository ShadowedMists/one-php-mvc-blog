one-php-mvc-blog
================

A single user blog built on one-php-mvc framework and designed to run on the Raspberry PI.

You can view the screenshots of the default blog on the [imgur album](http://imgur.com/a/PIwdW).

## Philosophy
Built on the one-php-mvc (OPM) framework, one-php-mvc-blog (OPMB) strives to maintain the low footprint, resource-mindful approach that the framework embodies. Designed for the Rasberry Pi, OPMB is a mobile-responsive, dynamic, database-driven blog platform unlike other blogging platforms that force you to generate static html files or perform additional steps to render content.  

## Features
While simplicity is the goal, OPMB has some of the normal blogging features you would expect of a modern platform. Posts are entered as Markdown and rendered on the visible page as HTML. Optionally tag your entries with keywords to help users identify entries interesting to them. To write blog posts, you must login to the administration area and create your posts from there. You may update the name of the blog or your display name at any time from the Blog Settings.

## Installation

1. Install Web Server, PHP, Database
2. Deploy Application Code
3. Deploy Database Table Structure

### Install Web Server, PHP, Database
Start by verifying you have all these packages installed:

    sudo apt-get install nginx php5-fpm mysql-server mysql-client php5-mysql
    
Configure php5-fpm:

    sudo nano /etc/php5/fpm/pool.d/www.conf
    
    # Verify that this line exists
    listen = /var/run/php5-fpm.sock

Configure nginx:

    sudo nano /etc/nginx/sites-available/default

    # php is good
    index index.php;
    
    # if file does not exist, assume URL for the router
    location / {
        ...
        try_files $uri /index.php;
        ...
    }
    
    # enable php-fpm
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }

### Deploy Application Code

    cd ~
    wget https://github.com/ShadowedMists/one-php-mvc-blog/archive/master.zip
    unzip master.zip
    sudo cp -rf one-php-mvc-blog-master/* /usr/share/nginx/www
    sudo chmod 755 -R /usr/share/nginx/www

Update database connection information and default application meta-data:

    sudo nano /usr/share/nginx/www/config.json

### Deploy Database Table Structure

    mysql -u [username] -p

    create database blog;
    exit;
    
    mysql -u [username] -p blog < /usr/share/nginx/www/db.sql


## one-php-mvc-blog Setup
Once the web server has been setup and the site files deployed, simply navigate to the home url of the webserver. A one time Setup page will prompt you to enter your blog name, your display name, and an email and password to authenticate with. Once completed, you are ready to start blogging.  
![one-php-mvc-blog Setup](http://i.imgur.com/Cs3VjKr.png)
