#!/bin/bash
LightGreen='\033[1;32m'
LightYellow='\033[1;33m'
echo "========================================"
echo "Name: KevinDocker"
echo "User: "$(whoami)
echo "Execution directory:" $(pwd)
echo "========================================"

read -p "Continue (y/n)?" choice
case "$choice" in 
	y|Y ) 
		phases=( 
		    'name: KevinDocker...'
		    'user: '$(whoami)
		    'git clone DockerVetor docker-kevin' $(sudo git clone http://servicos.movida.com.br/git/movidadev/DockerVetor.git docker-kevin)
			'chmod docker-kevin/www/' $(sudo chmod 777 -R docker-kevin/www/)
			'generate KevinApi.sh' $(sudo cp kevinApi.sh docker-kevin/www/)
		    
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







