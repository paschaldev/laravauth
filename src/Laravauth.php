<?php 

namespace PaschalDev\Laravauth;

/**
*
*/
class Laravauth
{
	
	/**
     * Gets the login identifier from the config to be used for login. 
     * Fallsback to a safe default - 'username' if the value is not 
     * valid.
     *
     * @return string
     */
	public function getLoginID()
     {
		return config('laravauth.login_id') ? config('laravauth.login_id') : 'username';
	}
     
     /**
     * Gets the login identifier relationship. 
     * Fallsback to a safe default - 'email' if the value is not 
     * valid.
     *
     * @return string
     */
     public function getLoginIDRelationship()
     {
          return config('laravauth.login_id_rel') ? config('laravauth.login_id_rel') : 'email';
     }

     /**
     * Gets the password identifier from the config to be used for login. 
     * Fallsback to a safe default - 'password' if the value is not 
     * valid.
     *
     * @return string
     */
     public function getPasswordID()
     {
          return config('laravauth.password_id') ? config('laravauth.password_id') : 'password';
     }
     
     /**
     * Gets the Password identifier relationship. 
     * Fallsback to a safe default - 'password' if the value is not 
     * valid.
     *
     * @return string
     */
     public function getPasswordIDRelationship()
     {
          return config('laravauth.password_rel') ? config('laravauth.password_rel') : 'password';
     }

     /**
     * Gets the auth method class name. The config value is converted to 'camelCase'
     * and the first letter is converted to uppercase to represent the class name. 
     *
     * @return string
     */
     public function getAuthMethodClass()
     {
          return laravauth_class_format( config('laravauth.auth_method') );
     }

     /**
     * Gets the auth method class name. The config value is converted to 'camelCase'
     * and the first letter is converted to uppercase to represent the class name. 
     *
     * @return string
     */
     public function getAuthMethodInstance($request)
     {    
          $authMethodInstance = laravauth_class_namespace('Auth', $this->getAuthMethodClass() );

          return new $authMethodInstance( $request );
     }

     /**
     * Gets the User model used by the application.
     *
     * @return string
     */
     public function getUserModel()
     {
          $userModel = config('laravauth.user_model');

          if( ! class_exists($userModel) )
          {
               throw new \Exception("The 'user_model' value you specified in the config file does not exist.", 1);
          }

          return new $userModel;
     }

     /**
     * Gets single User model from the provided where clause
     * and value.
     *
     * @param string $value
     * @return string
     */
     public function getSingleUserModel($value)
     {
          return $this->getUserModel()->where( $this->getLoginIDRelationship() , $value)->first();
     }

     /**
     * Gets the table name used by the model
     *
     * @return string
     */
     public function getUserModelTableName()
     {    
          return $this->getUserModel()->getTable();
     }

     /**
     * Gets the validator URI for Token based auth
     *
     * @return string
     */
     public function getValidatorURI(){

          return config('app.url').'/'.config('laravauth.validator_route').'?'.laravauth_token_var_name().'=';
     }
}