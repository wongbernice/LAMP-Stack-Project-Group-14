<?php
/**
 * FILE: api/config/config.php
 * PURPOSE:
 *   Central place for API-wide configuration values (non-secret settings).
 *
 * WHAT IT DOES:
 *   - Defines constants/settings used across the API (e.g., app name, debug mode).
 *   - Optionally sets default timezone and error reporting for development.
 *
 * USED BY:
 *   - Included by most endpoint scripts before doing any work.
 *
 * NOTES:
 *   - Avoid storing secrets here (DB passwords, API keys). Put secrets in environment vars if possible.
 */
?>