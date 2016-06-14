#安装apache subversion
----
    yum install -y httpd php php-pdo httpd-devel mod_dav_svn subversion mod_ssl 
----
#开启php短标签
----
    vim /etc/php.ini
----
#找到 
----
    short_open_tag = Off
----
#改成
----
    short_open_tag = On
----

#开机启动
----
    chkconfig httpd on
    chkconfig svnserve on
----

#我习惯到下载的软件放在 /root/soft/ 目录下
----
    mkdir soft && cd soft
    wget https://github.com/usvn/usvn/archive/1.0.7.tar.gz
    tar zxvf 1.0.7.tar.gz
----
#建立usvn目录
----
    mkdir /home/apache
    mkdir /home/apache/usvn/
    mv usvn-1.0.7 /home/apache/usvn/
----
#建立usvn访问地址
----
    vim /etc/httpd/conf.d/usvn.conf
----
#添加vohost
----
    Listen 7777
    <VirtualHost *:7777>
        DocumentRoot "/home/apache/usvn/usvn-1.0.7/public"
        ServerName tianjin.oms.com
        ErrorLog "/var/log/usvn-error.log"
        CustomLog "/var/log/usvn-access.log" common
        <Directory "/home/apache/usvn/usvn-1.0.7/public">
            Options +SymLinksIfOwnerMatch
            AllowOverride All
            Order allow,deny     
            Allow from all
        </Directory>
    </VirtualHost>
----

#启动apache
----
    service httpd start
----
#访问
----
    http://120.25.218.245:7777/install.php
----

#看着选就好了,
#记住 选择数据库连接时要选 pdo-sqlite 
#我没给服务器装mysql
#跟据提示把 最后面那个 大框里的内容 加到 /etc/httpd/conf.d/subversion.conf 里

#重启apache
----
    service httpd restart
----