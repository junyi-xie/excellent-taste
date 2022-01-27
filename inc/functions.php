<?php

    /* Include the main TCPDF library */
    require_once LIB . "/TCPDF/tcpdf.php";


    /**
     * print_r but fancier.
     *
     * @param mixed $arr
     *
     * @return void
     */
    function printr($arr) {
        print '<code><pre style="text-align: left; margin: 10px;">'.print_r($arr, TRUE).'</pre></code>';
    }


    /**
     * Save value in session.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return bool
     */
    function saveInSession($key, $value) {

        if ( empty($key) && empty($value) ) 
        {
            return false;
        }

        $_SESSION[$key] = $value;

        return true;
    }


    /**
     * Print invoice with TCPDF library.
     * 
     * @param bool $print
     * @param string $html
     *
     * @return void
     */
    function printInvoice($print = true, $html = '') {
        global $Database;

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Junyi Xie');
        $pdf->SetTitle('Excellent Taste Backup');
        $pdf->SetSubject('Excellent Taste Invoice');
        $pdf->SetKeywords('Excellent Taste, invoice, backup, pdf');

        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set font
        $pdf->SetFont('times', 'BI', 20);

        // add a page
        $pdf->AddPage();

        // create pre-made template
        if ( empty($html) ) 
        {        
            // Select all available data from database
            $InvoiceData = $Database->Select(
                "SELECT 
                    c.name AS categoryname, 
                    t.name AS typename, 
                    m.name AS menuname, 
                    o.quantity AS orderquantity,
                    cu.*,
                    r.*
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

            // fill in template
            $html .= '<h1>Welkom bij Excellent Taste, hier is je bon:</h1><br/>';
            $html .= '<h2>Je gegevens</h2><br/>';
            $html .= 'Naam: ' .$InvoiceData[0]['name'] . '<br/>';
            $html .= 'Email: ' . $InvoiceData[0]['email'] . '<br/>';
            $html .= 'Telefoonnr: '. $InvoiceData[0]['phone'] . '<br/>';
            $html .= 'Straatnaam: '. $InvoiceData[0]['street'] . '<br/>';
            $html .= 'Husnummer: '. $InvoiceData[0]['house_number'] . '<br/>';
            $html .= 'Extra toevoeging: '. $InvoiceData[0]['house_extra'] . '<br/>';
            $html .= 'Postcode: '. $InvoiceData[0]['zipcode'] . '<br/>';
            $html .= 'Woonplaats: '. $InvoiceData[0]['place'] . '<br/>';
            $html .= 'Land: '. $InvoiceData[0]['country'] . '<br/>';

            $html .= '<h2>Je reservering</h2><br/>';
            $html .= 'Tafel nummer: ' . $InvoiceData[0]['table_number'] . '<br/>';
            $html .= 'Aantal personen: ' . $InvoiceData[0]['quantity']. '<br/>';
            $html .= 'Aantal kinderen: ' . $InvoiceData[0]['quantity_kids'] . '<br/>';
            $html .= 'Datum en tijdstip: ' . date("M j, Y", strtotime($InvoiceData[0]['date'])) . ' - ' . date("g:i A", strtotime($InvoiceData[0]['time'])) . '<br/>';
            $html .= 'Alergien: ' . $InvoiceData[0]['allergens'] . '<br/>';
            $html .= 'Opmerking: ' . $InvoiceData[0]['notes'] . '<br/>';

            $html .= '<h2>Je bestellingen</h2><br/>';

            if ( !empty($InvoiceData) && is_array($InvoiceData) ) 
            {
                foreach ($InvoiceData as $item) {
                    $html .= $item['menuname'] . ' (' . $item['categoryname'] . ' - ' . $item['typename'] . ')' . ' -- ' .  $item['orderquantity'] .'x<br/>';
                }
            }

            // fixed price
            $html .= 'Totaalprijs: &euro; 10.00,-<br/>';
            $html .= '<br/><br/>Tot ziens!<br/><br/><br/>- Team Excellent Taste';
        }

        // print a block of text using Write()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        // Close and output PDF document
        if ( $print && ob_end_clean() ) 
        {
            $pdf->Output('invoice_excellent_taste.pdf', 'D');
        }
        else
        {
            $pdf->Output('invoice_excellent_taste.pdf', 'I');
        }
    }