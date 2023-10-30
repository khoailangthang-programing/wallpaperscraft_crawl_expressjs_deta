# Wallpaperscraft Crawler using Expressjs and Deta platform.
Demo project that crawl images link from wallpapers scraft. Using deta platform.
## Prerequisite
1. Nodejs + Expressjs
2. PHP
3. Composer
## How to use?
1. Clone repository.
2. In the **nhat_wallpaperscraft_micro** folder, run command **npm install**
3. In the **scripts** folder, run command **composer install**.
4. In the **scripts** folder, run command **php index.php**. The command will do crawl images link from wallpaperscraft base on analysis HTML structure and generated two files: **categories.json** and **list_categories.json**
5. Move both generated files to **nhat_wallpaperscraft_micro/data**
6. In the **nhat_wallpaperscraft_micro** folder, run command **npm start** to see the result.
#### NOTE:
- script crawls 10 pages per category only.
- this is demo project, so it is not completely and it is not a release version.
- this project build on deta platform, that was changed to Space platform.
