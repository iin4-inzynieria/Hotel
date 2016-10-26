#!/usr/bin/env bash

# $1 - user
# $2 - database
# $3 - path to backup file

if [ "$#" -ne 3 ]
then
  echo 'Not enough parameters.'
fi

mysql -u $1 -p $2 < $3
exit 0
