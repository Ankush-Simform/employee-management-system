# AI implementation prompt

This document records the project requirements supplied while building EmployeeHub.

## Core requirements

1. Set up authentication and authorization with Laravel Breeze:
   - Register
   - Login
   - Logout
   - Gates and policies for present and future use
2. Implement department CRUD with:
   - Name
   - Description
   - Status
3. Implement employee CRUD with:
   - Name
   - Email
   - Phone
   - Salary
   - Joining date
   - Department
   - Status
   - Soft deletes
4. Maintain the department/employee relationship:
   - A department has many employees.
   - An employee belongs to one department.
   - An employee must be assigned to an existing department.
5. Seed the database and implement server-side DataTables search, filters, and pagination:
   - Search by employee name or email.
   - Filter by department and status.
6. Add client-side jQuery validation and server-side Laravel Form Request validation.
7. Provide RESTful APIs for the application.
8. Replace the default Laravel entry UI with a normal login/sign-up experience.

## Documentation and feedback requirements

The README must include:

- Setup instructions
- Environment configuration
- Database setup
- Migration and seed commands
- API endpoint details
- Sample authentication credentials
- API testing instructions
- A link to this prompt document because AI tools were used

Use SweetAlert2 instead of standard browser messages for create, update, and delete feedback and delete confirmations.

## Landing-page requirement

Use the provided employee-management image on the left of the first page. Show the login form directly on the right and a registration/sign-up link below the form.
