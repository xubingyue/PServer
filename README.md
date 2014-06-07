PServer
=======

Introduction
------------

- guard 运维PHP服务器
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
	7. 生成证书


			cd /usr/local/nginx/conf
			openssl genrsa -des3 -out server.key 1024
			openssl req -new -key server.key -out server.csr
			openssl rsa -in server.key -out server_nopwd.key
			openssl x509 -req -days 365 -in server.csr -signkey server_nopwd.key -out server.crt

    8. nginx.conf配置样例


			server {
				listen       443 ssl;
				index  index.php;
				client_max_body_size 100m;
				root  /home/randyliu/github/pserver/guard/htdocs;
				ssl_certificate      server.crt;
				ssl_certificate_key  server_nopwd.key;
				ssl_session_cache    shared:SSL:1m;
				ssl_session_timeout  5m;
				ssl_ciphers  HIGH:!aNULL:!MD5;
				ssl_prefer_server_ciphers  on;
				location /
				{
					try_files $uri @php;
				}
				location @php 
				{
					fastcgi_pass   127.0.0.1:9000;
					fastcgi_index  index.php;
					fastcgi_param  SCRIPT_FILENAME /home/randyliu/github/pserver/guard/scripts/main.php; 
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
    8. 修改php.ini, 支持大文件上传。
        date.timezone = Asia/Shanghai
        display_errors = Off
		upload_max_filesize = 100M
		post_max_size = 100M
		max_execution_time = 600
		max_input_time = 600
    9. cp /usr/local/etc/php-fpm.conf.default php-fpm.conf
    10. 修改php-fpm.conf
        user = randyliu
        group = users

- XDebug

	1. 修改/usr/local/etc/php.ini文件， 加入如下内容：


			[Xdebug]
			xdebug.profiler_enable=on
			xdebug.trace_output_dir="/var/log/xdebug"
			xdebug.profiler_output_dir="/var/log/xdebug"
			xdebug.max_nesting_level = 10000
			xdebug.auto_trace=On
			xdebug.show_exception_trace=On
			xdebug.remote_enable=On
			xdebug.remote_host=192.168.0.29
			xdebug.remote_port=9000
			xdebug.remote_handler=dbgp
	2. mkdir -p /var/log/xdebug
	3. 修改xdebug.remote_host为开发机地址, xdebug需要connect这个主机的9000端口。

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

- Lua
	1. wget http://www.lua.org/ftp/lua-5.2.3.tar.gz
	2. tar -xf lua-5.2.3.tar.gz
	3. cd lua-5.2.3
	4. 修改 lua-5.2.3/src/Makefile中的linux目标， 加入-lncurses。
	5. make linux
	6. make install

- LCOV
	1. wget http://downloads.sourceforge.net/ltp/lcov-1.11.tar.gz
	2. tar -xf lcov-1.11.tar.gz
	3. cd lcov-1.11
	4. make install


- Doxygen
	1. yum install doxygen
    

- Chkconfig
    1. pserver/etc/init.d/* /etc/init.d
    2. chkconfig --add php-fpm
    3. chkconfig php-fpm on
    4. chkconfig --add nginx
    5. chkconfig nginx on
    6. chkconfig --add mysql
    7. chkconfig mysql on

- iptables


		iptables -I INPUT -p tcp --dport 80 -j ACCEPT
		iptables -I OUTPUT -p tcp --sport 80 -j ACCEPT
		iptables -I INPUT -p tcp --dport 443 -j ACCEPT
		iptables -I OUTPUT -p tcp --sport 443 -j ACCEPT
		service iptables save
