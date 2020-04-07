Andulka Example Project
=================

This project is just an example.

Requirements
------------

- Web Project for Nette 3.0 requires PHP 7.2


Installation
------------

The best way to install Web Project is using Compose. Then use command:

	composer install

Make directories `temp/` and `log/` writable.

 setup database in `app/config/local.neon`

Install database (run sql patches)

	php cli migrations:migrate

After this you need to configure webserver. 
Root of public files is `www` dir



Installation Via Docker
------------

Run

	docker-compose up --build
	
Thats all. Application is ready on  port: `8123`. (`127.0.0.1:8123`)
