echo "[Unit]" > /lib/systemd/system/linuxmonclient.service
echo "After=network.target" >> /lib/systemd/system/linuxmonclient.service
echo "[Service]" >> /lib/systemd/system/linuxmonclient.service
echo "ExecStart=/usr/local/bin/linuxMonClient" >> /lib/systemd/system/linuxmonclient.service
echo "[Install]" >> /lib/systemd/system/linuxmonclient.service
echo "WantedBy=default.target" >> /lib/systemd/system/linuxmonclient.service

systemctl enable linuxmonclient.service

echo "*/10 * * * * /usr/local/bin/checkLinuxMonClient" >> /etc/crontab
echo "/#!/bin/bash" > /usr/local/bin/checkLinuxMonClient
echo "CHECK=$(ps aux | grep "checkLinuxMonClient" | wc -l)" >> /usr/local/bin/checkLinuxMonClient
echo "PROC_K=$(ps aux | grep "checkLinuxMonClient" | awk '{print $2}')" >> /usr/local/bin/checkLinuxMonClient
echo "if [ $CHECK -gt 2 ]; then" >> /usr/local/bin/checkLinuxMonClient
echo "for i in $PROC_K; do kill -9 $i; done" >> /usr/local/bin/checkLinuxMonClient
echo "fi" >> /usr/local/bin/checkLinuxMonClient
echo "/usr/local/bin/checkLinuxMon &" >> /usr/local/bin/checkLinuxMonClient

cp $(pwd)/checkLinuxMonClient /usr/local/bin/linuxMonClient

chmod +x /usr/local/bin/linuxMonClient
