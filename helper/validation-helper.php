<?php
function validateInputs(array $inputs, array $rules)
{
    $errors = [];

    foreach ($rules as $field => $ruleSet) {
        $value = isset($inputs[$field]) ? $inputs[$field] : null;
        $rulesArray = explode('|', $ruleSet);

        $isNullable = in_array('nullable', $rulesArray);

        foreach ($rulesArray as $rule) {
            $ruleParts = explode(':', $rule);
            $ruleName = $ruleParts[0];
            $ruleParam = $ruleParts[1] ?? null;

            if ($isNullable && ($value === null || $value === '')) {
                break; // Skip all checks
            }

            switch ($ruleName) {
                case 'required':
                    if ($value === '' || $value === null) {
                        $errors[$field][] = ucfirst($field) . ' is required.';
                    }
                    break;

                case 'nullable':
                    break; // handled above

                case 'email':
                    if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[$field][] = ucfirst($field) . ' must be a valid email.';
                    }
                    break;

                case 'numeric':
                case 'number':
                    if ($value !== '' && !is_numeric($value)) {
                        $errors[$field][] = ucfirst($field) . ' must be numeric.';
                    }
                    break;

                case 'integer':
                    if ($value !== '' && !filter_var($value, FILTER_VALIDATE_INT)) {
                        $errors[$field][] = ucfirst($field) . ' must be an integer.';
                    }
                    break;

                case 'min':
                    if (is_numeric($value)) {
                        if ($value < $ruleParam) {
                            $errors[$field][] = ucfirst($field) . " must be at least {$ruleParam}.";
                        }
                    } else {
                        if
                        (strlen($value) < $ruleParam) {
                            $errors[$field][] = ucfirst($field) . " must be at least {$ruleParam} characters.";
                        }
                    }
                    break;
                case 'max':
                    if (is_numeric($value)) {
                        if ($value > $ruleParam) {
                            $errors[$field][] = ucfirst($field) . " must be no more than {$ruleParam}.";
                        }
                    } else {
                        if (strlen($value) > $ruleParam) {
                            $errors[$field][] = ucfirst($field) . " must not exceed {$ruleParam} characters.";
                        }
                    }
                    break;

                case 'between':
                    list($min, $max) = explode(',', $ruleParam);
                    if (is_numeric($value)) {
                        if ($value < $min || $value > $max) {
                            $errors[$field][] = ucfirst($field) . " must be between {$min} and {$max}.";
                        }
                    } else {
                        $len = strlen($value);
                        if ($len < $min || $len > $max) {
                            $errors[$field][] = ucfirst($field) . " length must be between {$min} and {$max} characters.";
                        }
                    }
                    break;

                case 'digits':
                    if (!ctype_digit($value) || strlen($value) != $ruleParam) {
                        $errors[$field][] = ucfirst($field) . " must be exactly {$ruleParam} digits.";
                    }
                    break;

                case 'alpha':
                    if (!ctype_alpha($value)) {
                        $errors[$field][] = ucfirst($field) . ' must contain only letters.';
                    }
                    break;

                case 'alpha_num':
                    if (!ctype_alnum($value)) {
                        $errors[$field][] = ucfirst($field) . ' must contain only letters and numbers.';
                    }
                    break;

                case 'alpha_dash':
                    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $value)) {
                        $errors[$field][] = ucfirst($field) . ' may only contain letters, numbers, dashes, and underscores.';
                    }
                    break;

                case 'url':
                    if (!filter_var($value, FILTER_VALIDATE_URL)) {
                        $errors[$field][] = ucfirst($field) . ' must be a valid URL.';
                    }
                    break;

                case 'date':
                    if (!strtotime($value)) {
                        $errors[$field][] = ucfirst($field) . ' must be a valid date.';
                    }
                    break;

                case 'after':
                    if (strtotime($value) <= strtotime($inputs[$ruleParam] ?? $ruleParam)) {
                        $errors[$field][] = ucfirst($field)
                            . " must be after {$ruleParam}.";
                    }
                    break;
                case 'before':
                    if (
                        strtotime($value) >=
                        strtotime($inputs[$ruleParam] ?? $ruleParam)
                    ) {
                        $errors[$field][] = ucfirst($field) . " must be before {$ruleParam}.";
                    }
                    break;

                case 'confirmed':
                    $confirmation = $inputs[$field . '_confirmation'] ?? '';
                    if ($confirmation !== $value) {
                        $errors[$field][] = ucfirst($field) . ' does not match confirmation.';
                    }
                    break;

                case 'in':
                    $allowed = explode(',', $ruleParam);
                    if (!in_array($value, $allowed)) {
                        $errors[$field][] = ucfirst($field) . ' must be one of: ' . implode(', ', $allowed) . '.';
                    }
                    break;

                case 'same':
                    if ($value !== ($inputs[$ruleParam] ?? null)) {
                        $errors[$field][] = ucfirst($field) . " must match {$ruleParam}.";
                    }
                    break;

                case 'different':
                    if ($value === ($inputs[$ruleParam] ?? null)) {
                        $errors[$field][] = ucfirst($field) . " must be different from {$ruleParam}.";
                    }
                    break;

                case 'starts_with':
                    $prefixes = explode(',', $ruleParam);
                    $matched = false;
                    foreach ($prefixes as $prefix) {
                        if (str_starts_with($value, $prefix)) {
                            $matched = true;
                            break;
                        }
                    }
                    if (!$matched) {
                        $errors[$field][] = ucfirst($field) . ' must start with one of: ' . implode(', ', $prefixes);
                    }
                    break;

                case 'ends_with':
                    $suffixes = explode(',', $ruleParam);
                    $matched = false;
                    foreach ($suffixes as $suffix) {
                        if (str_ends_with($value, $suffix)) {
                            $matched = true;
                            break;
                        }
                    }
                    if (!$matched) {
                        $errors[$field][] = ucfirst($field) . ' must end with one of: ' . implode(', ', $suffixes);
                    }
                    break;

                case 'file':
                    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
                        $errors[$field][] = ucfirst($field) . ' must be a valid uploaded file.';
                    }
                    break;

                case 'image':
                    $mime = $_FILES[$field]['type'] ?? '';
                    if (!str_starts_with($mime, 'image/')) {
                        $errors[$field][] = ucfirst($field) . ' must be an image file.';
                    }
                    break;
                case 'mimes':
                    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
                        $errors[$field][] = ucfirst($field) . ' must be a valid uploaded file.';
                    } else {
                        $allowedMimes = explode(',', $ruleParam);
                        $fileMime = mime_content_type($_FILES[$field]['tmp_name']);
                        $extension = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);

                        // Laravel maps extensions, so we check MIME group from extension
                        $mimeMap = [
                            'jpeg' => 'image/jpeg',
                            'jpg' => 'image/jpeg',
                            'png' => 'image/png',
                            'gif' => 'image/gif',
                            'bmp' => 'image/bmp',
                            'webp' => 'image/webp',
                            'svg' => 'image/svg+xml',
                            'pdf' => 'application/pdf',
                            'doc' => 'application/msword',
                            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ];

                        $valid = false;
                        foreach ($allowedMimes as $mime) {
                            if (isset($mimeMap[$mime]) && $fileMime === $mimeMap[$mime]) {
                                $valid = true;
                                break;
                            }
                        }

                        if (!$valid) {
                            $errors[$field][] = ucfirst($field) . ' must be a file of type: ' . implode(', ', $allowedMimes) . '.';
                        }
                    }
                    break;

                case 'regex':
                    if (!preg_match("/{$ruleParam}/", $value)) {
                        $errors[$field][] = ucfirst($field) . ' format is invalid.';
                    }
                    break;

                default:
                    // Unknown rule
                    break;
            }
        }
    }

    return $errors;
}