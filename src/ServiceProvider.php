<?php

namespace BBIT;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    public function boot(): void
    {
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ]);

        Validator::extend('email_format', function ($attribute, $value, $parameters, $validator) {
            $rules = [
                function ($attribute, $value, $fail) {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail("Please enter valid $attribute");
                    }
                },
            ];

            $tempValidator = Validator::make(['email_field' => $value], [
                'email_field' => $rules,
            ]);

            if ($tempValidator->fails()) {
                // Add a custom error message dynamically
                foreach ($tempValidator->errors()->all() as $error) {
                    $validator->errors()->add($attribute, $error);
                }
            }
            return $validator;
        });

        if (config('validation.string_max_default')) {
            Schema::defaultStringLength(config('validation.string_max_default'));
            
            // Register custom validation rule to validate max default string length
            Validator::extend('string_max_default', function ($attribute, $value, $parameters, $validator) {
                $maxLength = config('validation.string_max_default'); // Get the max length from config
                return is_string($value) && mb_strlen($value) <= $maxLength;
            });

            Validator::replacer('string_max_default', function ($message, $attribute, $rule, $parameters) {
                $maxLength = config('validation.string_max_default');
                return str_replace(':attribute', $attribute, "The $attribute may not be greater than $maxLength characters.");
            });
        }
    }

    public function register(): void
    {
        // Register bindings or configs here
    }
}
