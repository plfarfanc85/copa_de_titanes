<?php
/*
Esta clase permite autenticar los diferentes usuarios que pueden hacer uso del Service Center
Aliados de Productos, Aliados de Experiencias y Administradores de Portales StarShop
*/
class UserIdentity extends CUserIdentity
{
    private $_id;
    public $sha1;
	public $olimpico = 0; 
    public $tipo = '';

	/*
    Define que tipo de conexión realiza el usuario y contra que se deben validar las credenciales del usuario
    Esto permite que se definan los parámetros de conexión que se almacenarán en sesión y permitirá cargar las interfaces necesarias
    */
    public function authenticate()
	{
        if($this->autenticar())
            $this->errorCode = self::ERROR_NONE;
        else
            $this->errorCode = self::ERROR_USERNAME_INVALID;

        return !$this->errorCode;
    }

    /*
    Busca el usuario
    */
    private function autenticar()
    {
        $criteria = new CDbCriteria;
        if ($this->sha1){
            $criteria->addCondition("sha1(username)=:username AND password=:password AND state=1 ");
            $criteria->params = array(':username'=>$this->username, ':password'=>$this->password);
        }else{
            $criteria->addCondition("(username=:username or dni=:username or email=:username) AND password=:password AND (state=1 or state=99) ");
            $criteria->params = array(':username'=>$this->username, ':password'=>sha1($this->password));
        }

        if($this->tipo == "gods")
        $user = UserRrhh::model()->find($criteria);
        else
        $user = Player::model()->find($criteria);

        if($user)
        {
            $this->_id = $user->id;
            $this->setState('id', $user->id);
            $this->setState('nombre', $user->name.' '.$user->surname);
            $this->setState("documento",$user->dni);
            #$this->setState("path",$user->path);
            #$this->setState("tipo",0);
            $this->setState("email",$user->email);
            $this->setState("username",$user->username);
            $this->setState("perfil",$user->profile);
            $this->setState("imagen",$user->path);
            $this->setState("olimpico",$this->olimpico);

            return true;
        }
        return false;
    }

    
}