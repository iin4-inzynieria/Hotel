#!/usr/bin/env bash

# $1 - user
# $2 - password
# $3 - database
# $4 - path (optional)

now="backup_`date | tr ",. :-" "_"`"

if [ "$#" -eq 4 ]
then
  filename=${4%/}"/db_backup_$now".gz
else
  filename="db_backup_$now".gz
fi

mysqldump --user=$1 --password=$2 --default-character-set=utf8 $3 | gzip > "$filename"
exit 0
