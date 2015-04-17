SEO-service on Yii 2
================================

Source code of SEO-service.

[Read more](http://www.elisdn.ru/blog/60/seo-service-on-yii2-installing-of-application).

Installation
------

1. Create project:

~~~
composer global require "fxp/composer-asset-plugin:1.0.0"
composer create-project --prefer-dist elisdn/seokeys project
~~~

2. Init environment:

~~~
php init
~~~

3. Fill DB connection information in `config/common-local.php`.
3. Execute migrations:

~~~
php yii migrate
~~~

Enjoy!