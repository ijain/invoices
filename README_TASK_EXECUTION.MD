##### Bug fixed for mariadb image
- mariadb is not booting issue
- Reference URL: https://github.com/laradock/laradock/blob/master/mariadb/Dockerfile
- CMD ["mysqld"] changed to CMD ["mariadbd"]

