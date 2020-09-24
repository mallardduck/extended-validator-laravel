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
                switch ($ruleType) {
                    case "rules":
                        $baseValidator->extend($rule->name, $rule->callback);
                        break;
                    case "implicit":
                        $baseValidator->extendImplicit($rule->name, $rule->callback);
                        break;
                    case "dependent":
                        $baseValidator->extendDependent($rule->name, $rule->callback);
                        break;
                }
                $baseValidator->replacer($rule->name, $rule->resolver);
            }
        }
    }
}
