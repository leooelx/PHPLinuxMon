#!/bin/bash

apt remove apache2 -y
apt update
echo "Set the root passowrd and press [ENTER]:"
read -s p
apt -y install php php-common php-cli php-fpm php-json php-pdo php-mysql php-zip php-gd  php-mbstring php-curl php-xml php-pear php-bcmath mariadb-server
mysql -e "create database linuxmon;"
mysql -uroot -p$ linuxmon < $(pwd)/src/LinuxmonDb.sql
mysql -uroot -pp$ -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' IDENTIFIED BY 'root' WITH GRANT OPTION;"
mysql -uroot -pp$ -e "FLUSH PRIVILEGES;"

rm /var/www/html/index.html

tar xf server_code.tar -C /var/www/html

echo "*/10 * * * * /usr/local/bin/checkLinuxMon" >> /etc/crontab
echo "/#!/bin/bash" > /usr/local/bin/checkLinuxMon
echo "CHECK=$(ps aux | grep "php -S" | wc -l)" >> /usr/local/bin/checkLinuxMon
echo "PROC_K=$(ps aux | grep "php -S" | awk '{print $2}')" >> /usr/local/bin/checkLinuxMon
echo "if [ $CHECK -gt 2 ]; then" >> /usr/local/bin/checkLinuxMon
echo "for i in $PROC_K; do kill -9 $i; done" >> /usr/local/bin/checkLinuxMon
echo "fi" >> /usr/local/bin/checkLinuxMon
echo "/usr/local/bin/checkLinuxMon &" >> /usr/local/bin/checkLinuxMon

chmod +x /usr/local/bin/checkLinuxMon

mkdir /mon
touch /mon/{cpu,ram,users,procs}

echo "#!/bin/bash" > /usr/local/bin/LinMon
echo "php -S 0.0.0.0:80 -t /var/www/html" >> /usr/local/bin/LinMon
chmod +x /usr/local/bin/LinMon

echo "[Unit]" > /lib/systemd/system/linuxmon.service
echo "After=network.target" >> /lib/systemd/system/linuxmon.service
echo "[Service]" >> /lib/systemd/system/linuxmon.service
echo "ExecStart=/usr/local/bin/LinMon" >> /lib/systemd/system/linuxmon.service
echo "[Install]" >> /lib/systemd/system/linuxmon.service
echo "WantedBy=default.target" >> /lib/systemd/system/linuxmon.service

systemctl enable linuxmon.service
systemctl enable mysql
