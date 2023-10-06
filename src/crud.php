<?php 
require_once "./src/dbConnect.php";

function queryBuilder($method, $table, ...$payload){
    $query ="";
    switch ($method) {
        case 'c':
            $query .= "INSERT INTO ";
            break;
        case 'r':
            $query .= "SELECT * FROM ";
            break;
        case 'u':
            $query .= "UPDATE ";
            break;
        case 'd':
            $query .= "DELETE ";
            break;
        default:
           
            die("ERROR : Prepared query method not defined");
            break;
    }

    $query .= '`'.  htmlspecialchars($table) . '` ';
    if($method ==='u'){
        $query .= "SET ";


    }
    if($method ==="c"){
        $columnParse  = '(';
        $valueParse  = '(';
        foreach ($payload as $index => $column) {
            foreach ($column as $key => $value) {
                if(is_string($value)){
                    $value = "\"" . $value. "\"";
                }
                $columnParse .= "`" . $key . "`"; 
                 if(!(count($payload) == ($index + 1 ))){
                $columnParse .= ", ";
            }
            }

        }
        $columnParse.= ")";
             foreach ($payload as $index => $column) {
            foreach ($column as $key => $value) {
                if(is_string($value)){
                    $value = "\"" . $value. "\"";
                }
                $valueParse .= $value ; 
                 if(!(count($payload) == ($index + 1 ))){
                $valueParse .= ", ";
            }
            }

        }
        $valueParse.= ")";
        $query .= $columnParse . " VALUES " . $valueParse;
    }
    if($method ==='u'){
        foreach ($payload as $index => $filter) {
            foreach ($filter as $key => $value) {
                if($key !== "id"){
                    if(is_string($value)){
                        $value = "\"" . $value. "\"";
                    }
                    
                    $query .= "`" . $key . "` = ". $value .' ' ; 
                    
                    if(!(count($payload) == ($index + 2 ))){
                        $query .= ", ";
                    }
                }
            }

        }
    }
    if($method !=='c' && $method !== "u" && count($payload)){
        $query .= "WHERE ";
        foreach ($payload as $index => $filter) {
            foreach ($filter as $key => $value) {
                if(is_string($value)){
                    $value = "\"" . $value. "\"";
                }
                $query .= "`" . $key . "` = ". $value . " AND "; 
            }
            if(count($payload) == ($index + 1 ) && $method !=='r'){
                $query .= "1";
            } else if(count($payload) == ($index + 1 )) {
                $query .= '`status` = "online"';
            }
        }
    } else if($method === "u"){
        $idFound = false;
        foreach ($payload as $index => $filter) {
            foreach ($filter as $key => $value) {
                if($key === "id"){
                    $idFound = true;
                
                    $query .= "WHERE ";
                    $query .= "`" . $key . "` = ". $value;
                } 
            }
        }
        if(!$idFound){
            die("ERROR : Not id to update");
        }
    }
    
   return $query;

} 
// dd(queryBuilder("c", "voiture", ["modele" =>"Ferrari"], ["couleur" => "rouge" ], ["test" => "taste"]));
// dd(queryBuilder("r", "contacts",  ["name" => "Delaistre" ]));
// dd(queryBuilder("u", "voiture", ["modele" => "Ferrari" ], ["couleur" => "rouge" ], ["id" => 2]));
// dd(queryBuilder("d", "voiture", ["modele" => "Ferrari" ], ["couleur" => "rouge" ]));



