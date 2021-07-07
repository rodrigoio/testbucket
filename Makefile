docker-up:
	@docker-compose up -d

docker-down:
	@docker-compose down

test: docker-up
	@docker exec testbucket vendor/bin/phpunit
