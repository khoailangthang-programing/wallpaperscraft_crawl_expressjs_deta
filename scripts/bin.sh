#!/bin/bash
cd /home/bss/Documents/Developer/deta/nhat_wallpaperscraft_micro/data
mv categories.json categories.json_bak
mv home.json home.json_bak
mv list_categories.json list_categories.json_bak
cd /home/bss/Documents/Developer/deta/scripts/
php index.php