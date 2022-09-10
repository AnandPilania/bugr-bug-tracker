# Bug Trackr front end app

This is the front end for Bug Trackr, written in React using Material Components


## Todo

* Create Notification component with hook to add notifications that disappear automatically
* Stop form submissions for required fields (Login: `username` and `password`)
* Store token from login in cookie
* When loading App, check for token in cookie, if found make API request to populate User object
* Create Protected routes that automatically forward to login page if User object not populated