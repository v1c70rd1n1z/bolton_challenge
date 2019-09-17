setup:
	docker-compose pull
	docker-compose build
	cp pre-commit-hook .git/hooks/pre-commit
	chmod +x .git/hooks/pre-commit
	cp .env.example .env
	make seed
	docker-compose up -d

seed:
	docker-compose up -d database
	docker-compose up -d app
	docker-compose run --rm app composer install
	docker-compose run --rm app chmod -R 777 storage .env
	docker-compose run --rm app php artisan migrate --seed
