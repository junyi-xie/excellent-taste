<?php

    require_once ("config/config.php");

    if ( isset($_GET['action']) && !empty($_GET['action']) )
    {
        switch ($_GET['action']) 
        {
           case 'edit':

                if ( !empty($_POST['customer']) && !empty($_POST['reservation'])) 
                {
                    $Database->Update("customers", $_POST['customer'], "id = '".$_POST['customer_id']. "'");
                    $Database->Update("reservation", $_POST['reservation'],  "id = '".$_POST['reservation_id']. "'");
                }

            break;
            case 'approve':

                if ( isset($_GET['type']) && $_GET['type'] == 'orders' ) 
                {
                    if ( empty($_GET['reservation_id'] || empty($_GET['order_id'])) ) die('<h1>Something went wrong...</h1>');

                    $Database->Update("reservation", ['status' => 1], "id = '".$_GET['reservation_id']. "'");
                    $Database->Update("orders", ['status' => 1], "id = '".$_GET['order_id']. "'");
                }

            break;
            case 'delete':

                if ( !empty($_GET['id']) ) 
                {
                    $Database->Delete("reservation", "id = '".$_GET['id']. "'");
                }

            break;
            case 'print':
                       
                if ( isset($_GET['type']) && !empty($_GET['type']) ) {

                    switch ($_GET['type']) {
                        case 'download':
                            printInvoice();
                        break;
                        case 'read':
                            printInvoice(false);
                        break;
                    }
                }

            break;
            default:
                exit('<h1>Nono!</h1>');
            break;
        }

        /* Redirect back to the page this was called upon */
        header("location: " . $_GET['uri']);
        exit();
    }