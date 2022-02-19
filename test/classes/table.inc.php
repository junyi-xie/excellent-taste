<?php

class clsColumnHeader
{
     private $columns;
     
     public function __construct() 
     {
          $this->columns = array();
     } 
     
     public function addColumn($column)
     {
          $this->columns[] = $column;
     }    
    
     public function getColumns()
     {
          return $this->columns;
     }    
     
}

class clsColumn
{
     private $fieldName;
     private $fieldCaption;
     private $edittype; /* Bootstrap input types: Text, Search, Email, URL, Telephone
                                                  Password, Number, Date and time, 
                                                  Date, Month, Week, Time*/
     private $lookupsql;
     private $actionlink; 
     private $readonly;
     private $iconclass;  
     
     public function __construct() 
     {
          $this->edittype = "Text";
          $this->readonly = false;
          $this->lookupsql = false;
          $this->actionlink = false; 
          $this->iconclass = "";     
     } 
     
     public function getCaption()
     {
          return $this->fieldCaption;
     }
     
     public function setCaption($caption)
     {
          $this->fieldCaption = $caption;
     }
     
     public function getFieldName()
     {
          return $this->fieldName;
     }
     public function setFieldName($fieldname)
     {
          $this->fieldName = $fieldname;
     }
     
     public function getEditType()
     {
          return $this->edittype;
     }
     
     public function setEditType($edittype)
     {
          $this->edittype = $edittype;
     }
     
     public function getLookUpSql()
     {
          return $this->lookupsql;
     }
     
     public function setLookUpSql($lusql)
     {
          $this->lookupsql = $lusql;
     } 
     
     public function getReadOnly()
     {
          return $this->readonly;
     }
     
     public function setReadOnly()
     {
          $this->readonly = true;
     }
     
}

class clsTableDef
{
     protected $connection;
     protected $header;
     protected $body;
     protected $tablename;
     protected $selectsql;
     protected $key;
     protected $keyvalue;
     protected $soort;
     protected $readonly;
     protected $tabletitle;
    
     public function __construct() 
     {
          $this->connection = database::connect();
          $this->columnHeader = new clsColumnHeader();
          $this->keyvalue = -1;
          $this->tabletitle = "";
     } 
     
     public function getHeader()
     {
          return $this->columnHeader;
     }  
     
     public function getSelectSql()
     {
          return $this->selectsql;
     } 
     
     public function getKey()
     {
          return $this->key;
     } 

     public function getKeyValue()
     {
          return $this->keyvalue;
     } 

     public function setKeyValue($value)
     {
          $this->keyvalue = $value;
     } 

     public function getTableName()
     {
          return $this->tablename;
     } 

     public function setTableTitle($value)
     {
          $this->tabletitle = $value;
     } 

     public function getTableTitle()
     {
          return $this->tabletitle;
     } 
     
     public function setSoort($soort)
     {
          $this->soort = $soort;
     } 
     
     public function setReadOnly($value = false)
     {
          $this->readonly = $value;
     } 
     
     private function makeSelect($value, $name, $column)
     {
          $output =  
               "<select class='selectpicker form-control' 
                        id='" . $name . "'  
                        name='" . $name . "'>";
                        
          foreach($this->connection->query($column->getLookUpSql()) as $row) 
          {    $output .= "
                     <option value = '" . $row['lookup_id'] . "' ";
               if ($row['lookup_id'] == $value)
               {    $output .= "
                             selected='selected' ";
               }
               $output .= "
                     <option>" . $row['lookupresult'] . "</option>";
          }
          $output .= 
               "</select>";
          return $output;
     }
     
     private function makeInput($value, $name, $column)
     {    $readonly = " readonly='readonly'";
          $readonlyclass = " form-control-plaintext";
          if (!$column->getReadOnly())
          {    $readonly = "";
               $readonlyclass = "";
          }
          
          return "<input type='" . $column->getEditType() . "' 
                         class='form-control$readonlyclass'
                         $readonly 
                         value='" . $value . "'  
                         id='" . $name . "'  
                         name='" . $name . "'>";
     }
     
     private function makeFormControlSet($column, $row = false)
     {    $fieldname = $column->getFieldName();
          if (!$row)
          {    $value = "";
          }
          else
          {    $value = $row[$fieldname];
          }
          $name = $fieldname . "_id";
          $fieldcaption = $column->getCaption();
          
          $output = 
              "<div class='form-group'>
                    <label for='" . $name . "'>" . $fieldcaption . "
                    </label>";
          
          $edittype = $column->getedittype();
          switch($edittype) 
          {
               case "Text":
               case "Search":
               case "Email":
               case "URL":
               case "Telephone":
               case "Number":
               case "Date and time":
               case "Date":
               case "Week":
               case "Time":
                         $output .= $this->makeInput($value, $name, $column); 
                         break;
               case "Select": 
                         $output .= $this->makeSelect($value, $name, $column); 
                         break;
          }
          $output .= 
              "</div>";

          return $output;
     }
     
     private function makeSaveDialog()
     {  return  "
          <div class='row'>
               <div class='help-block'>
               </div>
               <div class='centered'>
                    <button type='submit' class='btn btn-primary'>Bewaren
                    </button>
                    <a href='?soort=$this->soort' class='btn btn-default'>Annuleren
                    </a>
               </div>
          </div>";
     }
     
     private function makeOkDialog($tekst)
     {  return "
          <div class='row'>
               <div class='help-block'>
               </div>
               <div class='centered'>
                    <label for='okdialog_id'>" . $tekst . "
                    </label>                   
                    <div class='help-block'>
                    </div>
                    <a href='?soort=$this->soort' 
                       id='okdialog_id' 
                       class='btn btn-primary'>Ok
                    </a>
               </div>
          </div>";
     }
     
     private function getLookUpValues()
     {
          $result = array();
          foreach ($this->getHeader()->getColumns() as $column)
          {
               if (!$column->getLookUpSql())
               {
               }
               else
               {
                    $values = array();
                    foreach($this->connection->query($column->getLookUpSql()) as $row) 
                    { 
                         $values[$row['lookup_id']] = $row['lookupresult'];
                    }
                    $result[$column->getFieldName()] = $values;
               }
          } 
          return $result;
     }
     
     private function noKeyValue()
     {
          $this->keyvalue = -1;		
          if (isset($_GET['key'])) 
          {    $this->keyvalue = $_GET['key'];
          }
          return ($this->keyvalue < 0);
     }
     
     public function getEditHtml()
     {
          if ($this->noKeyValue())
          {    return "Onbekende gegevens";
          }
          
          $keyrow = false;
          foreach ($this->connection->query($this->getSelectSql()) as $row) 
          {
               if ($row[$this->getKey()] == $this->getKeyValue())
               {
                    $keyrow = $row;
                    break;
               }
          }
          if (!$keyrow)
          {    return $output;
          }
          
          $output = "
               <form action='?action=save&soort=$this->soort&key=" . $this->getKeyValue() . "' 
                     method='POST' 
                     role='form' 
                     class='form-horizontal'>";
          foreach ($this->getHeader()->getColumns() as $column)
          {    $output .= $this->makeFormControlSet($column, $keyrow);
          }
          
          $output .= $this->makeSaveDialog();
          
          $output .= "
               </form>";
               
          return $output;
     }
     
     public function getNewHtml()
     {
          $output = "
               <form action='?action=insert&soort=$this->soort'  
                     method='POST' 
                     role='form' 
                     class='form-horizontal'>";
                     
          foreach ($this->getHeader()->getColumns() as $column)
          {    $output .= $this->makeFormControlSet($column);
          }
          
          $output .= $this->makeSaveDialog();
          
          $output .= "
               </form>";
               
          return $output;
     }
     
     public function getUpdateHtml()
     {
          if ($this->noKeyValue())
          {   
               return $this->makeOkDialog("Onbekende gegevens."); 
          }
          
          $sql = "UPDATE " . $this->getTableName() . " SET ";
          // Submitted key-value pairs
          $fvpairs = array();
          foreach ($this->getHeader()->getColumns() as $column)
          {
               if (!$column->getReadOnly())
               {
                    $fvpairs[] = $column->getFieldName() . " = '" . 
                                 $_POST[$column->getFieldName() . "_id"] . "'";
               }
          }
          
          
          $sql .= join(', ', $fvpairs) . // Convert key-value pairs to comma separated string
                 "   WHERE " . $this->getKey() . " = '" . $this->getKeyValue() . "'";

          if ($this->connection->query($sql) == true)
          {    return $this->makeOkDialog("De gegevens zijn opgeslagen.");
		} 
		else 
		{    return $this->makeOkDialog($sql . " is mislukt. De gegevens zijn NIET opgeslagen"); 
		     die;
		}							
     }
     
     public function getInsertHtml()
     {
          // Submitted fields and values
          $fields = array();
          $values = array();
          foreach ($this->getHeader()->getColumns() as $column)
          {
               $fields[] = $column->getFieldName();
               $values[] = $_POST[$column->getFieldName() . "_id"];
          }
          
          $sql = 
               "INSERT INTO " . $this->getTableName() . 
                          " (" . join(', ', $fields) . ") 
                     VALUES ('" . join("', '", $values) . "')";       
          if ($this->connection->query($sql) == true)
          {    return $this->makeOkDialog("De gegevens zijn opgeslagen.");
		} 
		else 
		{    return $this->makeOkDialog($sql . " is mislukt. De gegevens zijn NIET opgeslagen"); 
		     die;
		}							
     }
     
     public function getDeleteHtml()
     {
          if ($this->noKeyValue())
          {
               return $this->makeOkDialog("Onbekende gegevens."); 
          }
          
          $sql =  "DELETE FROM " . $this->getTableName();
          $sql .= " WHERE " . $this->getKey() . " = '" . $this->getKeyValue() . "'";
          
          if ($this->connection->query($sql) == true)
          {    return $this->makeOkDialog("De gegevens zijn verwijderd.");
		} 
		else 
		{    return $this->makeOkDialog($sql . " is mislukt. De gegevens zijn NIET verwijderd"); 
		     die;
		}							
     }
     
     public function getGridHtml($filterkey = false)
     {
          $output = 
              "<table>
                    <caption>" . $this->getTableTitle() . "</caption>
                    <thead>
                         <tr>";
          foreach ($this->getHeader()->getColumns() as $column)
          {
               $output .=    "<th>" . $column->getCaption() . "</th>";
          }
          $editable = (!$filterkey); 
          if ($editable)
          {    
               $output .=    "<th colspan='2' class='text-center'>
                                   <a href='?action=new&soort=$this->soort'>
                                        <i class='fa fa-plus'></i>
                                   </a>
                              </th>";
          }
          $output .= "   </tr>
                    </thead>
                    <tbody>";
                    
          
          $lookupvalues = $this->getLookupValues();
          foreach ($this->connection->query($this->getSelectSql()) as $row) 
          {
               if ((!$filterkey) || ($filterkey == $row[$this->getKey()])) 
               {
                    $output .= 
                             "<tr>";
                    foreach ($this->getHeader()->getColumns() as $column)
                    {    $celval = "";
                         $fldname = $column->getFieldName();
                         if ($fldname != "")
                         {
                              if (!$column->getLookUpSql())
                              {    $celval = $row[$fldname];
                              }
                              else
                              {    // Lookup field
                                   $celval = $lookupvalues[$fldname][$row[$fldname]];
                              }
                         }
                         $output .= 
                                  "<td>" .
                                       $celval .
                                  "</td>";
                    }
                    if ($editable)
                    {    $output .=    
                                  "<td>
                                        <a href='?action=edit&soort=" . 
                                                 $this->soort . 
                                                "&key=" . 
                                                $row[$this->getKey()]."'>
                                             <i class='fa fa-pencil'></i>
                                        </a>
                                   </td>
                                   <td>
                                        <a href='?action=delete&soort=$this->soort&key=" . $row[$this->getKey()] . "'>
                                             <i class='fa fa-trash-o'></i>
                                        </a>
                                   </td>";
                    }
                    $output .= 
                             "</tr>";
               }
          }
          $output .= "
                    </body>
               </table>";         
          return $output;
     }
}
?>