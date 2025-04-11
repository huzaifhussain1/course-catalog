#!/bin/bash
# Wait for MySQL to fully start
sleep 10

# Connect to MySQL as root and run the command
mysql -u root -p${MYSQL_ROOT_PASSWORD} -e "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));"

# For .htaccess
a2enmod rewrite
