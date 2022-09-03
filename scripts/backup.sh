#!/bin/bash
set -e

# sis-te.com
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=sisteco
# DB_USERNAME=forge
# DB_PASSWORD="y0Uud94MSsOolkTusvFb"

echo "BACKUP started ..."

# WMPM
echo "Create gz backup"
echo

echo "1. removing old sym link to last version"
rm -f ~/backup/sis-te.com/dump.sql.gz

echo "2. Creating new SQL DUMP"
PGPASSWORD="y0Uud94MSsOolkTusvFb" pg_dump -F c -O -x -U forge -h localhost -a sisteco -f ~/backup/sis-te.com/$(date +%Y-%m-%d).sql
echo "3. Compressing with gzip"
gzip  ~/backup/sis-te.com/$(date +%Y-%m-%d).sql --force


echo "4. Clearing old backups. takes only the last 10"
cd ~/backup/sis-te.com
rm `ls -t | awk 'NR>10'` -f

echo "5. Creating sym link to last version"
ln -s ~/backup/sis-te.com/$(date +%Y-%m-%d).sql.gz ~/backup/sis-te.com/dump.sql.gz

echo "All done backup created."
cd ~/backup
