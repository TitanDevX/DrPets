<?php

return [
'roles' => [
  'admin' =>
 
  [
    'weight' => 100,
    'pet' => 'c,r,u,d', 
    'user' => 'c,r,u,d', 
    'role' => 'c,r,u,d', 
    'category' => 'c,r,u,d',
    'breed' => 'c,r,u,d',
    'order' => 'c,r,u,d',
    'invoice' => 'c,r,u,d',
    'product' => 'c,r,u,d', 
    'promocode' => 'c,r,u,d',
    'cart' => 'c,r,u,d',
    'ad' => 'c,r,u,d',
    'service' => 'c,r,u,d',
    'provider' => 'c,r,u,d',
    'chat' => 'c,r,u,d',
    'address' => 'c,r,u,d',
    'booking' => 'c,r,u,d',
    'rating' => 'c,r,u,d',
    'reminder' => 'c,r,u,d',
    'specific' => [
        'all',
        'dashboard.admin',
        'sitesettings.tax'
    ]
],
  

],
'mappings' =>
    [
        'c' => 'create',
        'r' => 'reterive',
        'u' => 'update',
        'd' => 'delete',
    ]
];

