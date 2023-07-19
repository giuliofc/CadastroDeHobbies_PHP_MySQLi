<?php
    //executa Querys
    function DBExecute($query, $insertId=false){
        $link=DBConnect();
        $result=@mysqli_query($link, $query)or die(mysqli_error($link));

        if($insertId)
            $result=mysqli_insert_id($link); //se for passado o parametro insertId eu quero q seja retornado o id deste novo

        DBClose($link);
        return $result;
    }

    function DBCreate($table, array $data, $insertId=false){
        $table=DB_PREFIX.'_'.$table;
        $data=DBEscape($data);

        $fields=implode(', ', array_keys($data)); 
        $values="'".implode("', '", $data)."'";
        $query="INSERT INTO {$table} ( {$fields} ) VALUES ( {$values} )";

        return DBExecute($query, $insertId); //insertId para quando deseja q seja retornado o id do novo criado
    }

    //Ler registros
    function DBRead($table, $params=null, $fields='*'){
        $table=DB_PREFIX.'_'.$table;
        $params=($params) ? " {$params}" : null; 

        $query="SELECT {$fields} FROM {$table}{$params}";
        $result=DBExecute($query);

        if(!mysqli_num_rows($result)) //mysqli_num_rows conta o numero de linhas 
            return false;
        else{
            while($res=mysqli_fetch_assoc($result)){ //mysqli_fetch_assoc transforma os campos da tabela em array onde os indices são os nomes dos campos     
                $data[]=$res;
            }
            
            return $data;
        }   
    }

    //Altera Registros
    function DBUpdate($table, array $data, $where=null, $insertId=false){
        foreach($data as $key=>$value){
            $fields[]="{$key}='{$value}'";
        }
        $fields=implode(', ', $fields);

        $table=DB_PREFIX.'_'.$table;
        $where=($where) ? " {$where}" : null;

        $query="UPDATE {$table} SET {$fields}{$where}";
        return DBExecute($query, $insertId);
    }

    //Deleta Registros
    function DBDelete($table, $where=null){

        $table=DB_PREFIX.'_'.$table;
        $where=($where) ? " {$where}" : null;

        $query="DELETE FROM {$table}{$where}";
        return DBExecute($query, true);
    }

?>