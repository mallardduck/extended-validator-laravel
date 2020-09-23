<?php

namespace MallardDuck\UnfilledValidator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;

class UnfilledValidatorServiceProvider extends ServiceProvider
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
                $rule = new $rule();
                if ('rules' === $ruleType) {
                    $baseValidator->extend($rule->name, $rule->callback);
                }
                if ('implicit' === $ruleType) {
                    $baseValidator->extendImplicit($rule->name, $rule->callback);
                }
                if ('dependent' === $ruleType) {
                    $baseValidator->extendDependent($rule->name, $rule->callback);
                }
                $baseValidator->replacer($rule->name, $rule->resolver);
            }
        }
    }
}
