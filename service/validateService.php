<?php

namespace blog\service;

use blog\Exceptions\Exception;

class validateService { // injection de dépendance
    
    public function formValidate(array $formData, array $rules) {
        try {
            foreach ($rules as $fieldName => $fieldRules) {
                if (isset($formData[$fieldName])) {
                    $fieldToConfirm = isset($fieldRules['fieldToConfirm']) ? $fieldRules['fieldToConfirm'] : false;
    
                    self::applyRule($formData, $fieldName, $fieldRules['type'], $fieldRules['message'], $fieldToConfirm);
                }
            }

            return true;
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    private static function applyRule(array $formData, $fieldName, $type, $message, $fieldToConfirm = false) {
            try {
                match ($type) { 
                    'required' => self::validateField($formData, $fieldName, $message),
                    'email' => self::validateEmail($formData, $fieldName, $message),
                    'confirm_password' => self::confirmPasswordMatch($formData, $fieldToConfirm, $message),
                    default => throw new Exception("Règle invalide pour le champ $fieldName")
                };
            } 
            catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
    }

    private static function validateField(array $formData, $fieldName, $errorMessage) {
        try {
            if (empty($formData[$fieldName])) {
                throw new Exception($errorMessage);
            }
        } 
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private static function validateEmail(array $formData, $fieldName, $errorMessage) {
        try {
            self::validateField($formData, $fieldName, $errorMessage);

            if (!preg_match("#^[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?@[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?\.[a-z]{2,}$#i", $formData[$fieldName])) {
                throw new Exception($errorMessage);
            }
        } 
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private static function confirmPasswordMatch(array $formData, $fieldToConfirm, $errorMessage) {
        try {
            if ($formData[$fieldToConfirm] !== $formData['confirm_password']) {
                throw new Exception($errorMessage);
            }
        } 
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}


