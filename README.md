## Test for Patchstack

### Acceptance
Visitor should be able to:
- View all currently added vulnerabilities to the database 
- View a specific vulnerability 
- Edit a vulnerability 
- Add a vulnerability 
- Delete a vulnerability

### Installation
You can run the application in Your own environment or use Docker. See Laravel [Sail documentation](https://laravel.com/docs/8.x/sail#installing-composer-dependencies-for-existing-projects) for installation.
To start Sail, use `vendor/bin/sail up -d`.

### Setup
Using Sail you must prefix any command you want to run in the container with `sail`. So to run migrations, use `sail artisan migrate:fresh --seed` or `sail php artisan migrate:fresh --seed`.

### Testing
Run `php artisan test`, or `vendor/bin/sail artisan test` if using included Laravel Sail.
