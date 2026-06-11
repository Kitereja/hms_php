HOTEL DE MAG - BEGINNER PHP + MYSQLI VERSION

1. Copy this folder to your XAMPP htdocs folder.
   Example: C:\xampp\htdocs\hms_php

2. Start Apache and MySQL from XAMPP.

3. Open phpMyAdmin.

4. Import schema.sql.
   This creates database: hotel_de_mag
   Tables created:
   - users
   - bookings
   - payments
   - contact_messages

5. Open the project in browser:
   http://localhost/hms_php/index.php

MAIN PHP FILES
- index.php
- about.php
- room.php
- standard-room.php
- deluxe-room.php
- executive-suite.php
- services.php
- contact.php
- login.php
- payment.php
- payment_success.php

PROCESS FILES
- db_connect.php
- signup_process.php
- login_process.php
- contact_process.php
- booking_process.php
- payment_process.php

HOW IT WORKS
- User creates account from login.php signup tab.
- signup_process.php saves user into users table.
- User logs in from login.php.
- login_process.php checks email and password.
- User books a room from standard/deluxe/executive room page.
- booking_process.php saves booking into bookings table.
- User goes to payment.php.
- payment_process.php saves fake/mock payment into payments table.
- Booking status changes from pending to confirmed.

NOTE
This is mock payment only for educational purpose. No real money is used.

ADMIN DASHBOARD
1. Import schema.sql again, or run the new rooms table SQL manually.
2. Login with:
   Email: admin@gmail.com
   Password: admin123
3. Open: admin.php

Admin files added:
- admin.php
- admin_process.php
- logout.php

Admin features:
- Manage Rooms
- Manage Bookings
- Manage Customers
- View Reports / Payments
