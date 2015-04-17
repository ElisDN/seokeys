SEO-service on Yii 2
================================

Source code of SEO-service.

[Read more](http://www.elisdn.ru/blog/60/seo-service-on-yii2-installing-of-application).

Installation
------

Create a project:

~~~
composer create-project --stability=dev elisdn/seokeys project
~~~

Init an environment:

~~~
php init
~~~

Fill your DB connection information in `config/common-local.php` and execute migrations:

~~~
php yii migrate
~~~
