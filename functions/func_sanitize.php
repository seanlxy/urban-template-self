<?php
#### File: class_sanitize.php
#### Author: CodeAssembly.com
#### Reformatted By: Sam Walsh
#### Date: 3/2010
  
    /**
    * Sanitize only one variable .
    * Returns the variable sanitized according to the desired type or true/false 
    * for certain data types if the variable does not correspond to the given data type.
    * 
    * NOTE: True/False is returned only for telephone, pin, id_card data types
    *
    * @param mixed The variable itself
    * @param string A string containing the desired variable type
    * @return The sanitized variable or true/false
    */
    function sanitize_one($var, $type = 'sqlsafe'){       
        switch($type){
            case 'int': // integer
            $var = (int)$var;
            break;
    
            case 'str': // trim string
            $var = trim($var);
            break;
    
            case 'nohtml': // trim string, no HTML allowed
            $var = htmlentities(trim($var),ENT_QUOTES);
            break;
            
            case 'plain': // trim string, no HTML allowed, plain text
            $var =  htmlentities(trim($var),ENT_NOQUOTES)  ;
            break;
        
            case 'sqlsafe': // make string safe from sql injection
            $var = filter_var($var, FILTER_SANITIZE_MAGIC_QUOTES);
            break;
        
            case 'upper_word': // trim string, upper case words
            $var = ucwords(strtolower(trim($var)));
            break;
    
            case 'ucfirst': // trim string, upper case first word
            $var = ucfirst(strtolower(trim($var)));
            break;
    
            case 'lower': // trim string, lower case words
            $var = strtolower(trim($var));
            break;
    
            case 'urle': // trim string, url encoded
            $var = urlencode(trim($var));
            break;
    
            case 'trim_urle': // trim string, url decoded
            $var = urldecode(trim($var));
            break;
            
            case 'telephone': // True/False for a telephone number
            $size = strlen($var) ;
            for ($x=0;$x<$size;$x++){
                    if (!((ctype_digit($var[$x]) || ($var[$x]=='+') || ($var[$x]=='*') || ($var[$x]=='p') || ($var[$x]=='(') || ($var[$x]==')')))){
                        return false;
                    }
            }
            return true;
            break;
            
            case 'pin': // True/False for a PIN
            if ((strlen($var)!=13) || (ctype_digit($var)!=true)){
                return false;
            }
            return true;
            break;
            
            case 'id_card': // True/False for an ID CARD
            if ((ctype_alpha(substr($var,0,2))!= true) || (ctype_digit(substr($var,2,6))!=true) || (strlen($var)!=8)){
                return false;
            }
            return true;
            break;
            
            case 'sql': // True/False if the given string is SQL injection safe
            //  insert code here, I usually use ADODB -> qstr() but depending on your needs you can use mysql_real_escape();
            return mysql_real_escape_string($var);
            break;
        }       
        return $var; 
    }
    
    
    /**
     * Sanitize an array.
     * 
     * sanitize($_POST, array('id'=>'int', 'name' => 'str'));
     * sanitize($customArray, array('id'=>'int', 'name' => 'str'));
     *
     * @param array $data
     * @param array $whatToKeep
     */
    function sanitize_arr( &$data, $whatToKeep )
    {
        $data = array_intersect_key( $data, $whatToKeep ); 
        
        foreach ($data as $key => $value)
        {
                $data[$key] = sanitize_one( $data[$key] , $whatToKeep[$key] );
        }
    }

    function sanitize_output($buffer)
    {

        $search = array(
            '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
            '/[^\S ]+\</s',  // strip whitespaces before tags, except space
            '/(\s)+/s'       // shorten multiple whitespace sequences
        );

        $replace = array(
            '>',
            '<',
            '\\1'
        );

        $buffer = preg_replace($search, $replace, $buffer);

        return $buffer;
    }


    function sanitize_input($name, $filter_type = FILTER_SANITIZE_MAGIC_QUOTES,  $type = 'post')
    {
        return stripslashes(strip_tags(filter_input((($type == 'post') ? INPUT_POST : INPUT_GET), $name, $filter_type)));
    }


    function sanitize_var($var, $filter_type = FILTER_SANITIZE_MAGIC_QUOTES)
    {

        return stripslashes(strip_tags( filter_var( $var, $filter_type) ));
    }

?>