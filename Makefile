.PHONY: build test run stop
APPNAME = testbucket

build:
	@docker build -t ${APPNAME} -f Dockerfile .

test:
	@docker run -it --rm --name ${APPNAME}-test ${APPNAME} vendor/bin/phpunit

run:
	@docker-compose up -d

stop:
	@docker-compose down
