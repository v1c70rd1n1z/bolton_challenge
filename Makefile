setup:
	docker-compose pull
	docker-compose build
	cp pre-commit-hook .git/hooks/pre-commit
	chmod +x .git/hooks/pre-commit
	cp .env.example .env
	docker-compose up -d
