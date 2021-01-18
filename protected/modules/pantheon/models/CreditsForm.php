<?php
/*
Formulario de registro de comprobantes de pago de compra de creditos
*/
class CreditsForm extends CFormModel
{
	public $credit_id;
	public $cantidad;

	public function rules()
	{
		return array(
			array('credit_id,cantidad', 'required'),
		);
	}
	
	
}
?>