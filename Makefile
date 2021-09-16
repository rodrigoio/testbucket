.PHONY: run stop test

run:
	@docker-compose up -d

stop:
	@docker-compose down

test: run
	@docker exec testbucket vendor/bin/phpunit

phpmetrics: run
	 @docker exec testbucket vendor/bin/phpmetrics --report-html=tmp/coverage/phpmetrics src/
