<?php

require_once("includes/includes.php");
require_once(CLASSES_PATH . "table.inc.php");	

class clsPage extends clsDefaultPage
{
     protected function contentHtml() 
     {			
          if (isset($_GET['action'])) 
          {
               $action = $_GET['action'];
               switch($action) 
               {
                    case "add":       $output = $this->add(); break;
                    case "edit":      $output = $this->edit(); break;
                    case "save":      $output = $this->save(); break;
                    case "delete":    $output = $this->delete(); break;
                    case "bestellen": $output = $this->bestellen(); break;
               }
          } 
          else 
          {
               $output = $this->getReserveringen();
          }
          return $output;
     }
     
     private function add() 
     {    $klantId = -1;
          if (isset($_POST['inputklanten'])) 
          {
               $klantId = $_POST['inputklanten'];
          }
          $row = $this->getKlantVars($klantId); 
          $rowreservering = $this->getReserveringVars(-1);
          $row = array_merge($row, $rowreservering);

          $output = "
               <form action='?action=add' method='post' enctype='multipart/form-data'>

                    <label>Selecteer klant
                    </label>
                    
                    <select id='inputklanten' name='inputklanten'>" .
                         $this->getKlanten() . "                         
                    </select> 
                     
                    <input type='submit' name='submit_klantselecteren' 
                           id='submit_klantselecteren' value='Selecteer klant'/>
               </form>" . $this->showReserveringForm($row);
          
          return $output;	
     }
     
     protected function edit()
     {
          $reserveringId = -1;
          if (isset($_GET['reservering'])) 
          {
               $reserveringId = $_GET['reservering'];
          }
          
          $row = $this->getReserveringVars($reserveringId); 
          $klantId = $row['Klant_ID'];
          $rowklant = $this->getKlantVars($klantId); 
          $row = array_merge($row, $rowklant);
          
          $output = $this->showReserveringForm($row);
         
          return $output;
     }
     
     private function save() 
     {
          $tafel  = $_POST['tafelnummer'];
          $datum  = $_POST['reserveringsdatum'];         
          $tijd   = $_POST['reserveringstijd'];
          $aantal = $_POST['aantal'];
          
          $reservering_id = -1;
          if (isset($_POST['reserveringId'])) 
          {
               $reservering_id = $_POST['reserveringId'];
          }
          //check of de klant nieuw is of al bestaat	
          $klant_id	= $this->saveNewCustomer($_POST['klantId']);
          //de datum moet omgedraaid worden voordat die opgeslagen wordt
          $datum  = $this->convertDateSQLFormat($datum, -1);
                    
          if ($reservering_id < 0)
          {
               $sql = "INSERT INTO reserveringen 
                                   (Tafel, Datum, Tijd, Klant_ID, Aantal) 
                                   VALUES 
                                   ($tafel, '$datum', '$tijd', $klant_id, $aantal)"; 
          }
          else
          {
               $sql = "UPDATE reserveringen  
                          SET Tafel = $tafel, Datum = '$datum', Tijd = '$tijd', Aantal = $aantal
                        WHERE ID = $reservering_id"; 
          }
          if ($this->connection->query($sql) == true) 
          {    header("Location: reserveringen.php");
		} 
		else 
		{    print $sql . " Mislukt"; die;
		}							
     }   

     protected function delete() 
     {
          $reservering_id = -1;
          if (isset($_GET['reservering'])) 
          {
               $reservering_id = $_GET['reservering'];
          }
         
          $sql = "DELETE FROM reserveringen  
                   WHERE ID = $reservering_id
                   LIMIT 1";
          if ($this->connection->query($sql) == true) 
          {    header("Location: reserveringen.php");
		} 
     }
     
     protected function bestellen() 
     {
          if(isset($_GET['reservering'])) 
          {
               if($_GET['reservering'] > 0) 
               {
                    $reserveringsnummer = $_GET['reservering'];
                    $_SESSION['bestellingen']['reserveringsnummer'] = $reserveringsnummer;
                    
                    $sql = "SELECT Tafel FROM reserveringen 
                                   WHERE ID = '$reserveringsnummer'";

                    foreach($this->connection->query($sql) as $row) 
                    {
                         $_SESSION['bestellingen']['tafelnummer'] = $row['Tafel'];
                    }
                    header("Location: bestellingen.php?reservering=$reserveringsnummer");
               }
          }
     }
     
     private function getKlanten() 
     {
          $sql = "  SELECT ID, Naam FROM klanten
                  ORDER BY Naam";
          $output = "<option id='-1' value='-1'>--Nieuwe klant--</option>";
          foreach($this->connection->query($sql) as $row) 
          {
               $output .= "<option id='" . $row['ID'] . "' value='" . 
                          $row['ID'] . "'> " . $row['Naam'] ."</option>";
          }
          return $output;
     }
     
     private function getKlantVars($klantId) 
     {
          if ($klantId > -1)
          {
               $sql = "SELECT ID AS KID, Naam, Email, Telefoon 
                         FROM klanten
                        WHERE ID = " . $klantId; 
               $stmt = $this->connection->prepare($sql); 
               $stmt->execute(); 
               $row	= $stmt->fetch();												
          }
          else
          {    // Nieuwe klant
               $row['Naam']        = "";
               $row['Email']       = "";
               $row['KID']         = -1;
               $row['Telefoon']	= "";
          }
          return $row;			
     }
     
     private function getReserveringVars($reserveringId) 
     {
          if ($reserveringId > -1)
          {
               $sql = "SELECT ID AS RID, Tafel, Datum, Tijd, Klant_ID, Aantal 
                        FROM reserveringen
                       WHERE ID = $reserveringId 
                         AND Status = 1";  

               $stmt = $this->connection->prepare($sql); 
               $stmt->execute(); 
               $row	= $stmt->fetch();
               $row['Datum'] = $this->convertDateSQLFormat($row['Datum'], 1);
               $d = date_create("10-10-2010 " . $row['Tijd']);               
               $row['Tijd'] = date_format($d,"H:i");
          }
          else
          {    // Nieuwe reservering
               $row['RID']            = -1;
               $row['Datum']	        = "";     
               $row['Tijd']	        = "";
               $row['Tafel']	        = "";
               $row['Aantal']	        = "";
          }
          return $row;			
     }   
     
     private function showReserveringForm($row)
     {    $dis_html = "disabled";
          if ($row['RID'] < 0)
          {
               $dis_html = "";
          }
          $output = "
               <form action='?action=save' method='post' enctype='multipart/form-data'>
                    <input type='hidden' name='klantId' id='klantId' value='" . $row['KID'] . "' />
                    <input type='hidden' name='reserveringId' id='reserveringId' value='" . $row['RID'] . "' />
                    
                    <label>Klantnaam</label>
                    <input type='text' name='klantnaam' id='klantnaam' $dis_html value='" . $row['Naam'] . "' />
                    
                    <label>E-mailadres klant</label>
                    <input type='email' name='email' id='email' $dis_html value='" . $row['Email'] . "'/>
                    
                    <label>Telefoonnummer klant</label>
                    <input type='text' name='telefoon' id='telefoon' $dis_html value='" . $row['Telefoon'] . "'/>
                    
                    <label>Reserveringsdatum (dd-mm-jjjj)</label>
                    <input type='text' name='reserveringsdatum' id='reserveringsdatum' value='" . $row['Datum'] . "' />
                    
                    <label>Reserveringstijd (uu:mm)</label>
                    <input type='text' name='reserveringstijd' id='reserveringstijd' value='" . $row['Tijd'] . "' />
                    
                    <label>Tafelnummer</label>
                    <input type='number' name='tafelnummer' id='tafelnummer' min='1' max='10' value='" . $row['Tafel'] . "' />
                    
                    <label>Aantal personen</label> 
                    <input type='text' name='aantal' id='aantal' value='" . $row['Aantal'] . "' />
                    
                    <label></label>
                    <input type='submit' name='submit' id='submit' value='Opslaan' />
               </form>";

          return $output;
     }
     
     private function saveNewCustomer($klant_id) 
     {
          $id = $klant_id;
          if ($id < 0)
          {    //save customer first and return klant_id
               $klantnaam 	= $_POST['klantnaam'];
               $email 		= $_POST['email'];
               $telefoon	     = $_POST['telefoon'];
               
               $sql = "INSERT INTO klanten 
                                   (Naam, Email, Telefoon) 
                              VALUES 
                                   (:klantnaam, :email, :telefoon)";
                    
               $stmt = $this->connection->prepare($sql);
               $stmt->bindParam(':klantnaam', $klantnaam);
               $stmt->bindParam(':email', $email);
               $stmt->bindParam(':telefoon', $telefoon); 

               $stmt->execute();
               $id = $this->connection->lastInsertId();
               
          }
          return $id; //if not new saved klant, then return existed klant_id
     }
     
     private function convertDateSQLFormat($datum, $toSQL) 
     {
          if ($toSQL < 0)
          {
               // 15-02-2017 to 2017-02-15
               $dag 	= substr($datum, 0, 2);
               $maand 	= substr($datum, 3, 2);
               $jaar	= substr($datum, 6, 4);  
               $output = $jaar . "-" . $maand . "-" . $dag; 
          }
          else
          {
               // 2017-02-15 to 15-02-2017
               $jaar 	= substr($datum, 0, 4);
               $maand 	= substr($datum, 5, 2);
               $dag	= substr($datum, 8, 2);
               $output = $dag . "-" . $maand . "-" . $jaar; 
          }
          return $output;
     }
         
     protected function getReserveringen() 
     {
          $output = '<p>Klik op het tafelnummer om een bestelling te maken.</p>';
          $output .= '<table>';
               $output .= '<tbody>';

                    $sql = "SELECT *, r.ID AS reservering_ID
                              FROM reserveringen r, klanten k 
                             WHERE r.Klant_ID = k.ID
                               AND r.Status = 1"; 

                    foreach($this->connection->query($sql) as $row) {
                         
                         $class = "";
                         if($row['Datum'] > date("Y-m-d")) { $class = "toekomst"; }
                         if($row['Datum'] == date("Y-m-d")) { $class = "vandaag"; }
                         if($row['Datum'] < date("Y-m-d")) { $class = "verleden"; }
                         
                         $output .= "<tr class='$class'>";
                              $output .= "<td>";
                                   //Rotate date from sql to dutch notation
                                   $datum 	= $row['Datum'];
                                   $dag 	= substr($datum, 8, 2);
                                   $maand 	= substr($datum, 5, 2);
                                   $jaar 	= substr($datum, 0, 4);
                                   $datum 	= $dag . "-" . $maand . "-" . $jaar;
                                   
                                   $output .= $datum;
                              $output .= "</td>";
                              
                              $output .= "<td>";
                                   $output .= $row['Tijd']; 
                              $output .= "</td>";
                              
                              $output .= "<td class='td_tafel'>";
                                   $output .= "<a href='?action=bestellen&reservering=" . $row['reservering_ID'] . " '>" . $row['Tafel'] . "</a>";
                              $output .= "</td>";

                              
                              $output .= "<td>";
                                   $output .= $row['Naam'];
                              $output .= "</td>";
                              
                              $output .= "<td>";
                                   $output .= $row['Telefoon'];
                              $output .= "</td>";
                              
                              $output .= "<td>";
                                   $output .= $row['Aantal'];
                              $output .= "</td>";
                              
                              $output .= "<td>";
                                   $output .= "<a href='?action=edit&reservering=" . 
                                              $row['reservering_ID']."'><i class='fa fa-pencil'></i></a>";
                              $output .= "</td>";

                              $output .= "<td>";
                                   $output .= "<a href='?action=delete&reservering=" . 
                                              $row['reservering_ID']."'><i class='fa fa-trash-o'></a>";
                              $output .= "</td>";

                         $output .= "</tr>";
                    }
          
          $output .= "</tbody>";
          $output .= "</table>";
          return $output;
     }	
}
     $page = new clsPage();
	echo $page->getHtml();

?>