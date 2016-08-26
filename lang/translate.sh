#!/bin/sh

function usage () {
    cat <<EOT

Prepare translation file template based on english language file.

Usage: $0 <two char language code>

EOT
    exit ${1:-0}
}

### Language code given?
[ -z "$1" ] && usage 1

### Language code 2 characters?
[ ${#1} -ne 2 ] && usage 2

pwd=$(dirname $0)

cp "$pwd/en.php" "$pwd/$1.php"

printf "\nCopied $pwd/en.php to $pwd/$1.php\n"
