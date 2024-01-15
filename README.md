WHY NOT A GIF HERE? TO SET THE MOOD.

# Island name

Some text about your lovely island

# Hotel name

Why not add some info about the hotel of your dreams?

# Instructions

If your project requires some installation or similar, please inform your user 'bout it. For instance, if you want a more decent indentation of your .php files, you could edit [.editorconfig]('/.editorconfig').


# Code review

1. index.php - in the index.php file, I didn't observe any PHP code; it might function just as an HTML file.
2. index.php:60 - there's an unclosed <?php tag without an apparent purpose
3. index.php:18 - consider converting the buttons in the form at line 18 in index.php into links, leading visitors to the calendar page, as there are no form-related actions present (no input, etc.).
4. index.php - it might increase the flexibility to retrieve names or room prices from the database in index.php rather than hardcoding them
5. bookings.php: 85 - it seems like the function executes a separate database query for each day across three rooms in the calendar, maybe it's possible to use a bit more efficient solution?
6. bookings.php:103-116 - if room information were stored in the database,you could fetch them here and do a loop to echo the content and only use one div instead
7. avaiability.php:33-37 - consider adding comments to clarify the purpose of the SQL query and the associated condition
8. avaiability.php:50 - that's funny! :D
9. booking.css, index.css - good practise to put css in separate files
10. Overall - nice well-structured code and good work! Nice solution to check if the booking is avaiable at line 33 in avaiability.php!

