# Todo list for the back end

* Instantiate database in Core and attach to Container
* Move Token storage to Redis, add Expiry times to Tokens
* Move Token to a Request Header (token) - Add to allowed headers for CSRF
* Create Validators so a Controller can pass the Params to the Validator which can throw an exception with descriptive
  message based on the missing/invalid parameters
