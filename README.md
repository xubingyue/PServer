PServer
=======

Introduction
------------

- center 登录和支付服务器
- guard 运维服务器
- mysql_proxyd 数据库代理服务器
- scened 场景服务器
- robotd 机器人
- common 公共库

Install
-------

- OpenSSL

    1. wget http://www.openssl.org/source/openssl-1.0.1g.tar.gz
    2. tar -xf openssl-1.0.1g.tar.gz
    3. cd openssl-1.0.1g
    4. ./config
    5. make
    6. make install

- Nginx

    1. wget http://nginx.org/download/nginx-1.7.1.tar.gz
    2. tar -xf nginx-1.7.1.tar.gz
    3. cd nginx-1.7.1
    4. ./configure --with-http_ssl_module
    5. make
    6. make install
    7. nginx.conf配置样例

        user  randyliu
        server
        {
            listen       80;
            server_name  localhost;
            root  /home/randyliu/pgame/trunk/pguard/htdocs;
            index  index.php;
            client_max_body_size 2048k;

            location /
            {
                try_files $uri @php;
            }

            location @php 
            {
                fastcgi_pass   127.0.0.1:9000;
                fastcgi_index  index.php;
                fastcgi_param  SCRIPT_FILENAME /home/randyliu/pgame/trunk/pguard/scripts/main.php; 
                include        fastcgi_params;
            }
        }

- Php

    1. wget http://ar2.php.net/distributions/php-5.5.12.tar.gz
    2. tar -xf php-5.5.12.tar.gz
    3. cd php-5.5.12
    4. ./configure --enable-fpm --with-config-file-path=/usr/local/etc
    5. make
    6. make install
    7. cp php.ini-development /usr/local/etc/php.ini
    8. 修改php.ini
        date.timezone = Asia/Shanghai
        display_errors = Off
    9. cp /usr/local/etc/php-fpm.conf.default php-fpm.conf
    10. 修改php-fpm.conf
        user = randyliu
        group = users

- MySQL

    1. tar -xf mysql-5.6.16.tar.gz
    2. mkdir build
    3. cd build
    4. ccmake ../mysql-5.6.16
    5. make
    6. make install
    7. groupadd mysql
    8. useradd mysql -g mysql -M -s /sbin/nologin
    9. mkdir -p /var/mysql/pgame
    10. ./mysql_install_db --user=mysql --basedir=/usr/local/mysql --ldata=/var/mysql/pgame/
    11. cp /usr/local/mysql/support-files/my-default.cnf /etc/my.cnf
    12. 修改my.cnf
        [mysqld]
        user=mysql
        basedir=/usr/local/mysql
        datadir=/var/mysql/pgame
    13. cp /usr/local/mysql/support-files/mysql.server /etc/init.d/mysql
    14. cp /usr/local/mysql/bin/my_print_defaults /usr/bin/
    15. 修改mysql脚本
        basedir=/usr/local/mysql/
        datadir=/var/mysql/pgame
    16. 修改/etc/bashrc文件
        export PATH=$PATH:/usr/local/mysql/bin/
    17. 修改/etc/ld.so.conf文件
        /usr/local/mysql/lib/
    18. 执行ldconfig
    

- Chkconfig
    1. pserver/etc/init.d/* /etc/init.d
    2. chkconfig --add php-fpm
    3. chkconfig php-fpm on
    4. chkconfig --add nginx
    5. chkconfig nginx on
    6. chkconfig --add mysql
    7. chkconfig mysql on


