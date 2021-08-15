up:
	@docker-compose up -d

down:
	@docker-compose down

test: up
	@docker exec testbucket vendor/bin/phpunit
