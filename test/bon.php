<?php

require_once("includes/includes.php");
require_once(CLASSES_PATH . "table.inc.php");	

class clsPage extends clsDefaultPage
{
     protected function contentHtml() 
     {			
          $aBestelling = $this->getBestelling();
          $totaal = 0;
          $output = 
               "<center>
                     <button class='btn btn-primary hidden-print aria-hidden='true' 
                             onclick='window.print()'>
                          <span class='fa fa-print'></span>&nbsp;Print bon
                     </button>
                </center>
                <div id='bon_overzicht'>
                     <table id='bon'>
                          <thead>
                               <tr>
                                    <th>Product</th>
                                    <th>Aantal</th>
                                    <th>Prijs p/s</th>
                                    <th>Totaal</th>
                               </tr>
                          </thead>
                          <tbody>";
          
          foreach ($aBestelling as $key => $value) 
          {
                $output .= "   <tr>
                                    <td>" . $value['Naam'] . "</td>
                                    <td>" . $value['Aantal'] . "</td>
                                    <td>&euro;&nbsp;" . number_format($value['Prijs'], 2, ',','.') . "</td>
                                    <td>&euro;&nbsp;" . number_format($value['Aantal'] * 
                                                                      $value['Prijs'], 2, ',','.') . "</td>
                               </tr>";
                $totaal = $totaal + ($value['Aantal'] * $value['Prijs']);
          }
          $output .=          "<tr class='trBold'>
                                    <td>TOTAALPRIJS</td>
                                    <td colspan='3'>&euro;&nbsp;" . number_format($totaal, 2, ',','.') . "</td>
                               </tr>
                          </tbody>
                     </table>
                </div>";
          return $output;
     }	
     
     private function getBestelling() 
     {
          $reservering_id = $_GET['reservering'];
          $sql = "SELECT * FROM bestellingen b, menuitems m 
                   WHERE b.Reservering_ID = $reservering_id
                     AND b.Menuitem_ID = m.ID";
          foreach($this->connection->query($sql) as $row) 
          {
               $aOutput[] = $row;
          }
          return $aOutput;
     }
}
     $page = new clsPage();
	echo $page->getHtml();
?>