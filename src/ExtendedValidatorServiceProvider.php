<?php

namespace MallardDuck\ExtendedValidator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;
use MallardDuck\ExtendedValidator\Rules\BaseRule;

final class ExtendedValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var Factory $baseValidator */
        $baseValidator = app('validator');
        foreach (RuleManager::allRules() as $ruleType => $rules) {
            foreach ($rules as $key => $rule) {
                /** @var BaseRule $rule */
                $rule = new $rule();
                if ('rules' === $ruleType) {
                    $baseValidator->extend($rule->getName(), $rule->callback, $rule->message);
                }
                if ('dependent' === $ruleType) {
                    $baseValidator->extendDependent($rule->getName(), $rule->callback, $rule->message);
                }
                if (is_callable($rule->replacer)) {
                    $baseValidator->replacer($rule->getName(), $rule->replacer);
                }
            }
        }
    }
}
