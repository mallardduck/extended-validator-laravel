<?php

namespace MallardDuck\OpinionatedValidator;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator;

class OpinionatedValidatorServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // TODO: Abstract all the things here to a cleaner and more DRY form.
        $baseValidator = app('validator');
        // Add UnfilledIf rule
        $baseValidator->extendDependent(
            'unfilled_if',
            function (
                string $attribute,
                $value,
                $parameters,
                Validator $validator
            ) {
                $validator->requireParameterCount(1, $parameters, 'unfilled_if');

                [$values, $other] = $validator->prepareValuesAndOther($parameters);

                if (in_array($other, $values)) {
                    return ! $validator->validateRequired($attribute, $value);
                }

                return true;
            }
        );
        // TODO: See about hijacking the internal replacers.
        $baseValidator->replacer(
            'unfilled_if',
            function (
                $stringTemplate,
                $currentField,
                $rule,
                $ruleArgs,
                $validator
            ) {
                [$other, $value] = $ruleArgs;
                $results = Str::replaceFirst(':other', $other, $stringTemplate);
                $results = Str::replaceFirst(':value', $value, $results);

                return $results;
            }
        );

        // Add UnfilledWith rule
        $baseValidator->extendDependent(
            ($ruleName = 'unfilled_with'),
            static function (
                string $attribute,
                $value,
                $parameters,
                Validator $validator
            ) use ($ruleName) {
                $validator->requireParameterCount(1, $parameters, $ruleName);

                $validatorProxy = ValidatorProxy::setValidator($validator);

                if (! $validatorProxy->allFailingRequired($parameters)) {
                    return false;
                }

                return true;
            }
        );
        // TODO: See about hijacking the internal replacers.
        $baseValidator->replacer(
            'unfilled_with',
            function (
                $stringTemplate,
                $currentField,
                $rule,
                $ruleArgs,
                $validator
            ) {
                $values = implode('/', $ruleArgs);
                return Str::replaceFirst(':values', $values, $stringTemplate);
            }
        );
    }
}
