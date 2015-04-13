<?php
/*
*	Form class by hugopb82, enjoy!
*	Fork me on github!
*/
class Form{

	private $data = [];
	private $end;

	/*
	* Set form attributes
	*	@param	$data	array	form attributes
	*/
	public function __construct($data){
		$this->data = is_array($data) ? $data : array('action' => $data);
	}

	/*
	* Add an input in the form
	* 	@param	$type	string	type of the form field
	*	@param	$name	string	name of the form field
	*	@param	$label	string	label of the form field (default is $name)
	*	@param	$options	array	attributes for the fields
	*	@return	string	final html code
	*/
	public function add($type, $name, $label = null, $options = null){
		$label = !is_null($label) ? $label : ucfirst($name) . ' :';
		$attributes = '';

		if(!is_null($options) && is_array($options) && $type != 'select'){
			foreach($options as $k => $v){
				$attributes .= $k . '="' . $v . '" ';
			}
		}

		if($type === 'submit'){
			$end = '<input type="submit" name="' . $name . '" value="' . $label . '"  ' . $attributes .' >';
		}elseif($type === 'textarea'){
			$input = '<textarea name="' . $name . '"  ' . $attributes .' ></textarea>';
			$end = $this->label($label, $input);
		}elseif($type === 'hidden'){
			$end = '<input type="hidden" name="' . $name . '">';
		}elseif($type === 'select'){
			$html = '<select name="' . $name . '">';
			foreach($options as $k => $v){
				if(is_array($options[$k])){
					$attributes = '';
					foreach($v as $k => $v){
						$attributes .= $k . '="' . $v . '" ';
					}
					$html .= '<option ' . $attributes . ' >' . $k . '</option>';
				}else{
					$html .= '<option>' . $v . '</option>';
				}
			}
			$html .= '</select>';
			$end = $this->label($label, $html);;
		}else{
			$input = '<input type="' . $type . '" name="' . $name . '" ' . $attributes .' >';
			$end = $this->label($label, $input);
		}
		$this->end .= $end;
	}

	/*
	* Build the final html code
	*	@return	string	final html code
	*/
	public function end(){
		$html = '<form ';
		foreach($this->data as $k => $v){
			$html .= $k . '="' . $v . '" ';
		}
		$html .= '>' . $this->end . '</form>';
		return $html;
	}

	/*
	* Warp the input with a label
	*	@param	$label	string	value of the label
	*	@param	$input	string	html input code
	*	@return	string	final html code
	*/
	protected function label($label, $input){
		return '<label>' . $label . $input . '</label>';
	}
}