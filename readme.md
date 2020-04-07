Andulka Example Project
=================

This project is just an example.



Installation Via Composer
------------

Then use command:

	composer install

Make directories `temp/` and `log/` writable.

 setup database in `app/config/local.neon`

Install database (run sql patches)

	php cli migrations:migrate

After this you need to configure webserver. 

Root of public files is `www` dir. (See nginx conf example `Docker/nginx/default.conf` )


Installation Via Docker
------------
This is the simplest way to run application.

Its recommended to use Docker on linux. 
For some reason network between containers are slow on windows. 

Run

	docker-compose up --build
	
Thats all. Application is ready on  port: `8123`. (`127.0.0.1:8123`).

Please make sure that dir `temp` and `log` are writable. 

(for dev / test purposes you can `sudo chmod 777 -R temp && chmod 777 -R log`)
