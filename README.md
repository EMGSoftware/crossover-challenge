Author: Emiliano M. Gonzalez - emiliano.m.gonzalez@gmail.com

Database script
===============
As the tables are created using Laravel Migrations, the only task that need to be manually executed on the MySQL server is the creation of the database itself. I think that such trivial task ("CREATE DATABASE `backend`") is not worth of the usually time-consuming process of uploading and executing a script.

Deployment Steps
================
Assuming there is available a LAMP (Linux, Apache, MySQL, PHP) environment correctly configured and running:
• Create a new directory for the project into the default document root for Apache (Usually "/var/www/html")
• Copy the entire content of the directory "Source" of the "Software Engineer -PHP.zip" file to the new project directory.
• Enable writing permissions in the [project directory]/storage directory: 
  chmod -R o+w [project directory]/storage
• Create a new database in MySQL and take note of the name (you will need it in the next step).
• Open the "[project directory]/.env" file with your preferred editor, and configure your GMail account credentials so that PHPMailer can send e-mails (Keys "MAIL_USERNAME" and "MAIL_PASSWORD"). Specify the MySQL username, password and DB name (Created in the previous step), modifying the keys "DB_USERNAME", "DB_PASSWORD" and "DB_DATABASE". Save the file after finished the modifications.
• Make sure Composer is installed. If not, install via "sudo apt-get update" (Valid for Ubuntu)
• Execute "composer install" in order to install all the needed dependencies
• Execute "php artisan cache:clear" and "php artisan route:cache" to avoid any conflict with the cached values.
• Enable writing permissions in the "[project directory]/pdfs" directory: 
  chmod -R o+w [project directory]/pdfs
• Execute "php artisan migrate:refresh --seed" in order to create and populate with sample data all the tables needed.
• If the deployment process went OK, you can access the system as:
  https://[server ip or hostname]/[project directory]/public
  Ex.: https://themechanic.solutions/lab/public/
• You can access and begin to use the system with: Admin @ 123456 (User & Pass code)

Note: Laravel's deployments can be tricky at times. If you encounter any problems during the deployment process, please contact me at emiliano.m.gonzalez@gmail.com and I will return as soon as possible. I deployed several projects, debugged and solved many problems, using both MySQL and PostgreSQL in both Linux and WindowsServer platforms. As such I'm sure I can help you to resolve any incident that may appear.

Assumptions and considerations
==============================
As there is little specification available about the nature of the tests being recorded in the system, I assumed that any kind of value (alphanumerical and symbols) can be used in the Result field. Given a greater amount of time to develop, it is possible to implement a better test definition management approach, allowing the specification of Units, Kind of Value (Numeric, True/False, etc.) and enforcing relevant validations.

In most of my projects I use Roles (Administrators, Normal Users, Patients, etc.) to segment user's different functionalities, but I chose to keep this assignment as simple as I could, to focus on the core functionalities that this challenge might require. There is just only one special case with user Admin, that can’t be removed from the Operators page in order to avoid losing access to the system. Operators can manage other operators and patients, and have access to all the functionalities. Patients just can see, download and send by e-mail his own reports.

I personally prefer the use of e-mail/password pairs to authenticate users, but I followed the functional specification that says: "Patient user could log in using his name (auto complete field) and pass code sent to him". It can be considered a breach of security the possibility of anyone to have free access to the full list of patients (In a combobox as in my project, or testing combinations of letters through an autocomplete field, as suggested). Let's imagine I'm a hacker and I want to know who are the users available. Through an auto-complete field I can enter the letter "A" and the system will show me all the users whose name begins with "A". It's a matter of doing a quick search though the chosen victim social network profiles to make a list of important dates and names of relatives to infer some passwords.
