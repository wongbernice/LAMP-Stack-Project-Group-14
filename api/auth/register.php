<?php
/**
 * FILE: api/auth/register.php
 * OWNER: S (Sameer)
 * PURPOSE:
 *   Create a new user account (Register).
 *
 * WHAT IT DOES:
 *   - Accepts registration fields (name, email/username, password).
 *   - Validates input and checks for duplicates (email/username already exists).
 *   - Hashes the password securely and stores the new user in the database.
 *   - Returns JSON success or JSON error with reason.
 *
 * EXPECTED METHOD:
 *   - POST
 *
 * EXPECTED INPUT:
 *   - JSON body or form fields (typical):
 *       name, email/username, password
 *
 * OUTPUT:
 *   - JSON success with created user id (and optionally auto-login/token)
 *   - JSON error if validation fails or user already exists
 *
 * DEPENDS ON:
 *   - ../config/db.php
 *   - ../helpers/response.php
 */
