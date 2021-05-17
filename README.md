
# Netra E-commerce

Netra E-commerce website

### Installation

-  ```git clone https://github.com/VicheaSolutionsDeveloper/Netra.git```

- cd to the app directory and copy from .env.example

-  ```cp .env.example .env```

- change the the .env content (admin, database, stmp, social client id )

-  ```composer install```

-  ```php artisan key:generate```

-  ```php artisan migrate```

-  ```php artisan db:seed```

- To create symlink folder on linux

-  ```php artisan storage:link```

- On windows cmd run on project directory

-  ```mklink /D "public\storage" "..\storage\app\public"```

- Done. Go to domain/dashboard to see admin dashboard.

  

### Logins
| Logins  		| Customer 				| Admin 											   |
| ------------- |:---------------------:| ----------------------------------------------------:|
| username      | `customer` 			| `admin` or in env `ADMIN_NAME` 					   |
| email         | `customer@gmail.com`  | `admin@gmail.com` or in env `ADMIN_NAME + gmail.com` |
| password 		| `customer123`         | `admin123` or in env `ADMIN_PASSWORD` 			   |
