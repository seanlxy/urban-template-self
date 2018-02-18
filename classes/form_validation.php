<?php


class FormValidation
{
	
	private $rules = array();

	private $regex = array();

	private $is_valid = false;

	private $invalid_fields = array();


	public function __construct( $validation_rules = array() )
	{
		$this->setRules($validation_rules);

	}

	public function validate()
	{
		
		$this->run_validation();

		return empty($this->invalid_fields);
	}

	private function run_validation()
	{
		if( empty($this->rules) ) return false;


		foreach ( $this->rules as $field_name => $data )
		{

			$label         = $data['label'];
			$show_full_msg = $data['show_full_msg'];
			$rules         = explode('|', $data['rules']);

			if( !empty($rules) )
			{
				foreach ($rules as $rule)
				{
					$func_args = self::getMethodNameArgs($rule);

					if( $func_args )
					{
						$method_name = $func_args['method_name'];

						unset($func_args['method_name']);

						$final_args = array_merge( array( 'field_name' => $field_name ), $func_args );
						
						$data = call_user_func_array( array( $this, $method_name ), $final_args );

						$data['message'] = ($show_full_msg) ? $label : sprintf($data['message'], $label, $label);

						if( $data['error'] && $data['message'] )
						{
							$this->setInvalidField($field_name, $data['message'] );
							break;
						}
					}
				}
			}
		}
	}


	/**
	 * Add new validation rule $rules array
	 *
	 * @param name = $field_name, type = string, description - name of the field which needs to be validated
	 *
	 * @param name = $label, type = string, description - label used to display field message
	 *
	 * @param name = $rules, type = string, description - rules against which field will be validated
	 *
	 * @return bool
	*/
	public function setRule($field_name, $label, $rules, $show_full_msg = false)
	{
		if( !isset($this->rules[$field_name]) )
		{
			$this->rules[$field_name] = array(
				'label'         => $label,
				'rules'         => $rules,
				'show_full_msg' => $show_full_msg
			);
		}
	}


	/**
	 * Sets the rule for fields which needs to be validated
	 * Only used in constructor to generate final $rules array
	 *
	 * @param name = $array, type = array
	 *
	 * @return array
	*/
	private function setRules( $array )
	{

		$this->rules = array_merge($this->rules, $array);

	}


	/**
	 * Append invalid field to $invalid_fields array
	 *
	 * @param name = $field, type = string
	 *
	 * @param name = $message, type = string
	 *
	 * @return bool
	*/
	private function setInvalidField( $field, $message )
	{

		if( !$field && !$message ) return false;


		if( !isset($this->invalid_fields[$field]) )
		{
			$this->invalid_fields[$field] = $message;
			
			return true;
		}

	}


	/**
	 * Append invalid field to $invalid_fields array
	 *
	 * @param name = $key, type = string, description - key of $regex array which will be treated as function
	 *
	 * @param name = $value, type = string, description - regex which will do validation
	 *
	 * @return bool
	*/
	public function setRegex( $key, $value )
	{
		if( !$key && !$value ) return false;


		if( !isset($this->regex[$key]) )
		{
			$this->regex[$key] = $value;

			return true;
		}

	}

	static private function getMethodNameArgs( $str )
	{

		if( !$str ) return false;

		$data = array();

		$method_name = $str;
		$pos  = strpos($str, '[');

		if( $pos !== false  )
		{

			$method_name = substr($method_name, 0, $pos);

			preg_match("/\[([^\]]*)\]/", $str, $matches);

		}

		$data['method_name'] = $method_name;

		if( isset($matches) )
		{
			$data['match_against'] = $matches[1];
		}
		

		return $data;
	}

	public function getErrors()
	{
		return $this->invalid_fields;
	}

	public function getError( $field_name, $wrap_tag = true )
	{
		if( isset($this->invalid_fields[$field_name]) )
		{
			$msg = $this->invalid_fields[$field_name];
			
			return ( $wrap_tag ) ? display_message($msg, 'danger') : $msg;
		}
		else
		{
			return false;
		}
	}

	// Validation methods
	// If future will be replaced by array of regex.
	private function trim( $field_name )
	{
		$is_invalid = false;
		$value      = trim( filter_input( INPUT_POST, $field_name ) );
		$message    = '';
		
		return array( 'error' => $is_invalid, 'message' => $message, 'value' => $value );
	}

	private function required( $field_name )
	{
		$value      = filter_input( INPUT_POST, $field_name );
		$is_invalid = ( strlen($value) === 0 );
		$message    = ( $is_invalid ) ? '%s is required' : '';
		return array( 'error' => $is_invalid, 'message' => $message, 'value' => $value );
	}

	private function integer( $field_name )
	{
		
		$value      = filter_input( INPUT_POST, $field_name, FILTER_VALIDATE_INT );
		$is_invalid = !is_integer( $value );
		$message    = ( $is_invalid ) ? 'Please enter a valid number' : '';
		
		return array( 'error' => $is_invalid, 'message' => $message, 'value' => $value );

	}

	private function float( $field_name )
	{

		$value      = filter_input( INPUT_POST, $field_name, FILTER_VALIDATE_FLOAT );
		$is_invalid = !is_float( $value );
		$message    = ( $is_invalid ) ? 'Please enter a valid decimal number.' : '';
		
		return array( 'error' => $is_invalid, 'message' => $message, 'value' => $value );

	}

	private function group( $field_name )
	{
        $value      = $_REQUEST["$field_name"];
        $value = $value[0];
        $is_invalid = ( strlen($value) === 0 );
        $message    = ( $is_invalid ) ? 'Please tick at least one option.' : '';
        $return = [ 'error' => $is_invalid, 'message' => $message ];
        return $return;
	}

	private function email( $field_name )
	{
		$value      = filter_input( INPUT_POST, $field_name, FILTER_VALIDATE_EMAIL );
		$is_invalid = !$value;
		$message    = ( $is_invalid ) ? 'Please enter a valid email address.' : '';
		
		return array( 'error' => $is_invalid, 'message' => $message, 'value' => $value );

	}

	private function alphaNumeric( $field_name )
	{

		$value      = filter_input( INPUT_POST, $field_name );
		$is_invalid = !ctype_alnum( $value );
		$message    = ( $is_invalid ) ? 'Only alphanumeric characters are allowed.' : '';
		
		return array( 'error' => $is_invalid, 'message' => $message, 'value' => $value );
		
	}

	private function alpha( $field_name )
	{
		$value      = filter_input( INPUT_POST, $field_name );
		$is_invalid = !ctype_alpha( $value );
		$message    = ( $is_invalid ) ? 'Only alphabets are allowed.' : '';
		
		return array( 'error' => $is_invalid, 'message' => $message, 'value' => $value );

	}

	private function date( $field_name, $match_against )
	{

		$date = filter_input( INPUT_POST, $field_name );

		$d = DateTime::createFromFormat( $match_against, $date );

		$is_invalid = !($d && $d->format($match_against) == $date);
		// Please enter %s in ('.$match_against.') format.
		$message    = ( $is_invalid ) ? 'Invalid %s format.' : '';
		
		return array( 'error' => $is_invalid, 'message' => $message, 'value' => $date );

	}


	private function match( $field_name, $match_against )
	{

		$field_value               = filter_input( INPUT_POST, $field_name );
		$field_value_to_match_with = filter_input( INPUT_POST, $match_against );

		$is_invalid = !($field_value_to_match_with === $field_value);

		$message    = ( $is_invalid ) ? 'Please confirm %s.' : '';
		
		return array( 'error' => $is_invalid, 'message' => $message, 'value' => $field_value );

	}

	private function min( $field_name, $min_val )
	{

		$field_value = filter_input( INPUT_POST, $field_name );
		$min_val     = filter_var( $min_val, FILTER_VALIDATE_FLOAT );

		$is_invalid = ($field_value < $min_val);

		$message    = ( $is_invalid ) ? ('%s should be greater than or equal to '.$min_val) : '';
		
		return array( 'error' => $is_invalid, 'message' => $message, 'value' => $field_value );

	}

	private function captcha( $field_name, $session_key )
	{

		$field_value = filter_input( INPUT_POST, $field_name );
		$session_val = $_SESSION[$session_key];

		$is_invalid = !($session_val === hash('sha512', sha1(md5($field_value))));

		$message    = ( $is_invalid ) ? 'Invalid %s.' : '';
		
		return array( 'error' => $is_invalid, 'message' => $message, 'value' => $field_value );

	}




}


/* End of file form_validation.php */
/* Location: /classes/form_validation.php */

?>