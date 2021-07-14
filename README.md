# Link Shortener
A mini project for creation short link

1. Clone the repo
   ```sh
   git clone https://github.com/hamidroohani/Link-Shortener.git
   ```
   
2. Go to the directory and install composer
   ```sh
   composer install
   ```
   
3. Create a database in mysql and open config.php file in `app/Http/Config.php` and put your database connection information

4. Add more information in config such your domain name 

4. Find `database.sql` in root path and import to mysql

5. Create your first short link <br>
send a POST request to this link
[/link/create/](https://your.domain/link/create/)
* link parameter is required


### Postman File
Also you can find the postman file in root path with this name: `collection.postman.json`
