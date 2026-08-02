#!/bin/bash

APP="Remicao"
APP_DIR="/www/remicao"
REPOSITORY="git@bitbucket.org:marcos-mmc/remicao.git"

echo "Iniciando deploy de $APP no diretório $APP_DIR"

# Verifica se o diretório APP_DIR existe
if [ ! -d $APP_DIR ]; then
	echo "Diretório $APP_DIR não existe."
	echo "Clonando repositório..."
	git clone $REPOSITORY $APP_DIR
	cd $APP_DIR
	echo "Repositório clonado!"
else
	cd $APP_DIR
	echo "Parando aplicação..."
	php artisan down
	echo "Atualizando repositório..."
	git pull origin master
	echo "Repositório atualizado!"
fi

echo "$(git rev-parse --short HEAD)" > last_commit.txt

echo "Executando composer..."
composer -o -n --no-dev --no-progress install
echo "Composer executado!"

echo "Corrigindo permissões..."
chmod -R 0777 app/storage
echo "Permissões corrigidas!"

echo "Executando migrations..."
php artisan migrate
echo "Migrations executadas!"

echo "Subindo aplicação..."
php artisan up
echo ""

echo "Deploy de $APP finalizado."