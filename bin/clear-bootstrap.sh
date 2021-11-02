#!/usr/bin/env bash

CWD="$(dirname "$(realpath "$0")")"

# Clear the boostrap cache files before installing/updating.
rm -rf $CWD/../bootstrap/cache/*

# Ensure the directory exists.
[ ! -d $CWD/../bootstrap/cache ] && mkdir $CWD/../bootstrap/cache
[ ! -f $CWD/../bootstrap/cache/.gitkeep ] && touch $CWD/../bootstrap/cache/.gitkeep

exit 0
