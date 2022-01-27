<?php

    require_once ("config/config.php");

    include_once INC . "/header.php";


    /* catch the post data and save it in a session. */
    if ( !empty($_POST) ) 
    {
        if ( !empty($_POST['customer'])) 
        {
            saveInSession('customer', $_POST['customer']);
        } 
        elseif( !empty($_POST['reservation']))
        {
            saveInSession('reservation', $_POST['reservation']);
        }
        elseif ( !empty($_POST['orders']))
        {
            saveInSession('orders', $_POST['orders']);
        }
    }


    /* SQL to get all menu items as display it as result */
    $getAllMenuItems = $Database->Select(
        "SELECT 
            m.id, 
            m.name AS menuname, 
            t.name AS typename, 
            c.name AS categoryname 
        FROM menu AS m 
            LEFT JOIN type AS t 
        ON m.type_id = t.id 
            LEFT JOIN category AS c 
        ON t.category_id = c.id"
    );

    
    /* get the correct view page */
    if ( isset($_GET['view']) && !empty($_GET['view']) )
    {
        switch ( $_GET['view'] ) 
        {
            case 'reservation':
                include_once VIEW . "/contact.php";
            break;
            case 'order':
                include_once VIEW . "/items.php";
            break;
            case 'completed':
                
                if ( !empty($_SESSION['customer']) && !empty($_SESSION['reservation']) && !empty($_SESSION['orders']))
                {
                    $getInsertedCustomerId = $_SESSION['reservation']['customer_id'] = $Database->Insert("customers", $_SESSION['customer']);
                    $getInsertedReservationId = $Database->Insert("reservation", $_SESSION['reservation']);

                    if ( !empty($_SESSION['orders']) && is_array($_SESSION['orders']) && !is_null($getInsertedCustomerId) && !is_null($getInsertedReservationId) ) 
                    {
                        foreach ($_SESSION['orders'] as $key => $value) {
                            
                            /* skip loop if quantity is empty (not higher than 0) */
                            if (empty($value['quantity'])) continue;
            
                            $Database->Insert("orders", ["reservation_id" => $getInsertedReservationId,"menu_id" => $key,"quantity" => $value['quantity'],"status" => "0"]);                    
                        }
                    }

                    /* clear all sessions. */
                    session_destroy();
                   
                    include_once VIEW . "/checkout.php";                   
                }
                else
                {
                    exit('<h1>You cannot access this page...</h1>');
                }

            break;
            default:
                exit('<h1>No view found...</h1>');
            break;     
        }
    }
    else
    {
        include_once VIEW . "/form.php";
    }    

    include_once INC . "/footer.php";