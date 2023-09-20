run:
	cp .env.example .env
	docker compose up -d --build --force-recreate
	docker exec -t barena_php -c "php artisan key:generate"
