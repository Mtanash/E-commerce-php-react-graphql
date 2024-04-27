<?php

use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use queries\Product as ProductQuery;
use queries\Products as ProductsQuery;
use queries\Categories as CategoriesQuery;
use queries\Category as CategoryQuery;
use mutations\Order as OrderMutation;

return new Schema([
  'query' => new ObjectType([
    'name' => 'Query',
    'fields' => [
      'product' => ProductQuery::get(),
      'products' => ProductsQuery::get(),
      'category' => CategoryQuery::get(),
      'categories' => CategoriesQuery::get(),
    ]
  ]),
  'mutation' => new ObjectType([
    'name' => 'Mutation',
    'fields' => [
      'createOrder' => OrderMutation::get()
    ]
  ])
]);
