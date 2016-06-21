#!/bin/bash
if false; then
time:2016-6-20 17:18:37
author:luffyzhao
email:luffyzhao@vip.126.com
fi

USER="apache"
ISUSER=`cat /etc/passwd |grep ${USER}|wc -l`
if [ $ISUSER -eq 0 ];then
    echo "安装失败,用户${USER}不存在！"
    exit
if

ISINSTALL=`rpm -qa | grep vsftpd | wc -l`
if [ $ISINSTALL -eq 0 ];then
    echo "开始安装vsftpd"
    yum install -y vsftpd
if
#db_load
if [ -f "/usr/bin/db_load" ];then
    echo "开始安装db_load工具"
    yum install -y libdb libdb-utils
if

if [ -d "/etc/vsftpd/" ];then
    cd /etc/vsftpd/
    if [ -f "/etc/vsftpd/vsftpd.conf" ];then
        #备份
        mv vsftpd.conf ./vsftpd.conf$(date +%Y-%m-%d)
        # 配置
        cat > /etc/vsftpd/vsftpd.conf <<END
anonymous_enable=NO
local_enable=YES
local_umask=022
xferlog_enable=YES
connect_from_port_20=YES
xferlog_std_format=YES
listen=YES
write_enable=YES
anon_upload_enable=YES
anon_mkdir_write_enable=YES
anon_other_write_enable=YES
one_process_model=NO
chroot_local_user=YES
ftpd_banner=Welcom to my FTP server.
anon_world_readable_only=NO
guest_enable=YES
guest_username=${USER}
pam_service_name=vsftpd
allow_writeable_chroot=YES
END
        # 这里的密码自己更新
        cat > /etc/vsftpd/user_password.txt <<END
test
123456
END
        db_load -T -t hash -f /etc/vsftpd/user_password.txt /etc/vsftpd/user_password.db

        cat > /etc/pam.d/vsftpd <<END
auth       required     pam_userdb.so    db=/etc/vsftpd/user_password
account    required     pam_userdb.so    db=/etc/vsftpd/user_password
END
        echo "重启服务"
        systemctl restart vsftpd.service
    fi
fi

