up:
	docker-compose up -d
build:
	docker-compose build
test:
	docker-compose exec job-driver-php php artisan test