
CHAT SAMPLE WEB APPLICATION v1b
===============================

by José Luis Cebrián Márquez (www.jlcm.es / cebrianmarquez@gmail.com)

This project uses JQuery Mobile and Phreeze PHP Framework.

Check the online demo here:
http://www.jlcm.es/michat
http://www.jlcm.es/michat/mobile

HOW TO DEPLOY
=============

Import sql located on the "database" folder (most recent sql).
Change the connection details with your data connection (user and pass) on _machine_config.php
(Default values: root - root).

Optional: Configure and update dependencies with composer.
Install composer and user: composer update (in michat folder)

HOW TO ACCESS TO THE BACKEND ADMINISTRATION
===========================================

Username = admin
Password = 123

HOW TO ACCESS TO THE MOBILE CLIENT
==================================

Usernames = admin OR user1 OR user2 OR user3 OR user4
Password = 123

NOTE: If an admin create a message from BACKEND or delete the friendship between two users, the old messages will be still existing but the user must be "(Unknown user)".

HOW TO TEST THE APPLICATION
===========================

- Frontend app: Login as a user on the /mobile section. Send messages to another users.
- Backend app: Login as admin on the main page. Edit, create and manage users, messages and friendships.
	- Create a new user.
	- Create friendship relations between the new users and the existing ones.
	- Enter as the new user to check if everything works correctly.

SUGGESTED IMPROVEMENTS
======================

Use Ratchet (WebSockets) instead of Polling (AJAX) to refresh messages and users, improve the server performance and reduce the traffic (Not supported on all the browsers!). 
Use the database columns suggested to improve the performance, sending only the not already read messages, checking if a user it's online or not, etc.
The friendship relations must be programmed as mutual or not. Now all the relations are mutuals.
Hide "admin" user from the users list when the admin login in the frontend app.

SECURITY IMPROVEMENTS
=====================

Use a public key value of the user table to cypher the messages before sending them. Send the public key to the other client on the handshake (onOpen connection method).
Use a SSL layer connection to avoid info leaking with Man in the Middle attacks.
Store user passwords and admin password cyphered or store only the generated SHA-2 (current: MD5).

USER PERMISSIONS
================

From the homepage, the admin can access to all the sections, create, edit and delete entities.
I put all the sections on the header to test the access permisions propertly.
