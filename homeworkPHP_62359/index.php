<?php
include('Shop.php');


(new Shop())->addQuantity(1,1);
(new Shop())->buyProduct(3,1);
(new Shop())->addNewProduct('Алабала', 14);
(new Shop())->addNewProduct('Пола', 12);
