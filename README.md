# EmployeeHub

EmployeeHub is a Laravel 13 employee-management application. Authenticated users can manage their own departments and employees through the web interface or the REST API.

## Requirements

- PHP 8.3 or later with SQLite enabled
- Composer 2
- Node.js 20 or later and npm

## Setup

From the `employee-management-system` directory, install the project dependencies and prepare the environment:

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
```

On macOS or Linux, replace `copy` with `cp`.

## Environment configuration

The application is configured for SQLite by default. Ensure these values exist in `.env`:

```dotenv
APP_NAME=EmployeeHub
APP_URL=http://localhost:8000
DB_CONNECTION=sqlite
SESSION_DRIVER=database
```

Create an empty `database/database.sqlite` file if it is missing. To use MySQL instead, set `DB_CONNECTION=mysql` and configure `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`.

## Database setup and seed data

Run the migrations and load the demonstration data:

```bash
php artisan migrate
php artisan db:seed
```

The seeder creates five departments and fifty employees. It also provides this browser login:

| Email | Password |
| --- | --- |
| `test@example.com` | `password` |

## Running the application

Build frontend assets once:

```bash
npm run build
```

For local development, run these in separate terminals:

```bash
php artisan serve
npm run dev
```

Open `http://localhost:8000`. The first page has normal **Log in** and **Create an account** actions. Once signed in, use the Departments and Employees navigation links.

## Features

- Laravel Breeze registration, login, logout, password reset, profile management, and email-verification routes.
- Gates and ownership policies; users only access records they created.
- Department CRUD: name, description, and active/inactive status.
- Employee CRUD: name, email, phone, salary, joining date, department, and status.
- Department-to-employee one-to-many relationship; every employee requires an active department owned by the current user.
- Soft deletes for departments and employees. A department with employees cannot be deleted until its employees are moved or deleted.
- Server-side DataTables employee listing with name/email search, department/status filtering, ordering, and pagination.
- jQuery client-side required-field validation and Laravel Form Request server-side validation.
- SweetAlert2 confirmation for delete actions and success/error feedback for create, update, and delete actions.

## REST API

API routes are prefixed with `/api` and resource endpoints require a Sanctum bearer token. Requests and responses use JSON.

### Authentication

| Method | Endpoint | Purpose |
| --- | --- | --- |
| POST | `/api/register` | Create an account and receive a token |
| POST | `/api/login` | Receive a bearer token |
| POST | `/api/logout` | Revoke the current bearer token |

`POST /api/register` expects `name`, `email`, `password`, `password_confirmation`, and optional `device_name`. `POST /api/login` expects `email`, `password`, and optional `device_name`.

### Resources

| Method | Endpoint | Purpose |
| --- | --- | --- |
| GET | `/api/departments` | List departments |
| POST | `/api/departments` | Create a department |
| GET | `/api/departments/{id}` | View a department |
| PUT/PATCH | `/api/departments/{id}` | Update a department |
| DELETE | `/api/departments/{id}` | Soft-delete a department |
| GET | `/api/employees` | List employees |
| POST | `/api/employees` | Create an employee |
| GET | `/api/employees/{id}` | View an employee |
| PUT/PATCH | `/api/employees/{id}` | Update an employee |
| DELETE | `/api/employees/{id}` | Soft-delete an employee |

Employee list queries accept `search`, `department_id`, `status`, and normal Laravel pagination parameters such as `page`. Resource records are always scoped to the token owner.

### API test example

Sign in and save the `token` from the response:

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password","device_name":"README example"}'
```

Use the returned token for an authenticated request:

```bash
curl http://localhost:8000/api/employees \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

Create a department:

```bash
curl -X POST http://localhost:8000/api/departments \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"name":"Support","description":"Customer support team","status":"active"}'
```

## Tests

Run the automated suite with:

```bash
php artisan test
```

## AI prompt/source document

The implementation requirements are recorded in the tracked [AI implementation prompt](docs/ai-prompt.md). AI assistance was used to implement the Laravel application from that document.
