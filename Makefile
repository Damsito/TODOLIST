.PHONY: install fixtures
install:
	sudo docker-compose down --remove-orphans -v
	sudo docker-compose up -d
	composer install --no-interaction --optimize-autoloader
	symfony console d:m:m --no-interaction
	symfony serve -d
