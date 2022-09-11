# Bug Trackr front end app

This is the front end for Bug Trackr, written in React using Material Components


## Todo

* Create Change Password, Forgotten Password, and Update Profile views
* Create "admin" user
  * Add link to Create User in Profile Menu if user is an admin
  * Add checkbox to Create User form for "is admin"
  * Update ProtectedRoute component to detect Admin User
  * Restrict `/register` route to admins only
  * Update `/validate` route to return Admin status