## Entrance Exam for THK Holdings Vietnam in Hanoi

Welcome to THK Holdings Vietnam in Hanoi!!
Thank you for applying to us!

## About this exam

In this exam, you implement for these following fields using a Laravel application.
There are required and optional field to implement.

If you implement optional field, we consider your extra technical skills.

We will use Laravel Sail to build this exam environment.
Laravel Sail is a Laravel library that allows you to build an environment using virtualization container software called docker just by typing a command.
For more information about Laravel Sail, please refer to [the official Laravel documentation](https://readouble.com/laravel/11.x/en/sail.html).

### Application's information

[view](document/INFORMATION.md)

### Implementation fields

[view](document/IMPLEMENTATION_FIELD.md)

### Notice

- You write some comments as optional. But if you do, please write in Japanese or English.
- The design (CSS style) is up to you. Please use SCSS as possible.
- If there is unclear stated and specification, you implement the best for you.
- We will consider for the selection process from all of your implemented contents.
- Even if you couldn't complete all items, no problem. We will consider only your implemented scope. So please submit it by deadline.

### How to submit this exam

Please compress the `entry_test` folder into a zip file and submit it via email.
To reduce data size, please delete the `entry_exam/node_modules` folder and `entry_exam/vendor` folder along with all files under them before compressing.

### Any comments (optional)

If you have any comments about this exam, please write them down here.
```text
[Implementation Summary & Architectural Decisions]

1. Architecture & Code Quality:
   - Followed Clean MVC + Service Layer architecture (Controllers, FormRequests, Services, Models) ensuring clear separation of concerns, high maintainability, and testability.
   - Database mutations (create, update, delete) are wrapped within `DB::transaction`. In case of failures or exceptions, transactions are rolled back and any temporarily uploaded physical files are purged immediately.
   - Implemented SQL wildcard escaping (`addcslashes` for `%`, `_`, `\`) in partial match queries to prevent unintended LIKE wildcard injection.

2. Required Features Implementation:
   - Create Hotel: Input validations with clear Japanese error messages, prefecture selection, and image uploading.
   - Edit Hotel: Strict adherence to the 3-step page transition flow: Input Screen -> Confirmation Screen (with temporary image preview) -> Completion Screen. Safe image promotion from temporary to permanent storage upon final submission.
   - Delete Hotel: Interactive confirmation modal window via JavaScript; hotel record and its associated physical image files are deleted only upon selecting "OK".
   - Hotel Search Improvements:
     - Fixed empty search bug by displaying "何も入力されていません" in red text directly below the search form.
     - Upgraded hotel name search from exact match to partial match (LIKE search).
     - Added prefecture filtering via dropdown select box.

3. Optional Features Implementation:
   - Responsive Web Design:
     - Optimized layouts for mobile/tablet screens (<= 768px): fixed sidebar transforms into a top navigation bar, form tables collapse gracefully into single columns, and tables support horizontal scrolling (`overflow-x: auto`).
   - Booking Management Feature:
     - Created `bookings` migration matching the optional ER diagram (proper primary/foreign keys with CASCADE deletion, exact column specifications).
     - Added "予約情報検索" navigation link to the admin side menu.
     - Implemented booking search by customer name, customer contact, check-in datetime, and check-out datetime.
     - By default, initial page load lists all booking records with full pagination support and per-page size selector.
     - Displays all required columns in results: Customer Name, Customer Contact, Hotel Name, Check-in, Check-out, Created At, and Updated At.
     - Included `BookingSeeder` with realistic sample records.

4. Automated Testing:
   - Implemented comprehensive Feature Tests (`AdminHotelTest`, `AdminBookingTest`) with 32 test cases covering form validation, multi-step flows, image upload/purging, exception handling, backward compatibility, and query parameter preservation across pagination pages.

Thank you very much for reviewing this submission!
```
