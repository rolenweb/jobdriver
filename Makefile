up:
	docker-compose up -d
down:
	docker-compose down --remove-orphans
build:
	docker-compose build
test:
	docker-compose exec job-driver-php php artisan test
migrate:
	docker-compose exec job-driver-php php artisan migrate
migrate-test:
	docker-compose exec job-driver-php php artisan migrate --env=testing
pint:
	docker-compose exec job-driver-php ./vendor/bin/pint -v

