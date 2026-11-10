<?php
declare(strict_types=1);

namespace Core;

/**
 * Robust input validator and sanitizer with built-in support
 * for Indian financial formats (PAN, 10-digit mobile, PIN code, honeypot).
 */
class Validator
{
    private array $data;
    private array $errors = [];
    private array $validated = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function make(array $data, array $rules): self
    {
        $validator = new self($data);
        $validator->validate($rules);
        return $validator;
    }

    public function validate(array $ruleSet): bool
    {
        $this->errors = [];
        $this->validated = [];

        foreach ($ruleSet as $field => $rules) {
            $rulesArray = is_string($rules) ? explode('|', $rules) : $rules;
            $value = $this->data[$field] ?? null;

            foreach ($rulesArray as $ruleDefinition) {
                $params = [];
                if (str_contains($ruleDefinition, ':')) {
                    [$ruleName, $paramStr] = explode(':', $ruleDefinition, 2);
                    $params = explode(',', $paramStr);
                } else {
                    $ruleName = $ruleDefinition;
                }

                // If empty and not required, skip further checks
                if ($ruleName !== 'required' && ($value === null || $value === '')) {
                    continue;
                }

                $this->applyRule($field, $value, $ruleName, $params);
            }

            if (!isset($this->errors[$field])) {
                $this->validated[$field] = is_string($value) ? trim($value) : $value;
            }
        }

        return count($this->errors) === 0;
    }

    private function applyRule(string $field, mixed $value, string $rule, array $params): void
    {
        switch ($rule) {
            case 'required':
                if ($value === null || trim((string)$value) === '') {
                    $this->addError($field, __('The :field field is required.', ':field പൂരിപ്പിക്കേണ്ടതുണ്ട്.', ['field' => $this->formatFieldName($field)]));
                }
                break;

            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, __('Please enter a valid email address.', 'സാധുവായ ഒരു ഇമെയിൽ വിലാസം നൽകുക.'));
                }
                break;

            case 'phone':
                // Indian 10-digit mobile number format
                $clean = preg_replace('/[\s\-\+\(\)]/', '', (string)$value);
                if (str_starts_with($clean, '91') && strlen($clean) === 12) {
                    $clean = substr($clean, 2);
                }
                if (!preg_match('/^[6-9]\d{9}$/', $clean)) {
                    $this->addError($field, __('Please enter a valid 10-digit mobile number.', 'സാധുവായ 10 അക്ക മൊബൈൽ നമ്പർ നൽകുക.'));
                }
                break;

            case 'pincode':
                if (!preg_match('/^[1-9][0-9]{5}$/', (string)$value)) {
                    $this->addError($field, __('Please enter a valid 6-digit PIN code.', 'സാധുവായ 6 അക്ക പിൻ കോഡ് നൽകുക.'));
                }
                break;

            case 'pan':
                if (!preg_match('/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i', (string)$value)) {
                    $this->addError($field, __('Please enter a valid PAN number.', 'സാധുവായ ഒരു പാൻ നമ്പർ നൽകുക.'));
                }
                break;

            case 'numeric':
                if (!is_numeric($value)) {
                    $this->addError($field, __('The :field field must be a number.', ':field ഒരു സംഖ്യയായിരിക്കണം.', ['field' => $this->formatFieldName($field)]));
                }
                break;

            case 'min':
                $min = (int)($params[0] ?? 0);
                if (is_numeric($value)) {
                    if ((float)$value < $min) {
                        $this->addError($field, __('Must be at least :min.', 'കുറഞ്ഞത് :min ആയിരിക്കണം.', ['min' => $min]));
                    }
                } elseif (mb_strlen((string)$value) < $min) {
                    $this->addError($field, __('Must be at least :min characters.', 'കുറഞ്ഞത് :min അക്ഷരങ്ങൾ ഉണ്ടായിരിക്കണം.', ['min' => $min]));
                }
                break;

            case 'max':
                $max = (int)($params[0] ?? 255);
                if (is_numeric($value)) {
                    if ((float)$value > $max) {
                        $this->addError($field, __('Must not exceed :max.', ':max കവിയാൻ പാടില്ല.', ['max' => $max]));
                    }
                } elseif (mb_strlen((string)$value) > $max) {
                    $this->addError($field, __('Must not exceed :max characters.', ':max അക്ഷരങ്ങളിൽ കൂടരുത്.', ['max' => $max]));
                }
                break;

            case 'in':
                if (!in_array((string)$value, $params, true)) {
                    $this->addError($field, __('The selected value is invalid.', 'തിരഞ്ഞെടുത്ത മൂല്യം അസാധുവാണ്.'));
                }
                break;

            case 'honeypot':
                // Anti-spam field: must remain empty
                if (!empty($value)) {
                    $this->addError($field, 'Spam detected.');
                }
                break;
        }
    }

    private function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = $message;
        }
    }

    private function formatFieldName(string $field): string
    {
        return ucwords(str_replace(['_', '-'], ' ', $field));
    }

    public function passes(): bool
    {
        return count($this->errors) === 0;
    }

    public function fails(): bool
    {
        return count($this->errors) > 0;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function firstError(): ?string
    {
        return reset($this->errors) ?: null;
    }

    public function validated(): array
    {
        return $this->validated;
    }
}
