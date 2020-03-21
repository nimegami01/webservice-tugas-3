# Dokumentasi API

Example
http://webservice.postku.org/tugas3/

## Get Data
GET http://webservice.postku.org/tugas3/rest/

## Edit/Update Data
POST http://webservice.postku.org/tugas3/rest/edit
### value
id: int
keyword: string
volume: int
cpc: int

## Add/Insert Data
POST POST http://webservice.postku.org/tugas3/rest/insert
### value
keyword: string
volume: int
cpc: int

## Delete Data
POST POST http://webservice.postku.org/tugas3/rest/delete
### value
id: int
