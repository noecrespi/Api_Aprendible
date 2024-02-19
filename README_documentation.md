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

Cracion de archivo donde estara el esquema de lo que queremos generar
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
        relationship:
            hasMany: Article

```

Publicar archivo de configuracion del paquete 
```bash
php artisan vendor:publish 
```

seleccionar:
    > blueprint-config    


(Hacer cositas de en config/blueprint.php)

Generar los archivos
```bash
php artisan blueprint:build
```


planos de contrucion para generar los archivos
```bash
php artisan stub:publish
```
