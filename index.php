<?php

require_once 'functions.php';

// Load Products to Program
$productsJson = file_get_contents(getcwd() . "/assets/data/products.json");
$products = json_decode($productsJson, true);
$products = setProductNameAsArrayKey($products['products']);

// Load Articles to Program
$articlesJson = file_get_contents(getcwd() . "/assets/data/articles.json");
$articles = json_decode($articlesJson, true);
$articles = setArticleIdAsArrayKey($articles['articles']);

// Rating products based oh their profit
$profits = calculateProductsProfits($products, $articles);
usort($profits, fn ($a, $b) => $b['profit'] - $a['profit']);
$result = decrementInventory($profits, $products, $articles);

// print final result
print_r($result);
print_r($articles);
