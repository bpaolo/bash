#!/bin/bash
LightGreen='\033[1;32m'
LightYellow='\033[1;33m'
echo "========================================"
echo "Name: Docker - Composer - Git"
echo "User: "$(whoami)
echo "Execution directory:" $(pwd)
echo "========================================"

read -p "Continue (y/n)?" choice
case "$choice" in 
	y|Y ) 
		phases=( 
		    'atualiza ubuntu: KevinDocker...'$(sudo apt-get update)
		    'key: GPG...'$(sudo apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys 58118E89F3A912897C070ADBF76221572C52609D)
		    'add repository : APT sources:...'$(sudo apt-add-repository 'deb https://apt.dockerproject.org/repo ubuntu-xenial main')
		    'atualiza pakage: KevinDocker...'$(sudo apt-get update)
		    'install docker...'$(sudo apt-get install -y docker-engine)
		    'remove sudo...'$(sudo usermod -aG docker $(whoami))
		    
		    #composer
		    'install composer...'$(curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer)
		    'change global...'$(sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer)

		    #git 
		    'update pakage: KevinDocker...'$(sudo apt-get update)
		    'install git...'$(sudo apt-get install git)
		)   

		for i in $(seq 1 100); do  
		    sleep 000.1

		    if [ $i -eq 100 ]; then
		        echo -e "XXX\n100\nDone!\nXXX"
		    elif [ $(($i % 25)) -eq 0 ]; then
		        let "phase = $i / 25"
		        echo -e "XXX\n$i\n${phases[phase]}\nXXX"
		    else
		        echo $i
		    fi 
		done | whiptail --title 'KevinDocker' --gauge "${phases[0]}" 6 60 0
		echo -e "${LightYellow}Execute the commands below:"
		echo -e "${LightGreen}cd docker-kevin/www/ && ./kevinApi.sh"
	;;
  n|N ) echo "no";;
  * ) echo "invalid";;
esac







