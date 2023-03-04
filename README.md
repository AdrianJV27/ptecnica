# Prueba técnica

API que implementa un CRUD de usuarios con autenticación

## Primeros pasos

```bash
#Instala todos los paquetes
composer install
```
Cambiar el *.env.example* por *.env* y añadir el nombre, usuario y contraseña de la base de datos

```bash
#Migrar las tablas
php artisan migrate
```
```bash
#Crear registros en la tabla de usuarios
php artisan db:seed --class=UserSeeder
```

## Rutas (routes\api.php)

La siguiente línea de código crea automáticamente todas las rutas de un CRUD básico.
```php
Route::apiResource('user', UserController::class);
```  

```bash
#Muestra todos los usuarios
GET|HEAD        api/user ....................... user.index › UserController@index 

#Almacena un usuario (requiere un json con las keys *name*, *email* y *password*)
POST            api/user ....................... user.store › UserController@store 

#Muestra un usuario (requiere especificarle en la ruta el id del usuario)
GET|HEAD        api/user/{user} .................. user.show › UserController@show 

#Actualiza un usuario (requiere especificarle en la ruta el id del usuario y un json con las keys *name*, *email* y *password*)
PUT|PATCH       api/user/{user} .............. user.update › UserController@update 

#Elimina un usuario (requiere especificarle en la ruta el id del usuario)
DELETE          api/user/{user} ............ user.destroy › UserController@destroy 

```  


Ruta del top dominios más usados
```php
Route::get('/top-domain', [UserController::class, 'topDomain']);
``` 

```php
#Devuelve un objeto con los 3 dominios más usados en orden descendiente
GET|HEAD        api/top-domain .......................... UserController@topDomain 
```

Ruta de registro
```php
Route::post('/register', [AuthController::class, 'register']);
```  
```php
#Registra el usuario en la base de datos y genera un token para autenticarte en la API (requiere un json con las keys *name*, *email* y *password*)
POST            api/register ............................. AuthController@register
```

Ruta de log in
```php
Route::post('/login', [AuthController::class, 'login']);
```  
```php
#Comprueba si el usuario existe para iniciar sesión y genera un token para autenticarte en la API (requiere un json con las keys *email* y *password*)
POST            api/login ................................... AuthController@login 
```

Ruta de log out
```php
Route::get('/logout', [AuthController::class, 'logout']);
```  
```php
#Elimina el token del usuario y para no poder usar la API hasta que vuelva a iniciar sesión y generar uno nuevo
GET|HEAD        api/logout ................................. AuthController@logout 
```


## Configuración POSTMAN

Todos los endpoint requieren el header *Accept* *application/json*

Para usar cualquier ruta también se necesita autenticarse con el token de la propiedad *accessToken* del objeto que devuelve la ruta *login* o *register*

Para las rutas *Store*, *Login*, *Register* el body debe ser *form-data*

Para la ruta *Update* el body debe ser *x-www-form-urlencoded*

Para usar el token se debe ir a la pestaña *Authorization* y seleccionar el tipo *Bearer Token* y añadir ahí el token que nos ha retornado la ruta *Login* o *Register*
