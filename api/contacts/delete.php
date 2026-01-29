<?php
/**
 * FILE: api/contacts/delete.php
 * OWNER: A (Angelo)
 * PURPOSE:
 *   Delete a contact (Delete).
 *
 * WHAT IT DOES:
 *   - Accepts a contact id.
 *   - Validates that the id exists.
 *   - Deletes the matching contact row from the database.
 *   - Returns JSON success or JSON error.
 *
 * EXPECTED METHOD:
 *   - POST (common for simple PHP setups) or DELETE if you later upgrade routing
 *
 * EXPECTED INPUT:
 *   - JSON body or form fields (typical):
 *       id (required)
 *
 * OUTPUT:
 *   - JSON success: deletion confirmation
 *   - JSON error: missing id, not found, or DB delete fail
 *
 * AUTH:
 *   - If contacts are private, call an auth helper (e.g., require_auth()).
 *
 * DEPENDS ON:
 *   - ../config/db.php
 *   - ../helpers/response.php
 *   - ../helpers/auth.php (optional if protected)
 */
