Security concerns

In order to secure a web application / website, we need a solid implementation of user logins with the potential of session storage alongside that.  A Session is a method of attaching data to a particular visitor of a website for a period of time.

From my own knowledge, I am aware of JWT (Json Web Tokens) as a form of authentication and authorisation - the token is "signed" by the server and given to the client, the client then submits the token with future requests.  As the token is signed by the server, the client cannot alter the contents, so the contents can be trusted.  This makes JWTs potentially stateless - they store all the required information in them in a tamper-proof way - the server then only needs to know how to sign the token to verify its validity.  The benefit to performance is clear here as the server doesn't need to store anything in itself to access on each page load.

There are numerous downsides to using a JWT though, mainly the potential size of a token (as the token itself contains a header, body, and the signature it can grow quite large if not monitored) and the complexity of revoking or re-issuing tokens (Jolicode, 2019).
The size issue is easily mitigated by a proper strategy - I had thought of only storing basic authorisation levels in the Bug Tracker app (e.g. "basic user", "admin", "super admin") rather than having separate access requirements on the feature level.
The complexity problem is more of a road block as I would like re-issuing tokens to be seamless for the user (having to log back in on a time interval would be frustrating).  There is no way around this that also makes use of the stateless nature of the JWT.

An alternative to a JWT is a state-full token where an authentication token is issued to a client and stored on the server.  Then on each page load the token given by the client is checked against the token stored on the server.  If the tokens match, we know we have an authenticated user.  The downside to this approach is that all authorisation needs to be done by accessing data on the server, if a user has permissions mentioned above, they'll be stored against a user and will need to be fetched on each page load.

There are also security concerns around the software used to deploy the application that I am not totally in charge of - the Docker service itself, the images it creates, the other software that runs in those images (e.g. the Linux distribution Ubuntu).  I shall leave this out of scope of the project for now as I don't have time to adequately learn about and address these issues.


Privacy concerns

We have to consider privacy alongside security as there are lots of rules now governing storage and use of user-identifiable data.  This includes storing data on a user's computer without prior consent, holding personal data on a server for longer than necessary, and only holding enough information for a specific purpose (and no more).
As this project is going to be stored locally on a user's device with no remote data processing or access so most privacy concerns are don't qualify, it'll still be important to encrypt some user data in case the device is compromised.  I'll do this by keeping specific user data requests to a minimum and keep passwords encrypted.  Again, as this software is to be delivered to a user's computer in whole, there's no need to request extra information above a name and password.


https://jolicode.com/blog/why-you-dont-need-jwt - 07/06/2019










Session

First visit to the page generates a session.
If session hasn't been validated (set key on session to know it's in use), validate it (set key on session)
Store last accessed time and use that to timeout sessions after arbitrary time (1 hour)
If session has timed out, revoke session and redirect to login page (if on a secured page)
Store logged-in status in session along with basic user data
