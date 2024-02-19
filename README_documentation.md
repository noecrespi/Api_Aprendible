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

