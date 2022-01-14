# Documentation Laravel 8
**Création d'un projet Laravel**
`composer create-project laravel/laravel <nom du projet>`

**Démarrer le projet**
`php artisan serve`

## Routing de base
On utilise la méthode ```Route::view``` pour afficher la vue dans le navigateur avec l'url qu'on veut. On peut aussi renvoyer une string ou une response en JSON.

## Controllers
C'est le contrôleur qui renvoit la vue
On peut créer un controller en faisant ```php artisan make controller <nom>``` 

## Les vues avec Blade
Blade est un générateur de templates.
**11/01/2022**


On peut faire un template pour nos vues dans un dossier layout, ou on met tout le doctype et le pied de page. Et on met la partie dynamique entre les deux :
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mon super site</title>
</head>
<body>
    @yield('content')
</body>
</html>
```
Dans notre vue on met ```@extends('layout.app')``` pour dire que dans le dossier layout il y a un fichier app qui est ma structure générale
Puis on ajoute la section 'content' la partie dynamique : 
```php
@section('content')
<h1>Liste des articles</h1>
    @foreach($posts as $post)
        <h3>{{ $post }}</h3>
    @endforeach
@endsection
```
On peut lister nos routes avec la commande ```php artisan route:list```

## Compiler les assets (Installation de TailwindCSS)
on utilise ```npm install``` pour installer les librairies
```npm install -D tailwindcss```
```npx tailwindcss init``` permet de créer un tailwing.config.jss pour ajouter nos fichier templates

## Les migrations
Infomations de connexions de la db ddans le fichier .env
On peut créer un model en faisant ```php artisan make:model Post -m``` ça créée un fichier dans Models et une migration
Dans la migration on peut modifier si on veut différents champs dans la base de données
```php
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('content');
            $table->timestamps();
        });
    }
```
Pour créer les tables il faut utiliser ```php artisan migrate```

## Les factories
On utilise des fonctions de Faker pour générer phrase et paragraphs
On créé un factory en faisant ```php artisan make:factory <nom du factory> --model=<model pour lequel on veut faire la factory>``` ça nous créé un fichier.
On change la function definiton pour faire retourner le titre en phrase, le content en paragraphe et la date de création à now.
```php
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];
    }
```
Pour génerer tout ça on utilise tinker
on fait ```php artisan tinker``` on peut y taper du php
On y rentre ```Post::factory()->count(10)->create();``` on appelle la factory du model Post et on génere 10 articles
## L'ORM Eloquent
C'est un ORM qui permet d'intéragir avec la db (faire des requêtes insert, update...)
On peut modifier des noms dans les models
Si je rajoute ```$posts = Post::all();``` dans ma fonction index, on retrouve les champs de la table posts, dans notre view on peut afficher seulement un champ
```php
@extends('layout.app')

@section('content')
<h1>Liste des articles</h1>
    @foreach($posts as $post)
        <h3><a href="">{{ $post->title }}</a></h3>
    @endforeach
@endsection
```
on ajoute un if pour qu'un message apparaisse si il n'y a pas de posts
```php
@extends('layout.app')

@section('content')
<h1>Liste des articles</h1>
    @if ($posts-count() > 0 )
        @foreach($posts as $post)
            <h3><a href="">{{ $post->title }}</a></h3>
        @endforeach
    @else
        <span>Aucun post en base de données</span>
    @endif
@endsection
```
On peut faire une requête en cherche une string ```$post =  Post::where('title','=','Ullam soluta ut error a sed accusantium a.')->get();```
(erreur collection instance = pas récupéré le bon item dans le get)
**13/01/2022**
Erreur rencontrée :
```
Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table

   Illuminate\Database\QueryException 

  SQLSTATE[42000]: Syntax error or access violation: 1071 La clé est trop longue. Longueur maximale: 1000 (SQL: alter table `users` add unique `users_email_unique`(`email`))

  at C:\Users\Bqker\Documents\laravel\vendor\laravel\framework\src\Illuminate\Database\Connection.php:705
    701▕         // If an exception occurs when attempting to run a query, we'll format the error
    702▕         // message to include the bindings with SQL, which will make this exception a
    703▕         // lot more helpful to the developer instead of just the database's errors.
  ➜ 705▕             throw new QueryException(
    707▕             );
    708▕         }
    709▕     }

  1   C:\Users\Bqker\Documents\laravel\vendor\laravel\framework\src\Illuminate\Database\Connection.php:494
      PDOException::("SQLSTATE[42000]: Syntax error or access violation: 1071 La clé est trop longue. Longueur maximale: 1000")

  2   C:\Users\Bqker\Documents\laravel\vendor\laravel\framework\src\Illuminate\Database\Connection.php:494
      PDOStatement::execute()
```
Solution :
Modifier 
```php
use Illuminate\Support\Facades\Schema;
function boot()
{
    Schema::defaultStringLength(191); //NEW: Increase StringLength
}
```
Dans ```App/providers/AppServiceProvider.php```
Puis relancer une migration
## Relation One to Many
Plusieurs commentaires pour un post

## Relation One to One
Une image pour un post
