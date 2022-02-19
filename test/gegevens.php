<?php
	require_once("includes/includes.php");
     require_once(CLASSES_PATH . "table.inc.php");	
	
class clsDrinkenEnEten extends clsTableDef
{     
     public function __construct() 
     {
          parent::__construct();
          
          $this->selectsql = ""; // is set in derived class
          $this->tablename = "menuitems";
          $this->key = "ID";
          
          $column = new clsColumn();
          $column->setFieldName("Code");
          $column->setCaption("Code");         
          $this->columnHeader->addColumn($column);
          
          $column = new clsColumn();
          $column->setFieldName("Naam");
          $column->setCaption("Omschrijving");         
          $this->columnHeader->addColumn($column);
          
          $column = new clsColumn();
          $column->setFieldName("Prijs");
          $column->setCaption("Prijs");
          $this->columnHeader->addColumn($column);
          
          $column = new clsColumn();
          $column->setFieldName("Gerechtsoort_ID");
          $column->setCaption("Valt onder");
          $column->setEditType("Select");
          $column->setLookUpSql("SELECT CONCAT(s.Code, ' - ', s.Naam, '->', c.Naam) as lookupresult,
                                        s.ID as lookup_id
                                   FROM gerechtsoorten s 
                                   LEFT JOIN gerechtcategorien c 
                                          ON s.Gerechtcategorie_ID = c.ID");
          $this->columnHeader->addColumn($column);         
     }  
}

class clsDrinken extends clsDrinkenEnEten
{
     public function __construct() 
     {
          parent::__construct();

          $this->selectsql = "SELECT m.ID, m.Naam, m.Code, m.Prijs, m.Gerechtsoort_ID    
                                FROM menuitems m 
                                LEFT JOIN gerechtsoorten s 
                                       ON m.Gerechtsoort_ID = s.ID
                                LEFT JOIN gerechtcategorien c 
                                       ON s.Gerechtcategorie_ID = c.ID
                              WHERE c.Code = 'drk'";
          $this->setTableTitle("Drinken");
     }      
}

class clsEten extends clsDrinkenEnEten
{     
     public function __construct() 
     {
          parent::__construct();

          $this->selectsql = "SELECT m.ID, m.Naam, m.Code, m.Prijs, m.Gerechtsoort_ID    
                                FROM menuitems m 
                                LEFT JOIN gerechtsoorten s 
                                       ON m.Gerechtsoort_ID = s.ID
                                LEFT JOIN gerechtcategorien c 
                                       ON s.Gerechtcategorie_ID = c.ID
                              WHERE c.Code <> 'drk'";
          $this->setTableTitle("Eten");
     }      
}
	
class clsKlanten extends clsTableDef
{     
     public function __construct() 
     {
          parent::__construct();
          
          $column = new clsColumn();
          $column->setFieldName("Naam");
          $column->setCaption("Naam");         
          $this->columnHeader->addColumn($column);

          $column = new clsColumn();
          $column->setFieldName("Telefoon");
          $column->setCaption("Telefoon");         
          $column->setEditType("Telephone");
          $this->columnHeader->addColumn($column);

          $column = new clsColumn();
          $column->setFieldName("Email");
          $column->setCaption("Email");         
          $this->columnHeader->addColumn($column);
          
          $this->selectsql = "SELECT * FROM klanten ORDER BY Naam"; 
          $this->tablename = "klanten";
          $this->key = "ID";
          $this->setTableTitle("Klanten");
     }  
     
}

class clsGerechtSoort extends clsTableDef
{     
     public function __construct() 
     {
          parent::__construct();
          
          $this->selectsql = "SELECT ID, Code, Naam, Gerechtcategorie_ID
                                FROM gerechtsoorten
                              ORDER BY Naam";
          $this->tablename = "gerechtsoorten";
          $this->key = "ID";
          $this->setTableTitle("Gerecht subgroepen");
          
          $column = new clsColumn();
          $column->setFieldName("Code");
          $column->setCaption("Code");
          $this->columnHeader->addColumn($column);
          
          $column = new clsColumn();
          $column->setFieldName("Naam");
          $column->setCaption("Omschrijving");         
          $this->columnHeader->addColumn($column);         
          
          $column = new clsColumn();
          $column->setFieldName("Gerechtcategorie_ID");
          $column->setCaption("Valt onder");
          $column->setEditType("Select");
          $column->setLookUpSql("SELECT Naam as lookupresult, ID as lookup_id
                                   FROM gerechtcategorien 
                                 ORDER BY Naam");
          $this->columnHeader->addColumn($column);         
     }  
}

class clsGerechtCategorie extends clsTableDef
{     
     public function __construct() 
     {
          parent::__construct();
          
          $this->selectsql = "SELECT ID, Code, Naam 
                                FROM gerechtcategorien
                              ORDER BY Naam"; 
          $this->tablename = "gerechtcategorien";
          $this->key = "ID";
          $this->setTableTitle("Gerecht hoofdgroepen");
          
          $column = new clsColumn();
          $column->setFieldName("Code");
          $column->setCaption("Code");
          $this->columnHeader->addColumn($column);
          
          $column = new clsColumn();
          $column->setFieldName("Naam");
          $column->setCaption("Omschrijving");         
          $this->columnHeader->addColumn($column);                   
     }  
}

class clsPage extends clsDefaultPage
{	
     protected function contentHtml() 
     {	
          $datalist = null;
          $soort = "";		
          if (isset($_GET['soort'])) 
          {    $soort = $_GET['soort'];
               $keyvalue = false;		
               if (isset($_GET['key'])) 
               {    $keyvalue = $_GET['key'];
               }  
               $datalist = $this->getTableDef($soort, $keyvalue);
          }
          
          $action = "";		
          if (isset($_GET['action'])) 
          {    $action = $_GET['action'];
          }

          switch($action) 
          {
               case "edit": 
                    return $datalist->getEditHtml(); break;
               case "new": 
                    return $datalist->getNewHtml(); break;
               case "save": 
                    return $datalist->getUpdateHtml(); break;
               case "insert": 
                    return $datalist->getInsertHtml(); break;
               case "delete": 
                    return $datalist->getDeleteHtml(); break;
               default:   
                    return $datalist->getGridHtml(); break;
          }  
          
     } 
     
     protected function getTableDef($soort, $keyvalue) 
     {
          $datalist = false;
          switch($soort) 
          {
               case "drinken"     : $datalist = new clsDrinken(); break;
               case "eten"        : $datalist = new clsEten(); break;
               case "klanten"     : $datalist = new clsKlanten(); break;
               case "gerechten"   : $datalist = new clsGerechtCategorie(); break;
               case "subgerechten": $datalist = new clsGerechtSoort(); break;
          }
          if (!$datalist)
          {
               print "Onbekend gegeven.";
               die;
          }        
          $datalist->setSoort($soort);
          $datalist->setKeyValue($keyvalue);
          
          return $datalist;
     }    
}

     $page = new clsPage();
	echo $page->getHtml();
?>