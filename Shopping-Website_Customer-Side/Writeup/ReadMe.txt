ReadMe:

HW4 is from zishu Zhang.

Home Page:  http://cs-server.usc.edu:8111/HW4/CodeIgniter/index.php

-----------------------------Environment:--------------------------
php version: 5.1.5
apache version: 1.3.42
phpmyadmin version: 2.11

------------------------Assumptions and Notes:----------------------
1. Please do not do the Reload in any pages after submit.(There is nothing can be do 
to web-based system to solve the reload problem.)
2. This web is not supported in Internet Explorer 9 and earlier versions, or Safari. 
3. Some of the code using HTML5.
4. Navigation part (in the top of the website), Keyword only searches productname.
5. Timeout only begin after you login.
6. After customer buy products, they cannot change their order.

-----------------------------Account:-------------------------------
To check HW4, you can use:
username:tom  password:tom

----------------------------Database:------------------------------
In HW4, the database is same as HW3. Details can be found in ReadMe_database.pdf.

-------------------------------Files:-------------------------------
1. Controllers: account.php
2. Models: my_model.php
3. Views: account_view.php, head_view.php, end_view.php, cinlogin_view.php, checkout_view.php,
displayCart_view.php, displayOrder_view.php, getspecialsale_view.php, product_view.php, 
searchProduct_view.php, addProfile.php. updateProfile.php, myorder_view.php, account_view.php
4. CSS in assets file

------------------------Responsive Web Design:----------------------
Please make the broswer window small to test Responsive Web Design.

HW4 require to use Responsive Web Design for your user interface. And to make this easier, 
we are allowed to use JQuery Mobile Tables. 

I use jquery mobile and its librart in some of 
my view files. And Some part of views I use mature css for reference.

--------------------------Validation:-------------------------------
1. username: All numbers and charachers can be include into username. Cannot be empty.
2. password: All numbers and charachers can be include into username. Cannot be empty.
3. firstname & lastname: Cannot be numbers. Cannot be empty.
4. Date: day between 1 and 31, month between 1 and 12.
5. Use trim — Strip whitespace (or other characters) from the beginning and end of a string.

----------------------------Security:-------------------------------
1. XSS: set $config['global_xss_filtering'] = TRUE; in application/config/config.php file.
		set xss_clean in form_validation.
2. SQL injection: (Only for user input values.) Use Query Bindings.
3. Do htmlspecialchars 
4. Use form_validation to avoid invalid characters.

---------------------------Reference:--------------------------------
1. Most part of login.php comes from professor Michael Crowley and his notes.
2. Some of the AJAX part comes from professor Michael Crowley's notes and w3school.com.
3. JQuery Mobile: w3school.com and some parts of codes comes from demon on jquerymobile.com
4. CSS:  http://w3layouts.com/   Author(s): Lukas Jakob Hafner and Thomas Hurd 
		 https://developers.google.com/glass/design/style#main_layout
		 http://codepen.io/lukepeters/pen/bfFur
		 
5. Product(cars) information: http://www.cars.com

