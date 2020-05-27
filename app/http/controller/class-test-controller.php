<?php
namespace App\Http\Controller;

use Mantle\Framework\Facade\Request;

class Test_Controller {
	public function method( Request $request ) {
		var_dump('aaaa', $request);exit;
	}
}
