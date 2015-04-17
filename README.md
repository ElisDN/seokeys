SEO-service on Yii 2
================================

Source code of SEO-service.

[Read more](http://www.elisdn.ru/blog/60/seo-service-on-yii2-installing-of-application).

Installation
------

Create a project:

~~~
composer global require "fxp/composer-asset-plugin:1.0.0"
composer create-project --prefer-dist --stability=dev elisdn/seokeys project
~~~

or clone the repository for `pull` command availability:

~~~
git clone https://github.com/ElisDN/seokeys.git project
cd project
composer global require "fxp/composer-asset-plugin:1.0.0"
composer install
~~~

Init an environment:

~~~
php init
~~~

Fill your DB connection information in `config/common-local.php` and execute migrations:

~~~
php yii migrate
~~~