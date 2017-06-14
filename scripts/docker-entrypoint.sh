#!/bin/sh

set -e

if [ "$1" = 'launch' ]; then
  # Check if database exists
  # If database doesn't exist create
  # if database exists check if tables exist
  # If no tables then run migration/import sql file

  echo -e "==> Your app is ready\n ==> From here on should only be log messages!"
  /bin/sh
fi
