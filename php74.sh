yum install epel-release -y
yum install http://rpms.remirepo.net/enterprise/remi-release-7.rpm -y
yum install yum-utils -y

yum-config-manager --enable remi-php7.4
yum-config-manager --disable remi-php5.4
yum-config-manager --disable remi-php5.5
yum-config-manager --disable remi-php8.2
yum-config-manager --disable remi-php8.1
yum-config-manager --disable remi-php8.0
yum-config-manager --disable remi-php8
yum-config-manager --disable remi-php7
yum-config-manager --disable remi-php7.1
yum-config-manager --disable remi-php7.2
yum-config-manager --disable remi-php7.3
yum-config-manager --disable remi-php5.6

curl -O http://vestacp.com/pub/vst-install.sh

bash vst-install.sh --nginx yes --apache yes --phpfpm no --named yes --remi no --vsftpd yes --proftpd no --iptables yes --fail2ban yes --quota no --exim yes --dovecot yes --spamassassin yes --clamav yes --softaculous no --mysql yes --postgresql no
