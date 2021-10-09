<?php

declare(strict_types=1);

namespace MallardDuck\ExtendedValidator;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;
use MallardDuck\ExtendedValidator\Rules\BaseRule;

final class ExtendedValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * @var Factory $baseValidator
         */
        $baseValidator = app('validator');
        foreach (RuleManager::allRules() as $ruleType => $rules) {
            foreach ($rules as $key => $rule) {
                /**
                 * @var BaseRule $rule
                 */
                $rule = new $rule();
                if ($ruleType === 'rules') {
                    $baseValidator->extend(
                        $rule->getName(),
                        $rule->getCallback(),
                        $rule->getMessage()
                    );
                }
                if ($ruleType === 'dependent') {
                    $baseValidator->extendDependent(
                        $rule->getName(),
                        $rule->getCallback(),
                        $rule->getMessage()
                    );
                }
                if ($rule->hasReplacer()) {
                    $baseValidator->replacer($rule->getName(), $rule->getReplacer());
                }
            }
        }
    }
}
