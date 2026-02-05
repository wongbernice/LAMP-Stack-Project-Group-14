<?php
/**
 * FILE: api/helpers/auth.php
 * PURPOSE:
 *   Shared authentication utilities for protected endpoints.
 *
 * WHAT IT DOES:
 *   - Reads auth credentials (session/cookie/token/header depending on your design).
 *   - Validates whether the requester is authenticated.
 *   - Can expose helper functions like require_auth() or get_current_user().
 *
 * USED BY:
 *   - Typically used by contacts endpoints (add/edit/delete) if they require login.
 *   - Optionally used by search endpoint too if the API is private.
 *
 * NOTES:
 *   - Keep auth checks here so endpoints stay clean and consistent.
 */
?>