<?php
/**
 * FILE: api/contacts/edit.php
 * OWNER: A (Angelo)
 * PURPOSE:
 *   Update an existing contact (Edit / Update).
 *
 * WHAT IT DOES:
 *   - Accepts a contact id and fields to update.
 *   - Validates that the id exists and input is valid.
 *   - Updates the matching contact row in the database.
 *   - Returns JSON success or JSON error.
 *
 * EXPECTED METHOD:
 *   - POST (common for simple PHP setups) or PUT if you later upgrade routing
 *
 * EXPECTED INPUT:
 *   - JSON body or form fields (typical):
 *       id (required), name/phone/email/etc. (one or more fields)
 *
 * OUTPUT:
 *   - JSON success: updated contact info or confirmation message
 *   - JSON error: missing id, not found, validation fail, or DB update fail
 *
 * AUTH:
 *   - If contacts are private, call an auth helper (e.g., require_auth()).
 *
 * DEPENDS ON:
 *   - ../config/db.php
 *   - ../helpers/response.php
 *   - ../helpers/auth.php (optional if protected)
 */
?>