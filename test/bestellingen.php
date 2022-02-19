<?php
require_once("includes/includes.php");
require_once(CLASSES_PATH . "table.inc.php");	

class clsBestelling 
{
     public function __construct() 
     {
          $this->connection = database::connect();
     }
     
     public function getBestelling() 
     {
          if (isset($_GET['reservering'])) 
          {
               $_SESSION['bestellingen']['reserverings_id'] = $_GET['reservering'];
          }
          if (isset($_GET['action'])) 
          {
               $action = $_GET['action'];
               switch($action) 
               {
                    case "plusitem"	: $this->plusitem(); break;
                    case "minitem"		: $this->minitem(); break;
                    case "deleteitem"	: $this->deleteitem(); break;
               }
               
          }
          
          if (isset($_SESSION['bestellingen']['reserverings_id']))
          {
               if ($_SESSION['bestellingen']['reserverings_id'] > 0) 
               {
                    $tafelnummer = $this->getTafelnummer();
                    return $tafelnummer . $this->currentBestelling();
               }
          }
     }
     
     protected function getTafelnummer() 
     {
          if (Isset($_GET['tafelnummer'])) 
          {
               if ($_GET['tafelnummer'] > 0) 
               {
                    $_SESSION['bestellingen']['tafelnummer'] = $_GET['tafelnummer'];
               }
          }
          $output = "Neem bestelling op voor tafel " . $_SESSION['bestellingen']['tafelnummer'];
          return $output;
     }
     
     private function getCurrentAantal() 
     {
          $reservering_id 	= $_GET['reservering'];
          $menuitemid 		= $_GET['menuitemid'];
          $sql 			= "SELECT Aantal FROM bestellingen 
                                 WHERE Reservering_ID = $reservering_id 
                                   AND MenuItem_ID = '$menuitemid'";
                              
          $stmt			= $this->connection->prepare($sql); 
          $stmt->execute(); 
          $row 		     = $stmt->fetch();												
          $aantal 			= $row['Aantal'];
          return $aantal;
     }
     
     
     private function plusitem() 
     {
          $reservering_id = $_GET['reservering'];
          $menuitemid = $_GET['menuitemid'];
                         
          $aantal = $this->getCurrentAantal();
          $aantal++;
          
          $sql = "UPDATE bestellingen SET aantal = $aantal 
                  WHERE Reservering_ID = $reservering_id 
                    AND Menuitem_ID = '$menuitemid'";
          if ($this->connection->query($sql) == true) 
          {
               return;
          } 
     }
     
     private function minitem() 
     {
          $reservering_id = $_GET['reservering'];
          $menuitemid = $_GET['menuitemid'];
                         
          $aantal = $this->getCurrentAantal();
          if ($aantal > 1) 
          {
               $aantal--;
          } 
          
          $sql = "UPDATE bestellingen SET Aantal = $aantal 
                  WHERE Reservering_ID = $reservering_id 
                    AND Menuitem_ID = '$menuitemid'";
          if ($this->connection->query($sql) == true) 
          {
               return;
          } 
          else 
          {
               print $sql . " Mislukt"; die;
          }			
     }
     
     private function deleteitem() 
     {
          $reservering_id = $_GET['reservering'];
          $menuitemid = $_GET['menuitemid'];
          
          $sql = "DELETE FROM bestellingen 
                   WHERE reservering_id = $reservering_id 
                     AND Menuitem_ID = " . $menuitemid . "
                   LIMIT 1";
          if ($this->connection->query($sql) == true) 
          {
               return;
          } 
          else 
          {
               print $sql . " Mislukt"; die;
          }
     }
     
     
     private function currentBestelling() 
     {
          $reserveringsID = $_SESSION['bestellingen']['reserverings_id'];
          
          $sql = "SELECT * FROM bestellingen b
                           LEFT JOIN menuitems m
                           ON b.Menuitem_ID = m.ID
                   WHERE b.Reservering_ID = $reserveringsID";

          $output = "
               <table>
                    <thead>
                         <tr>
                              <th>Menuitem</th>
                              <th>#</th>
                         </tr>
                    </thead>
                    <tbody>";
                    foreach ($this->connection->query($sql) as $row) 
                    {
                         $menuitemid = $row['Menuitem_ID'];
                         $output .= "
                         <tr>
                              <td>" . $row['Naam'] . "</td>
                              <td>" . $row['Aantal'] . "</td>
                              <td>
                                   <a href='bestellingen.php?action=plusitem&menuitemid=" . $menuitemid .
                                                           "&reservering=$reserveringsID'>
                                        <i class='fa fa-plus-circle' aria-hidden='true'></i>
                                   </a>
                              </td>
                              <td>
                                   <a href='bestellingen.php?action=minitem&menuitemid=" . $menuitemid .
                                                           "&reservering=$reserveringsID'>
                                        <i class='fa fa-minus-circle' aria-hidden='true'></i>
                                   </a>
                              </td>
                              <td>
                                   <a href='bestellingen.php?action=deleteitem&menuitemid=" . $menuitemid .
                                                           "&reservering=$reserveringsID'>
                                        <i class='fa fa-trash-o' aria-hidden='true'></i>
                                   </a>
                              </td>
                         </tr>";
                    }
          $output .= "
                    </tbody>
               </table>
               <br />
               <a href='bon.php?reservering=$reserveringsID' 
                  class='btn btn-default "; 
         $output .= 
               "' target='_blank'>Print bon voor klant
               </a>";
          return $output;        
     }
}	


class clsPage extends clsDefaultPage
{
     
     public function contentHtml() 
     {
          if (isset($_GET['action'])) 
          {
               if ($_GET['action'] == "nieuw") 
               {
                    $_SESSION['bestellingen']['tafelnummer'] = '-1';
                    header("Location: bestellingen.php");
               }
               
               if ($_GET['action'] == "add") 
               {
                    $this->save();
                    header("Location: bestellingen.php");				
               }
          }
          $bestelling = new clsBestelling;
          $output = '
               <div class="col-xs-6 col-sm-6 col-lg-6">' .
               $bestelling->getBestelling() .
              '</div>
               <div class="col-xs-6 col-sm-6 col-lg-6">' .
                    $this->getGerecht() .
              '</div>';
          return $output;
     }
     
     protected function getMenuitem($menuitemid) 
     {
          $sql = "SELECT * 
                    FROM menuitems 
                   WHERE ID = " . $menuitemid;
          foreach ($this->connection->query($sql) as $row) 
          {
               $aOutput = $row;
          }
          return $aOutput;
     }
     
     
     protected function save() 
     {
          // insert one row
          $reservering_id	= $_SESSION['bestellingen']['reserveringsnummer'];
          $menuitemid 		= $_GET['menuitemid'];
          $aMenuitem 		= $this->getMenuitem($menuitemid);
          $aantal 			= 1; 
          $prijs 			= $aMenuitem['Prijs'];
          
          $sql = "INSERT INTO bestellingen 
                              (Reservering_ID, Menuitem_ID, Aantal) 
                       VALUES ($reservering_id, $menuitemid, $aantal)";
                         
          if (!($this->connection->query($sql) == true)) 
		{    print $sql . " Mislukt"; 
		     die;
		}							
     }
     
     protected function getGerecht() 
     {
          $output = "";
          //CATEGORIE
          foreach($this->connection->query('SELECT * 
                                              FROM gerechtcategorien
                                             ORDER BY Naam') as $rowcategorie) 
          {    $cat = preg_replace('/\s+/', '', $rowcategorie['Naam']); // Spaties e.d. eruit filteren
               $output .= 
                   '<div class="panel-group">
                         <div class="panel panel-default">
                              <div class="panel-heading">
                                   <h3 class="panel-title">
                                        <a data-toggle="collapse" href="#c' . $cat . '">' . $rowcategorie['Naam'] . '</a>
                                   </h3>
                              </div>
                              <div id="c' . $cat . '" class="panel-collapse collapse">';
              //SOORT
              foreach ($this->connection->query("SELECT * 
                                                   FROM gerechtsoorten 
                                                  WHERE Gerechtcategorie_ID = " . $rowcategorie['ID'] . "
                                                  ORDER BY Naam") as $rowsoort) 
              {    $soort = preg_replace('/\s+/', '', $rowsoort['Naam']); // Spaties e.d. eruit filteren
                   $output .= '    <div class="panel-group" style="margin:0; margin-left:20px">
                                        <div class="panel panel-default">
                                             <div class="panel-heading">
                                                  <h4 class="panel-title">
                                                       <a data-toggle="collapse" href="#s' . $soort . '">' . $rowsoort['Naam'] . '</a>
                                                  </h4>
                                             </div>
                                        </div>
                                        <div id="s' . $soort . '" class="panel-collapse collapse">';
                         
                   //MENUITEM
                   foreach ($this->connection->query("SELECT * 
                                                        FROM menuitems
                                                       WHERE Gerechtsoort_ID = " . $rowsoort['ID'] . "
                                                       ORDER BY Naam") as $rowmenuitem) 
                   {    $output .= "         <h5 class='panel-body' style='margin-left:20px'>
                                                  <a href='?action=add&menuitemid=" . $rowmenuitem['ID'] ."'>"
                                                     . $rowmenuitem['Naam'] . "
                                                  </a>
                                             </h5>";
                   }
                   $output .= "              
                                        </div>
                                   </div>"; 
              } 
              $output .= "    </div>
                         </div>
                    </div>"; 
          }
          return $output;
     }
}
     
$page = new clsPage();
echo $page->getHtml();

?>