<?php

require_once("includes/includes.php");
require_once(CLASSES_PATH . "table.inc.php");	
	
class clsOverzicht extends clsTableDef
{     
     public function __construct() 
     {
          parent::__construct();
                   
          $vandaag = date("Y-m-d");
          $this->selectsql = "SELECT r.Tafel AS tafelnr, 
                                     b.Aantal AS aantalitems, 
                                     m.Naam AS naam, 
                                     c.Code AS SC,
                                     b.ID AS bestel_id 
                                FROM bestellingen b
                                     LEFT JOIN reserveringen r 
                                     ON r.ID = b.Reservering_ID
                                     LEFT JOIN menuitems m 
                                     ON b.Menuitem_ID = m.ID
                                     LEFT JOIN gerechtsoorten s 
                                     ON m.Gerechtsoort_ID = s.ID 
                                     LEFT JOIN gerechtcategorien c 
                                     ON s.Gerechtcategorie_ID = c.ID 
                               WHERE r.Datum = '" . $vandaag . "' 
                                 AND c.Code  ";            
          $this->tablename = "reservering";
          $this->key = "bestel_id";
          $this->setReadOnly(true);
          $this->setSoort("bestellingen");

          $column = new clsColumn();
          $column->setFieldName("tafelnr");
          $column->setCaption("Tafel");         
          $this->columnHeader->addColumn($column);
          
          $column = new clsColumn();
          $column->setFieldName("aantalitems");
          $column->setCaption("Aantal");         
          $this->columnHeader->addColumn($column);
          
          $column = new clsColumn();
          $column->setFieldName("naam");
          $column->setCaption("Gerecht");
          $this->columnHeader->addColumn($column);         
     } 
}

class clsOverzichtKok extends clsOverzicht
{
     public function getSelectSql()
     { // Overwrite
          return $this->selectsql .= "<> 'drk'"; 
     }
}

class clsOverzichtOber extends clsOverzicht
{     
     public function getSelectSql()
     { // Overwrite
          return $this->selectsql .= "= 'drk'"; 
     }
     
}

class clsPage extends clsDefaultPage
{
     protected function contentHtml()
     {			
          if (isset($_GET['action'])) 
          {    $action = $_GET['action'];
               if ($action == "naarbon")
               {
                    $this->naarBon($_GET['key']);
               }
          } 
          
          $voorWie = "";
          if (isset($_SESSION['overzicht']))
          {    $voorWie = $_SESSION['overzicht'];
          }
          if (isset($_GET['overzicht'])) 
          {    $voorWie = $_GET['overzicht'];
               $_SESSION['overzicht'] = $voorWie;
          }
          
          return $this->getOverzicht($voorWie);
     }
     
     protected function getOverzicht($voorWie) 
     {    if ($voorWie == "kok")
          {    $this->datalist = new clsOverzichtKok();
          }
          else
          {    $this->datalist = new clsOverzichtOber();
          }
          return $this->datalist->getGridHtml();
     }
     
}

     $page = new clsPage();
	echo $page->getHtml();
	
?>