### To enter environment for running endpoints and tests:

```cd docker```

```docker compose exec workspace bash```

### Commands to run end-points:
```php artisan invoice:show```

```php artisan invoice:approve```

```php artisan invoice:reject```

### Command to run PhpUnit tests:
```phpunit```


==========================================================


##### What was done in addition to this task:

##### 1. Bug fixed for mariadb image
- mariadb is not booting issue
- Error message:  SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for mariadb failed: Name or service not known (SQL: SHOW FULL TABLES WHERE table_type = 'BASE TABLE')
- Reference URL: https://github.com/laradock/laradock/blob/master/mariadb/Dockerfile
- CMD `["mysqld"]` changed to CMD `["mariadbd"]`

##### 2. Changed PHP version
- `readonly` classes are allowed only since PHP 8.2, changed 8.0.1 to 8.2

##### 3. Added Database seeders to default DatabaseSeeder.php

##### 4. Added status update to approval service

##### Suggestion
- it would be good to add unique key(product_id, invoice_id) to `invoice_product_lines` table in order to avoid duplicates.

