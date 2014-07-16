## geee
====
#### 程序员匿名社区
![image](https://github.com/billyct/geee/raw/master/screenshots/geee.png)


安装
-------
```bash
git clone https://github.com/billyct/geee.git
cd geee
composer install
```

1. 修改  ./config/mongo.php 的配置连接mongodb
2. 修改 ./src/qiniu/conf.php 的配置连接七牛云存储
   ./src/Gee/Qiniu.php 里面的bucket和domain


```bash
php -S localhost:8000 -t public
```


[enjoy it](http://localhost:8000)
