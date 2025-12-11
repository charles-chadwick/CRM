# Overview

This will be a basic Customer Relationship Management system. It will allow Users to manage Companies and Customers.

## Stack

The following will be used: 

Laravel 12 with Inertia
Spatie's Laravel Permissions. 
Spatie's Laravel Activity log, to log every click and database change a user makes. 
Spatie's Laravel Media Library to handle Avatars for users, companies and customers. 
VueJS with Ziggy for routes and Primevue for components. 

## Code Style
All functions and methods are camelCased. All database fields, variables and class properties should be snake_cased. 

## Properties and Relationships
All model properties will come from the supplied schema. 
All models will inherit from a base class called Base, which in turn extends from Model. Base model will handle relationships for the created_by, updated_by, and deleted_by fields. 

Users will have three roles:
    - Admin (all privileges)
    - Manager (all privilieges except User Management)
    - Sales Rep (can only manage Customers)

Companies will have many Customers. Both Comapnies and Customers can have many Contacts, which are polymorphic. 

Discussions are polymorphic and can be between users, or users and customers.

## Validation Rules

**All validation rules MUST be placed in associated Form Request classes.** Never validate directly in controllers or models.

- Create Form Request classes in `app/Http/Requests/` directory
- Name them following Laravel conventions (e.g., `StoreUserRequest`, `UpdateUserRequest`)
- Use separate request classes for `store()` and `update()` methods when validation differs
- Controllers should type-hint the Form Request class instead of `Illuminate\Http\Request`
- Example: `public function store(StoreUserRequest $request)` instead of `public function store(Request $request)`

This keeps validation logic organized, reusable, and follows Laravel best practices.

## PrimeVue Component Imports

**All PrimeVue components MUST be imported using a single destructured import statement.**

- Import all PrimeVue components in one line using destructuring: `import { Button, DataTable, Column, ConfirmDialog } from 'primevue';`
- Never import components individually like: `import Button from 'primevue/button';`
- The only exception to this rule is for PrimeVue's Editor compnent, which should be used for `<textarea>` elements.
- Services, composables, and configuration imports (e.g., `PrimeVue`, `ConfirmationService`, `Tooltip`, `useConfirm`) may still use individual imports as they are not components.

This ensures consistency and cleaner imports across the codebase.

All buttons to create records should have a severity of "primary" and all buttons to delete records should have a severity of "danger. Any other buttons should have a severity of "secondary".