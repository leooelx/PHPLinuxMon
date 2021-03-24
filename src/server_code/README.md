###################################################################
#Script Name	: LinuxMonService                                                                                              
#Description	: Ping and monitor all machines presents in DB                                                                 
#Args           :                                                                                           
#Author       	: Leonardo Viana Leite                                                
#Email         	: leonardo.viana@live.com                                           
###################################################################

1 - To execute the install.sh be sure that existis server_codes.tar and src/ on the current directory

2 - The private key of root must exists on /root/.ssh/id_rsa

3 - The public key of root must exists on the monitored host (/root/.ssh/authorized_keys)

4 - We have to make the first SSH connection on target to get the fingerprint.

3 - The client must be installed on the target machines to be monitored.
