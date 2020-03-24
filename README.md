
php >= 7.2.* Laravel 7.*

安装步骤
-
~~~
- cp .env.example .env (copy .env files)
- composer install
- php artisan key:generate
- php artisan jwt:secret
- php artisan migrate --seed
~~~

拓展工具
-
- 逆向数据填充
[iseed](https://github.com/orangehill/iseed)
~~~ 
单张表/多张表
php artisan iseed my_table
php artisan iseed my_table,another_table

指定类名前缀，防止与原seeder文件冲突：
php artisan iseed my_table --classnameprefix=Customized
~~~

建议
-
- 自定义验证类字段名称
~~~
写在 resources/lang/zh-CN/validation.php 和 resources/lang/en/validation.php attributes属性下
~~~

常用命令行
-
- 数据库迁移
~~~
新建数据表
php artisan make:migration create_xxx_table --create=xxx

向已存在的表中添加字段
php artisan make:migration add_columns_to_xxx_table --table=xxx

执行迁移文件
php artisan migrate

回滚迁移文件
php artisan migrate:rollback

重新执行迁移文件和seed类
php artisan migrate:refresh --seed
~~~
