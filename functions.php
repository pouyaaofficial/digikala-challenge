<?php

function setArticleIdAsArrayKey($articles)
{
    $arr = [];
    foreach ($articles as $value) {
        $arr[$value['id']] = $value;
    }
    return $arr;
}

function setProductNameAsArrayKey($products)
{
    $arr = [];
    foreach ($products as $value) {
        $arr[$value['name']] = $value;
    }
    return $arr;
}

function calculateProductsProfits($products, $articles)
{
    $profits = [];

    foreach ($products as $product) {
        $minProduction = getMaxProductInventory($product, $articles);

        $profits[] = [
          'name' => $product['name'],
          'profit' => $minProduction * $product['price'],
          'quantity' => $minProduction,
        ];
    }

    return $profits;
}

function decrementInventory($profits, $products, &$articles)
{
    $result = [];

    foreach ($profits as $profit) {
        $product = $products[$profit['name']];
        $maxProductInventory = getMaxProductInventory($product, $articles);

        if ($maxProductInventory == 0) {
            continue;
        }
        
        $result[] = [
          'name' => $product['name'],
          'quantity' => $maxProductInventory,
          'profit' => $product['price'] * $maxProductInventory,
        ];

        foreach ($product['articles'] as &$article) {
            $articles[$article['id']]['stock'] -= $article['amount'] * $maxProductInventory;
        }
    }

    return $result;
}

function getMaxProductInventory($product, $articles)
{
    $minProduction = PHP_INT_MAX;

    foreach ($product['articles'] as $article) {
        $maxProductionWithArticle = floor($articles[$article['id']]['stock'] / $article['amount']);
        $minProduction = min($minProduction, $maxProductionWithArticle);
    }
    
    return $minProduction;
}
