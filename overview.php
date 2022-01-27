<?php

    require_once ("config/config.php");

    include_once INC . "/header.php";

    /* SQL for drinks */
    $getDrinkItemsWhere = $Database->Select(
        "SELECT 
            cu.name, 
            cu.email, 
            cu.phone, 
            o.id AS orderid, 
            o.reservation_id, 
            o.quantity, 
            o.status, 
            m.name AS menuname, 
            t.name AS typename, 
            c.name AS categoryname 
        FROM orders AS o 
            LEFT JOIN menu AS m 
        ON o.menu_id = m.id
            LEFT JOIN type AS t 
        ON m.type_id = t.id 
            LEFT JOIN category AS c 
        ON t.category_id = c.id
            LEFT JOIN reservation AS r 
        ON o.reservation_id = r.id
            LEFT JOIN customers AS cu 
        ON r.customer_id = cu.id
            WHERE t.category_id = 1 #fixed category id, this is for drinks
    ");


    if ( isset($_GET['view']) && !empty($_GET['view']) ) 
    {
        switch ( $_GET['view'] ) {
            case 'barman':
                include_once VIEW . "/drink.php";
            break;   
            default:
                exit('<h1>No view found...</h1>');
            break;         
        }
    }
    else
    {
        exit('<h1>Something went wrong...</h1>');
    }

    include_once INC . "/footer.php";