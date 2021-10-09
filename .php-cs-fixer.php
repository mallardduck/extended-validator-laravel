<?php

$finder = PhpCsFixer\Finder::create()
    ->notPath('vendor')
    ->in(__DIR__)
    ->name("*.php")
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
;

return (new \PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        //'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sortAlgorithm' => 'alpha'],
        'no_unused_imports' => true,
        'lineLimit' => 120,
    ])
    ->setFinder($finder);