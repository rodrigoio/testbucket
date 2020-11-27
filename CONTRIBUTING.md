Contributing
------------

Test Bucket is an open source, community-driven project.

If you'd like to contribute, please read the following guide:

Reviews
-------
Before making a pull request, make sure you are aligned with the project's objectives and that your contribution follows
the guidelines.

Bug Report
----------
To report a problem, open a new issue, informing all the necessary data (and steps) to reproduce the bug.
And describe as directly as possible.

Running Tests
-------------
To perform unit tests, use phpunit which must be installed via composer with other project dependencies.
For greater practicality, the project has two docker containers. They are necessary to run the tests with php,
and another to view the coverage test report.

All you have to do is to run `docker-compose up -d` then the containers will be available.

See: [docker][0] and [docker-compose][1]

Coding Standards
----------------
It is highly recommended to use standards such as SOLID, clean code and PSR's.
In the future we will have some automated tools to check code style.

See: [SOLID][2], [PSR][3]

[0]: https://www.docker.com/
[1]: https://docs.docker.com/compose/
[2]: https://en.wikipedia.org/wiki/SOLID
[3]: https://www.php-fig.org/
