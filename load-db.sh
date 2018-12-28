#!/bin/sh

filename=$1

echo "Importing database from file $filename..."
docker-compose exec db mysql -u root -p pai < $filename
