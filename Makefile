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
	docker-compose up -d
	docker-compose run --rm composer install
	docker-compose run --rm php artisan migrate --seed
