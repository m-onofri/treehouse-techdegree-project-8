# treehouse-techdegree-project-8

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

In the **inc** folder create the .env file and insert a secret key required for the generation of the JSON Web Token:
```
SECRET_KEY= your_secret_key_here
```

Run the server:
```
cd public
php -S localhost:4000
```

In your browser, go to http://localhost:4000/, register yourself to the app and play with it.

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

* In the **'inc'** folder you can find:
    - the **functions_aut.php** file containing the methods to manage authentication process;
    - the **functions_tasks.php** file containing the methods to create, read, update and delete tasks in the database;
    - the **functions_user.php** file containing the methods to create, read, update and delete users in the database;
    - the **todo.db** SQLite database.
* In the **'procedures'** folder you can find:
    - the **action_tasks.php** file containing the code to create, update and delete a task;
    - the **changePassword.php** file containing the code to update the password;
    - the **doLogin.php** file containing the code to manage the login process;
    - the **doLogout.php** file containing the code to manage the logout process;
    - the **doRegister.php** file containing the code to manage the register process.

## Cross-browser consistency

The project was checked on MacOS in Chrome, Firefox, Opera and Safari, and on these browsers it works properly.

