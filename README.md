PHP Ajax Proxy
================================================================

Description
----------------------------------------------------------------
Up to the point, straight forward, standalone PHP script to enable
cross-domain Ajax requests:

- Drag and drop single file with no external dependencies
- Supports POST and GET requests
- Does not need CURL enabled on server
- Works with HTTPS and HTTP URLs

When to Use
---------------------------------------------------------------
There are many times, when JSONP is not an option especially with
third party APIs.

Functionality
---------------------------------------------------------------
Fully functional, working and tested in production 24/7

How to Install
---------------------------------------------------------------
Drag and drop the script to a location on your server

How to Use
---------------------------------------------------------------
POST or GET your request at the script. The parameter "url_to_fetch"
is reserved to specify the location of the remote API. All other
parameters will be sent to the location set in the "url_to_fetch"
parameters

Examples
---------------------------------------------------------------
1) Fetching JSON from JSONIP (URL: http://jsonip.com/)

```
proxy.php?url_to_fetch=http%3A%2F%2Fjsonip.com%2F
```

2) Fetching JSON from Quantum Random Numbers (URL: https://qrng.anu.edu.au/API/jsonI.php?length=1&type=uint8)

```
proxy.php?url_to_fetch=https%3A%2F%2Fqrng.anu.edu.au%2FAPI%2FjsonI.php&length=1&type=uint8
```
