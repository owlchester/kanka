#!/usr/bin/env bash

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS logs;
    GRANT ALL PRIVILEGES ON \`logs%\`.* TO '$MYSQL_USER'@'%';
EOSQL
