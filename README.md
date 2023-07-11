# MEDIVAULT
 ## Intial steps to follow:
 - To run this program, we should have xampp installed in our system.
 - *Create a folder (with any name, in our case it is Devhack) in C\Xampp\htdocs .
 - *Create a folder inside Devhack named as store("It should be named as store only") which stores the uploaded files.
 - Now open xampp application and start the modules Apache, MySQL.
 
 ## To load the database and code running:
 - Create sample database(named as healthcare) in your system by running the url- http:/localhost/Devhack/init.php
 - If there exists a database already delete it by running the url- http:/localhost/Devhack/outit.php
 - Run the url http:/localhost/Devhack/homepage.php  
 
 ## Files info
 - In homepage.php we will get the contact information(by directing to contactus.php), website information(by directing to about.php) and a sign in button to direct to the login page.
 - In login.php users get logged into the account and in login_admin.php organization get logged into the account.
 - In register.php the users can register account and in register_admin.php a organization can register account.
 - After getting logged in, it will direct to main page where we can visit my records and sign out.
 - In display_pdf.php organization can upload the pdf and users can view them.
 - In signout.php we will get logged out.
