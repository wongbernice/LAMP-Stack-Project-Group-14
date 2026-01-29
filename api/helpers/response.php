<?php
/**
 * FILE: api/helpers/response.php
 * PURPOSE:
 *   Standardize API JSON responses so every endpoint returns consistent output.
 *
 * WHAT IT DOES:
 *   - Provides helper functions to send JSON responses (success/error).
 *   - Sets appropriate HTTP status codes and Content-Type header.
 *
 * COMMON FUNCTIONS (example names):
 *   - json_success($data = null, $message = 'OK', $status = 200)
 *   - json_error($message = 'Error', $status = 400, $errors = null)
 *
 * USED BY:
 *   - All endpoints to return responses in a consistent structure.
 */
