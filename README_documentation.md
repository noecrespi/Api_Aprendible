## Crear el poryecto y la base de datos con blueprint

Crear el proyecto 
```bash
composer create-project laravel/laravel Api_Aprendible
```
 
Entrar carpeta:
```bash
cd Api_Aprendible
```

Crear los modelos con ayuda de blueprint
```bash
composer require laravel-shift/blueprint --dev
```

Creción de archivo donde estara el esquema de lo que queremos generar
```bash
php artisan blueprint:new
```

Entrar en el archivo`draft.yaml`. Añadir:
```yaml
models:

    Article:
        title: string
        slug: string unique
        content: longtext
        category_id: id
        user_id: id 
    
    Category:
        name: string
        slug: string unique
        relationships:
            hasMany: Article

```

Publicar archivo de configuracion del paquete 
```bash
php artisan vendor:publish 
```
    seleccionar:
        > blueprint-config    


(Hacer cositas de en config/blueprint.php)

Cambiar: 
Generar los archivos
```bash
php artisan blueprint:build
```


planos de contrucion para generar los archivos
```bash
php artisan stub:publish
```
Eliminar todo lo que no necesitamos en la carpeta `stubs/blueprint` (eliminar todos los archivos menos  `test.stub` y `test.unit.stub`). Dejamos la carpeta `stubs/blueprint` llena .


entrar stubs/test.stub y copiar lo que tengo puesto 



## Impelementacion de rutas para obtener articulos    -> 
- php artisan test --filter can_fetch_all_articles -> ver que pasa el test
- php artisan route:list -> ver que se han creado las rutas 2


Eliminar los archivos de las carpetas `tests/Feature` y `tests/Unit`.

Crear el primer test 
```bash
php artisan make:test ArticleTest/ListArticlesTest
```
Añadir código `ArticleTest/ListArticlesTest.php`

ir `phpunit.xml` descomentar lineas para probar los test en memoria 
```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

Ejecutar los test
```bash
php artisan test
```
para ver el error más concreto es añadiendo la frase dentro del test
```php
$this->withoutExceptionHandling(); 
```
tocamos:
- `routes/api.php`
- `tests/Feature/ArticleTest/ListArticlesTest.php`
- `app/Providers/RouteServiceProvider.php`

creamos el controlador
```bash 
php artisan make:controller Api/ArticleController
```

crear recurso laravel   
```bash
php artisan make:resource ArticleResource
```
Añadido cosas en app/Http/Resources/ArticleResource.php
Article controller

php artisan make:resource ArticleCollection 



## Ruta para crear articulos 
- php artisan test -> ver que pasan los test

php artisan make:test Articles/CreateArticleTest

## Middleware para verificar de los headers JSON:API

php artisan make:test ValidateJsonApiHeaderTest

php artisan make:middleware ValidateJsonApiHeaders



Hay que modificar el json de  MakesJsonApiRequests (añaidr el $options = 0 )
    public function postJson($uri, array $data = [], array $headers = [],  $options = 0 ): TestResponse


## vAlidacion del documentos Json:API
php artisan test 

php artisan make:test ValidateJsonApiDocumentTest

php artisan make:middleware ValidationJsonApiDocument


## 16. Actualizacion de articulos // Cómo actualizar recursos siguiendo la especificación JSON:API
php artisan test --filter can_update_articles

php artisan test 




-----------
IR CON CUIDODO EN 13 NO VA BIEN ....


php artisan test 


