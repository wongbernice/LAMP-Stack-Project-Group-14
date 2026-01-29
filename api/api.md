# API (Contacts App) — Setup + Endpoints

This README documents **only the `/api` folder** for the LAMP Stack project.  
It explains the folder structure, required setup, and how to use each endpoint.

---

## File Tree

```text
api/
  config/
    config.php
    db.php
  helpers/
    response.php
    auth.php
  auth/
    login.php       
    register.php     
  contacts/
    add.php          
    search.php       
    edit.php         
    delete.php      

```

## Files

### `api/config/config.php`
- **Purpose:** API-wide configuration 
- **Function:**
  - Defines constants/settings shared across endpoints 
  - Keeps configuration consistent so endpoints don’t hardcode values.
- **Used by:** Included at the top of endpoint scripts.

### `api/config/db.php`
- **Purpose:** Database connection setup for the API.
- **Function:**
  - Creates DB connection object/handle used by endpoints.
  - Allows endpoints to run queries without repeating connection code.
- **Used by:** All endpoints that read/write data.

### `api/helpers/response.php`
- **Purpose:** Standardize JSON responses across the API.
- **Function:**
  - Sets `Content-Type: application/json`.
  - Provides helper functions for consistent responses (success/error).
  - Sets appropriate HTTP status codes (200/400/401/500).
- **Used by:** All endpoints for consistent output formatting.

### `api/helpers/auth.php`
- **Purpose:** Shared authentication/authorization utilities.
- **Function:**
  - Validates authentication (session/token/header depending on implementation).
  - Can provide helpers like `require_auth()` and `get_current_user()`.
  - Returns a 401 JSON response when a request is unauthorized.
- **Used by:** Protected endpoints (add/edit/delete).

### `api/auth/register.php`
- **Purpose:** Register a new user account.
- **Function:**
  - Validates registration input (ex: name/email/password).
  - Checks for duplicate accounts (email already exists).
  - Hashes the password securely and stores the user in the database.
  - Returns JSON success/error.
- **Method:** `POST`

### `api/auth/login.php`
- **Purpose:** Log in an existing user.
- **Function:**
  - Validates login input (ex: email/password).
  - Verifies credentials against the database (password hash check).
  - Returns JSON success/error.
- **Method:** `POST`

### `api/contacts/add.php`
- **Purpose:** Create a new contact.
- **Function:**
  - Validates required contact fields.
  - Inserts a new contact record into the database.
  - Returns JSON success with the created contact/id or JSON error.
- **Method:** `POST`

### `api/contacts/search.php`
- **Purpose:** Read/search contacts.
- **Function:**
  - Returns a list of contacts from the database.
  - Returns JSON array of contacts (can be empty).
- **Method:** `GET`

### `api/contacts/edit.php`
- **Purpose:** Update an existing contact.
- **Function:**
  - Requires a contact `id` plus one or more fields to update.
  - Validates that the contact exists.
  - Updates the contact record in the database.
  - Returns JSON success/error.
- **Method:** `POST`

### `api/contacts/delete.php`
- **Purpose:** Delete a contact.
- **Function:**
  - Requires a contact `id`.
  - Deletes the contact record from the database.
  - Returns JSON success/error.
- **Method:** `POST`
