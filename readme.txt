
To start this project you need to:

1.Download the project from github.com:
1.1. Select a directory, open a terminal and run the "git init" command;
1.2. Выполните команду "git clone https://github.com/19Michael91/News_Project.git";

2. Set up composer:
2.1. Follow the link "https://getcomposer.org/download/" and install composer according to the instructions;
2.2. Select the directory with the project, open the terminal and execute the "composer install" command;
2.3. Run the command "composer dump: autoload" in the terminal;
2.4. Run the command "composer composer key: generate" in the terminal;

3. Configure database connection and population:
3.1. Create a MySQL database;
3.2. Copy the .env.example file and rename the copy to .env;
3.3. Define database connection variables:

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

3.4. Run the "php artisan migrate" command in the terminal;
3.5. Run the command "php artisan db: seed" in the terminal (after executing this command, 30 articles are created,
     5 categories and user with the role of "Admin" whose email is "admin@admin.com" and password is "admin");

4. Define the smtp host variables:

!!! WARNING !!! - do not use mailtrap.io because it limits the number of letters per second;

MAIL_DRIVER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

Project Description:

The application has two types of users: Admin and User.
Admin and User have the ability to view all the news sorted by the number of views with pagination,
search by text and title, browse news by category, add articles to Favorites, subscribe / unsubscribe.
The administrator has the ability to access the admin panel at the URL / admin address, where he can view
create and delete news. When the administrator creates news, the application sends an email to the email address
subscribed Users which contains a link to the new news.
When viewing a single page at URL / single / {news_id}, the value of the number of page views increases.

