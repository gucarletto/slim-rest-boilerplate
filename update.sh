if (( $EUID != 0 )); then
	echo "Deve ser rodado como root"
  exit
fi
git pull
php /usr/local/bin/composer dump-autoload