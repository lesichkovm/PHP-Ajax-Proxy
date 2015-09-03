PHP Ajax Proxy
================================================================

Description
----------------------------------------------------------------
Up to the point, straight forward, standalone PHP script to enable
cross-domain Ajax requests:

- Drag and drop single file with no external dependencies
- Supports POST and GET requests
- Does not need CURL enabled on server

When to Use
---------------------------------------------------------------
There are many times, when JSONP is not an option especially with
third party APIs.

Functionality
---------------------------------------------------------------
Fully functional, working and tested in production 24/7

How to Install
---------------------------------------------------------------
1) Drag and drop the script to a location on your server
2) The location must be public facing

How to Use
---------------------------------------------------------------
POST or GET your requests at the script. Use the parameter "url_to_fetch"
to specify the location of the remote API

Example
---------------------------------------------------------------
1) Fetching JSON from http://jsonip.com/

proxy.php?url_to_fetch=http%3A%2F%2Fjsonip.com%2F
