ReadMe:

HW2 is from Suzie Zhang.

All the files under the Link:   http://cs-server.usc.edu:8111/HW2
Login Page:   http://cs-server.usc.edu:8111/HW2/login.php

1. Sometimes when you delete or modify something successfully, the system will automatically skip to the last page.
2. Please do not do the Reload in any pages after submit.(There is nothing can be do to web-based system to solve the reload problem.)

------------------------Assumptions and Notes:----------------------
1. This system doesn't allow one employee has multiple user accounts.
2. Administrator cannot modify userid. Userid is given by the database automatically (increment auto).
3. Username must be unique.
4. One product cannot be in several productcategories.
5. One employee cannot have several usernames.

-----------------------------Account:-------------------------------
1. Administrator: username:admin     paswword:admin
2. Manager:       username: manager  password: manager
3. Sales Manager: username:saler     password:saler


-----------------------------Database:------------------------------
I created 4 tables: users, product, productcategory, specialsale.

1. users: userIndex, username, password, usertype, firstname, lastname, age, payment
2. product: productID, productname, productcategoryid, description, price
3. productcategory: productcategoryid, productcategoryname, productcategorydes
4. specialsale: specialID, productID, discount, startday, startmon, startyear, endday, endmon, endyear

In the user table:
userIndex     username     password     usertype     firstname     lastname     age     payment
1             admin         ######         0	       Will	        Zhang	    41	     5000 
2       	  saler			###### 		   2           Martin	    Chen	    30	     2000
3 			  Manager       ######         1           shuzi        Zhang       22       1000


-------------------------------Files:-------------------------------
Relationship of Main files.

login.php: admin.php,  saler.php,  manager.php
admin.php: adminAdduser.php,  adminDeleteuser.php,  adminModifyuser.php(Modifyuser.php)
saler.php: product.php,  productCategory.php, specialsale.php
manager.php: usertable.php, producttable.php, specialsaletable.php


---------------------------Validation:------------------------------
1. username: All numbers and charachers can be include into username. Cannot be empty.
2. password: All numbers and charachers can be include into username. Cannot be empty.
3. firstname & lastname: Cannot be numbers. Cannot be empty.
4. Date: day between 1 and 31, month between 1 and 12, year between 1 and 32767.


---------------------------Reference:-------------------------------
1. Most part of login.php comes from professor and his notes.
2. Some of the AJAX part comes from professor's notes.
3. https://github.com/emaijala/MLInvoice
4. CSS:  https://accounts.google.com/ServiceLogin?service=mail&continue=https://mail.google.com/mail/
		 https://developers.google.com/glass/design/style#main_layout
		 http://codepen.io/lukepeters/pen/bfFur



