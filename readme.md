
这是一个 metronic（v4.1.0） 风格的 laravel 后台框架

为了适应metronic风格，修改了 Laravel form builder 代码，但是并没有提交到 Laravel form builder仓库,包含在了项目中

这不是一个laravel 插件，而是一个可以执行的项目.

以控件的形式组织form 界面，可以参考widget目录中现有的控件实现个性化的控件。


按如下操作

1. git clone https://github.com/bohan1115/metronic_laravel_admin.git

2. cd metronic_laravel_admin

3. 执行 composer 安装 laravel

4. 修改 .env 中数据库配置，建立一个空数据库

5. 执行 ./artisan migrate

6. 执行 ./artisan db:seed

7. 执行 ./artisan serve

user:admin
password:123456

项目里包含了 一个example

界面截图：<br>
<img src='https://github.com/bohan1115/metronic_laravel_admin/blob/master/screen/2.png' width="60%" height="60%" >
<img src='https://github.com/bohan1115/metronic_laravel_admin/blob/master/screen/3.png' width="60%" height="60%" >
<img src='https://github.com/bohan1115/metronic_laravel_admin/blob/master/screen/4.png' width="60%" height="60%" >
<img src='https://github.com/bohan1115/metronic_laravel_admin/blob/master/screen/5.png' width="60%" height="60%" >
<img src='https://github.com/bohan1115/metronic_laravel_admin/blob/master/screen/6.png' width="60%" height="60%" >



