# treehouse-techdegree-project-8

# treehouse-techdegree-project-7

The goal of this project is to add User Authentication to an existing ToDo App.

## How to install 

Clone the git repository in the folder of your choice:
```
git clone https://github.com/m-onofri/treehouse-techdegree-project-8.git
```

Install the packages:
```
cd treehouse-techdegree-project-8
composer install
```

Run the server:
```
cd public
php -S localhost:4000
```

In your browser, go to http://localhost:4000/ and give a look at the ToDo App.

 ## Main features

 * New user can register for the application; user's password is stored as a hash.
 * User can login to the application.
 * User can logout of the application.
 * Users can update their password.
 * The logged in user can see only the tasks associated with his user id.
 * The logged in user can add new tasks that will be associated only to the logged in user.
 * The logged in user can update or delate a task.

## Additional features

* Automatic login on registration.
* Authentication is managed using cookies.
* The logged in user is secured with JWT (JSON Web Token).

## Code organization

* The Slim Framework 3 was quickly setup using a [**skeleton application**](https://github.com/slimphp/Slim-Skeleton). 
* In the **'public'** folder you can find the index.php file;
* In the **'src'** folder you can find:
    - the subfolder **Model** containing the **Task** and **Subtask** classes, responsible for managing the data of the application;
    - the subfolder **Exception** containing the **ApiException** class, responsible for managing exceptions;
    - the **routes.php** file with all the routes of the project;
    - the **todo.db** database.

## Cross-browser consistency

The project was checked on MacOS in Chrome, Firefox, Opera and Safari, and on these browsers it works properly.

