#!/bin/bash

LightGreen='\033[1;32m'


echo "========================================"
echo "Name: KevinApi"
echo "User: "$(whoami)
echo "Execution directory:" $(pwd)
echo "========================================"

read -p "Continue (y/n)?" choice
case "$choice" in 
	y|Y ) 
		phases=( 
		    'name: KevinApi...' $(sudo rm -R index.php)
		    'git fetch: --all' $(sudo git fetch --all)
		    'git checkout Lumen-Kevin: ' $(sudo git checkout -b Lumen-Kevin origin/Lumen-Kevin)
			'git clone kevin.git api: ' $(sudo git clone http://servicos.movida.com.br/git/movidadev/kevin.git api)
			'executing permission: storage/' $(sudo chmod -R 777 api/storage/)
		    'composer update/' $(sudo composer update)
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
		
	;;
  n|N ) echo "no";;
  * ) echo "invalid";;
esac


























