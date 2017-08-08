<?php 

namespace PaschalDev\Laravauth\Traits;

use Hash;
use Laravauth;

trait UsesPassword{

	/**
     * Checks if the password in the request matches with the
     * user's password.
     *
     * @return bool
     */
	public function passwordMatch(){

		return Hash::check( $this->request->{Laravauth::getPasswordID()}, 
			$this->user->{Laravauth::getPasswordIDRelationship()} );
	}
}