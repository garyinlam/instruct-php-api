# Instruct PHP API

REST API build in PHP

## To run

1. Clone repository
2. Run following command in directory
```
docker-compose up --build
```
3. Connect to MySQL database
```
Hostname: 127.0.0.1
Port: 4306
Username: root
Password: password1
```

4. Create tables using SQL in services.sql file
5. Create or import sample data

### To view records
For all records:
GET request to 
```
localhost:8000/services
```

For specific country code:
GET request to
```
localhost:8000/services?country={countryCode}
```

### To create or update records
POST request to with JSON object in request body
```
localhost:8000/services
```
If record with reference exists, the record will be updated
Otherwise, a new record wil be created
Example JSON object:
```
{
  "ref": {reference},
  "centre": {center},
  "service": {service},
  "country": {countryCode}
}
```