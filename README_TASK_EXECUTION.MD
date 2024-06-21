##### Bug fixed for mariadb image
- mariadb is not booting issue
- Error message:  SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for mariadb failed: Name or service not known (SQL: SHOW FULL TABLES WHERE table_type = 'BASE TABLE')
- Reference URL: https://github.com/laradock/laradock/blob/master/mariadb/Dockerfile
- CMD ["mysqld"] changed to CMD ["mariadbd"]

##### Changed PHP version
- 'readonly' classes are allowed only since PHP 8.2
- for this reason I have changed 8.0.1 to 8.2

##### Added Database seeders to default DatabaseSeeder.php

