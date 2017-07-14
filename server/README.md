nearbuy_api
===========


## How tokens works :

### Getting token

You must pass 5 headers to your request :

- grant_type = password
- client_id = *oauth2_client.id*_*oauth2_client.random_id*
- client_secret = *oauth2_client.secret_id*
- username
- password

Example :
```shell
$ http POST http://localhost:8000/app_dev.php/oauth/v2/token \
    grant_type=password \
    client_id=1_X8W5ePRb98ThJyXZXwH7bH7Lk4xtpYj5Q3ARX6qKzQKXXwGrpe \
    client_secret=dKtuFQTXCmd99B6BgvJc3CD74oKLmdJNQz29zthrPz2JXyrYt2 \
    username=admin \
    password=admin
HTTP/1.1 200 OK
Cache-Control: no-store, private
Connection: close
Content-Type: application/json
...

{
    "access_token": "MDFjZGI1MTg4MTk3YmEwOWJmMzA4NmRiMTgxNTM0ZDc1MGI3NDgzYjIwNmI3NGQ0NGE0YTQ5YTVhNmNlNDZhZQ",
    "expires_in": 3600,
    "refresh_token": "ZjYyOWY5Yzg3MTg0MDU4NWJhYzIwZWI4MDQzZTg4NWJjYzEyNzAwODUwYmQ4NjlhMDE3OGY4ZDk4N2U5OGU2Ng",
    "scope": null,
    "token_type": "bearer"
}
```

You should get an **access_token** and a **refresh_token**

### Token usage

You must pass the following header :

Authorization:Bearer *access_token*

Example :
```
$ http GET http://localhost:8000/app_dev.php/api/* \
    "Authorization:Bearer MDFjZGI1MTg4MTk3YmEwOWJmMzA4NmRiMTgxNTM0ZDc1MGI3NDgzYjIwNmI3NGQ0NGE0YTQ5YTVhNmNlNDZhZQ"
HTTP/1.1 200 OK
Cache-Control: no-cache
Connection: close
Content-Type: application/json
...

{
    "hello": "world"
}
```