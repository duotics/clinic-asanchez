Configuration for docker

NEW IMPLEMENTATION TO SERVER!!! 20230206

docker run --name myXampp5 -p 41051:22 -p 41052:80 -p 41053:443 -p 41054:3306 -d -v d:/DEV/xampp5:/www -v myXampp5db:/opt/lampp/var/mysql tomsik68/xampp:5

http://localhost:41052/www/
https://localhost:41053/www/



****** IMPORTANT INFORMATION TO DOCKER - COMPOSER - GIT(optional in Docker , can be used git in windows)

in vsCODE
	in *Docker* Extension
		in *Containers* section
			find my container (ah-xampp5)
				right clic -> Attach Visual Studio Code
					This show me the www folder of my docker

* install composer in container
	- Open terminal in vSCODE
	$ apt update
	$ apt install wget php-cli php-zip unzip
	$ wget -O composer-setup.php https://getcomposer.org/installer
	$ php composer-setup.php --install-dir=/usr/local/bin --filename=composer
	$ composer -v

	After install composer can be run, but before need install php mbstring in docker
	$ apt install php7.3-mbstring
	now can be executed composer
	$ composer install
	$ composer install --ignore-platform-reqs  //From docker with php7 cli

	ok dependences installed

* install git in container
	- Open terminal in vSCODE
	$ apt update
	$ apt install git
	$ git --version

	git config --global user.name "Daniel Banegas"
	git config --global user.email "dbanegasl@gmail.com"

	Test Git in another development enviroment

* Uninstall git

	$ sudo apt-get remove git
	Uninstall git and it's dependent packages
	To remove the git package and any other dependant package which are no longer needed from Ubuntu Trusty.

	$ sudo apt-get remove --auto-remove git
	Purging git
	If you also want to delete configuration and/or data files of git from Ubuntu Trusty then this will work:

	$ sudo apt-get purge git
	To delete configuration and/or data files of git and it's dependencies from Ubuntu Trusty then execute:

	$ sudo apt-get purge --auto-remove git

* Install Nodejs and NPM -> this process can be an issue, the npm is not fully compatible with nodejs
	$ apt update
	$ apt install nodejs
	$ apt install npm


#FOR PROGRAMMING
	##DATE TIME MANAGE PHP
		###PHP POO intldateformatter
		https://www.php.net/manual/es/intldateformatter.create.php
		###ICU LOCALE
		https://icu4c-demos.unicode.org/icu-bin/locexp?d_=en&_=es_EC
		###FORMAT
		https://unicode-org.github.io/icu/userguide/format_parse/datetime/