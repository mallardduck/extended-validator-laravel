<?php

namespace MallardDuck\ExtendedValidator;

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
                switch ($ruleType) {
                    case "rules":
                        $baseValidator->extend($rule->name, $rule->callback, $rule->message);
                        break;
                    case "implicit":
                        $baseValidator->extendImplicit($rule->name, $rule->callback, $rule->message);
                        break;
                    case "dependent":
                        $baseValidator->extendDependent($rule->name, $rule->callback, $rule->message);
                        break;
                }
                if (null !== $rule->resolver) {
                    $baseValidator->replacer($rule->name, $rule->resolver);
                }
            }
        }
    }
}
