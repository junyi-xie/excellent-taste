<?php

    require_once ("config/config.php");

    include_once INC . "/header.php";

    // SQL to get all the corresponding data for each view
    $getAllReservations = $Database->Select(
        "SELECT 
            r.*, 
            c.*
        FROM reservation AS r 
            LEFT JOIN customers AS c 
        ON c.id = r.customer_id"
    );
        

    if ( isset($_GET['id']) && !empty($_GET['id']) )
    {
        $getReservationsWhere = $Database->Select(
            "SELECT 
                r.*, 
                c.*
            FROM reservation AS r 
                LEFT JOIN customers AS c 
            ON c.id = r.customer_id 
                WHERE r.id = :reservation_id
            ", [":reservation_id" => $_GET['id']], \PDO::FETCH_ASSOC, false, true
        );
        
        $getOrdersWhere = $Database->Select(
            "SELECT 
                o.id AS orderid, 
                o.reservation_id, 
                o.quantity, 
                o.status, 
                m.name AS menuname, 
                t.name AS typename, 
                c.name AS categoryname,
                cu.*
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
                WHERE o.reservation_id = :reservation_id
            ", [":reservation_id" => $_GET['id']]
        );
    }
    
    
    if ( !isset($_GET['action']) && !empty($getAllReservations) ) 
    {
        include_once VIEW . "/reservation.php";
    }
    else if ( isset($_GET['action']) && !empty($_GET['action'] && isset($_GET['id'])) )
    {
        switch ( $_GET['action'] ) {
            case 'edit':
                include_once VIEW . "/customer.php";
            break;
            case 'view':
                include_once VIEW . "/orders.php";
            break;
            default:
                exit('<h1>No view found...</h1>');
            break;     
        }
    }
    else
    {
        echo '<h1>Geen reserveringen gevonden...</h1>';
    }

    include_once INC . "/footer.php";