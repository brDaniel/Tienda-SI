<?php

use Leaf\Router;

require __DIR__.'/vendor/autoload.php';
Router::setNamespace('\App\Controllers');
Router::resource('/categories','CategoryController');
Router::resource('/supliers','SuplierController');
Router::resource('/employees', 'EmployeesControler');
Router::resource('/products','ProductController');
Router::resource('/sales','SaleController');


Router::run();
?>