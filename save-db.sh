#!/bin/sh
now=`date +"%H_%M_%S_%m_%d_%Y"`
echo "Exporting database $now..."
docker-compose exec db /usr/bin/mysqldump -u root --password=root pai > dbdumps/backup_$now.sql
