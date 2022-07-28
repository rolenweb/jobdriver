up:
	docker-compose up -d
down:
	docker-compose down --remove-orphans
build:
	docker-compose build
test:
	docker-compose exec job-driver-php php artisan test
