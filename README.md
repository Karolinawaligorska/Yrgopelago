WHY NOT A GIF HERE? TO SET THE MOOD.

# Island name

Some text about your lovely island

# Hotel name

Why not add some info about the hotel of your dreams?

# Instructions

If your project requires some installation or similar, please inform your user 'bout it. For instance, if you want a more decent indentation of your .php files, you could edit [.editorconfig]('/.editorconfig').

# Code review

1. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
2. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
3. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
4. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
5. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
6. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
7. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
8. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
9. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
10. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.

Create for database: 
CREATE TABLE rooms (
id INTEGER PRIMARY KEY,
room_type varchar(80),
cost INTEGER
);

CREATE TABLE guests (
id INTEGER PRIMARY KEY,
name varchar(80),
room_id INTEGER,
FOREIGN KEY (room_id) REFERENCES rooms (id)
);

CREATE TABLE occupancy (
id INTEGER PRIMARY KEY,
room_id INTEGER,
check_in_date DATE,
check_out_date DATE,
is_occupied BOOLEAN,
FOREIGN KEY (room_id) REFERENCES rooms (id)
);
