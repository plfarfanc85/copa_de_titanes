<?php
/*
Formulario de registro de comprobantes de pago de compra de creditos
*/
class CompraCreditosForm extends CFormModel
{
	public $path;

	public function rules()
	{
		return array(
			array('path', 'required'),
		);
	}
	
	
}
?>