
## BACKEND DEVELOPER CHALLENGE BRIEF

TEKNOLOGI : 
- php
- framework laravel
- MySql

#### CARA MENJALANKAN PROGRAM
- clone projek github
- composer install 
- php artisan key:generate
- create database dan sesuaikan .env database
- ubah .env variabel APP_URL=http://localhost:8000
- jalankan perintah di terminal "php artisan migrate"
- jalankan perintah di terminal "php artisan serve"

#### Dokumentasi Api

https://documenter.getpostman.com/view/21233147/2s935uGfnK

### Endpoint

#### kasus dimana setiap table bisa melakukan CRUD 

    keterangan : 
        {{url}} = http://localhost:8000
        {{locale}} = id / en

* Get all category
        
        {{url}}/api/{{locale}}/category

        parameter (optional): 
        per_page: limit per halaman, contoh nilai : 10
        sort_column: kolom table yang akan di sorting , contoh nilai : id
        sort_type: jenis tipe sortir ascending (asc) atau descending (desc), contoh nilai : asc 
        search_column: kolom table yang akan di search , contoh nilai : name
        search_text: value yang akan di seacrh , contoh nilai : fashion

* Get detail category
        
        {{url}}/api/{{locale}}/category/21

* create category
        
        {{url}}/api/{{locale}}/category/create

        payload body (required):
        name
        enable 

* update category
        
        {{url}}/api/{{locale}}/category/update/11

        payload body (required):
        name
        enable 

* delete category
        
        {{url}}/api/{{locale}}/category/21   

* Get all product
        
        {{url}}/api/{{locale}}/product

        parameter (optional): 
        per_page: limit per halaman, contoh nilai : 10
        sort_column: kolom table yang akan di sorting , contoh nilai : id
        sort_type: jenis tipe sortir ascending (asc) atau descending (desc), contoh nilai : asc 
        search_column: kolom table yang akan di search , contoh nilai : name
        search_text: value yang akan di seacrh , contoh nilai : fashion

* Get detail product
        
        {{url}}/api/{{locale}}/product/21

* create product
        
        {{url}}/api/{{locale}}/product/create

        payload body (required):
        name
        description
        enable 

* update product
        
        {{url}}/api/{{locale}}/product/update/11

        payload body (required):
        name
        description
        enable 

* delete product
        
        {{url}}/api/{{locale}}/product/21   


* Get all category product
        
        {{url}}/api/{{locale}}/categoryproduct

        parameter (optional): 
        per_page: limit per halaman, contoh nilai : 10
        sort_column: kolom table yang akan di sorting , contoh nilai : id
        sort_type: jenis tipe sortir ascending (asc) atau descending (desc), contoh nilai : asc 
        search_column: kolom table yang akan di search , contoh nilai : name
        search_text: value yang akan di seacrh , contoh nilai : fashion

* Get detail category product
        
        {{url}}/api/{{locale}}/categoryproduct/21

* create category product
        
        {{url}}/api/{{locale}}/categoryproduct/create

        payload body (required):
        category_id
        product_id

* update category product
        
        {{url}}/api/{{locale}}/categoryproduct/update/11

        payload body (required):
        category_id
        product_id

* delete category product
        
        {{url}}/api/{{locale}}/categoryproduct/21   


* Get all image
        
        {{url}}/api/{{locale}}/image

        parameter (optional): 
        per_page: limit per halaman, contoh nilai : 10
        sort_column: kolom table yang akan di sorting , contoh nilai : id
        sort_type: jenis tipe sortir ascending (asc) atau descending (desc), contoh nilai : asc 
        search_column: kolom table yang akan di search , contoh nilai : name
        search_text: value yang akan di seacrh , contoh nilai : fashion

* Get detail image
        
        {{url}}/api/{{locale}}/image/21

* create image
        
        {{url}}/api/{{locale}}/image/create

        payload body (required):
        name
        file
        enable 

* update category product
        
        {{url}}/api/{{locale}}/image/update/11

        payload body (required):
        name
        file
        enable 

* delete category product
        
        {{url}}/api/{{locale}}/image/21   

* Get all product image
        
        {{url}}/api/{{locale}}/productimage

        parameter (optional): 
        per_page: limit per halaman, contoh nilai : 10
        sort_column: kolom table yang akan di sorting , contoh nilai : id
        sort_type: jenis tipe sortir ascending (asc) atau descending (desc), contoh nilai : asc 
        search_column: kolom table yang akan di search , contoh nilai : name
        search_text: value yang akan di seacrh , contoh nilai : fashion

* Get detail product image
        
        {{url}}/api/{{locale}}/productimage/21

* create product image
        
        {{url}}/api/{{locale}}/productimage/create

        payload body (required):
        image_id
        product_id

* update product image
        
        {{url}}/api/{{locale}}/productimage/update/11

        payload body (required):
        image_id
        product_id 

* delete product image
        
        {{url}}/api/{{locale}}/productimage/21   


#### kasus dimana all table berelasi  

* Get all product image dan category
        
        {{url}}/api/{{locale}}/products

        parameter (optional): 
        per_page: limit per halaman, contoh nilai : 10
        sort_column: kolom table yang akan di sorting , contoh nilai : id
        sort_type: jenis tipe sortir ascending (asc) atau descending (desc), contoh nilai : asc 
        search_column: kolom table yang akan di search , contoh nilai : name
        search_text: value yang akan di seacrh , contoh nilai : fashion

* Get detail product image dan category
        
        {{url}}/api/{{locale}}/products/21

* create product image dan category

        kasus ini category dan images udah di jadikan master data dan hanya milih category_id,image_id dan input product
        
        {{url}}/api/{{locale}}/products/create

        payload body (required):
        name
        description
        enable:
        category_id[]
        image_id[]:

* update product image dan category
        
        {{url}}/api/{{locale}}/products/update/11

        payload body (required):
        name
        description
        enable:
        category_id[]
        image_id[]:

* delete product image dan category
        
        {{url}}/api/{{locale}}/products/21 

* store all table dengan 1 Endpoint

        {{url}}/api/{{locale}}/productall/create

        payload body (required):
        name
        description
        enable
        category_name[]
        category_enable[]
        image_name[]
        image_file[]
        image_enable[]

