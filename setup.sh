#!/usr/bin/env bash
setup_laravel() {
cd /var/www/html/$1
mysql -uroot -ptieungao -e "create database $1;"
sed -i -e "s/DB_DATABASE=homestead/DB_DATABASE=$1/g" .env
composer install

php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan ide-helper:generate

chmod -R 777 storage
chmod -R 777 bootstrap
php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5"
php artisan vendor:publish
cd /var/www/html/$1
}

setup_editor() {
cd /var/www/html/$1
[ -d public/upload ] || mkdir public/upload
[ -d public/files ] || mkdir public/files
chmod -R 777 public/upload
chmod -R 777 public/files

cd public && bower install --allow-root && [ -d kcfinder ] || git clone git@github.com:sunhater/kcfinder.git
sed -i  "s/'disabled' => true/'disabled' => false/g" kcfinder/conf/config.php
sed -i  's/"upload"/"\/upload"/g' kcfinder/conf/config.php

cat > bower_components/ckeditor/config.js  <<'endmsg'
CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.filebrowserBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=images';
	config.filebrowserFlashBrowseUrl = '/kcfinder/browse.php?opener=ckeditor&type=flash';
	config.filebrowserUploadUrl = '/kcfinder/upload.php?opener=ckeditor&type=files';
	config.filebrowserImageUploadUrl = '/kcfinder/upload.php?opener=ckeditor&type=images';
	config.filebrowserFlashUploadUrl = '/kcfinder/upload.php?opener=ckeditor&type=flash';
	//do not add extra paragraph to html
	config.autoParagraph = false;
};
endmsg
cd /var/www/html/$1
}

echo "Start setup..."

cp .env.stage .env
read -p "Your project : "  project
setup_laravel $project
setup_editor $project







