#!/bin/bash

#
##
## Generate autoload classmap without ZF2 library.
## He was already load in init_autoloader.php file.
##
#

## list of directory
classmap=( 'site' 'libs/Knb' 'libs/Vbf' 'libs/Utils' )

for map in "${classmap[@]}"; do
    php ./bin/classmap_generator.php -w -l $map
done