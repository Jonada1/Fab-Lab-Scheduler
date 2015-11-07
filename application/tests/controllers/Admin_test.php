<?php
class Admin_test extends TestCase
{
    public function setUp()
    {
    }

    // access tests
    public function test_access_to_users_page()
    {
        $this->request('GET', ['Admin', 'moderate_users']);
        $this->assertRedirect(404);
		
		$this->request->setCallablePreConstructor(
            function ($CI) {
                // Get mock object
                $auth = $this->getDouble(
                    'aauth', ['is_loggedin' => TRUE]
                );
                // Inject mock object
                $CI->aauth = $auth;
            }
        );
        $this->request('GET', ['Admin', 'moderate_users']);
        $this->assertRedirect(404);
		
		$this->request->setCallablePreConstructor(
            function () {
                // Get mock object
                $auth = $this->getDouble(
                    'aauth', ['is_admin' => TRUE]
                );
                // Inject mock object
                load_class_instance('aauth', $auth);
            }
        );
        $this->request('GET', ['Admin', 'moderate_users']);
        $this->assertResponseCode(200);
    }
	
	//
	// function tests
	//
	
	// delete_user
	
	public function test_delete_user_good_id()
	{
		$this->request->setCallablePreConstructor(
            function () {
                // Get mock object
                $auth = $this->getDouble(
                    'aauth', ['is_admin' => TRUE, 'get_user' => TRUE, 'delete_user' => TRUE]
                );
                // Inject mock object
                load_class_instance('aauth', $auth);
            }
        );
		$output = $this->request('POST', ['Admin', 'delete_user'], ['user_id' => '1']);
		$this->assertContains('true', $output);
	}
	
	public function test_delete_user_invalid_id_or_post_field()
	{
		$this->request->setCallablePreConstructor(
            function () {
                // Get mock object
                $auth = $this->getDouble(
                    'aauth', ['is_admin' => TRUE]
                );
                // Inject mock object
                load_class_instance('aauth', $auth);
            }
        );
		$output = $this->request('POST', ['Admin', 'delete_user'], ['user_id' => '-1']);
		$this->assertContains('false', $output);
		
		$this->request->setCallablePreConstructor(
            function () {
                // Get mock object
                $auth = $this->getDouble(
                    'aauth', ['is_admin' => TRUE]
                );
                // Inject mock object
                load_class_instance('aauth', $auth);
            }
        );
		$output = $this->request('POST', ['Admin', 'delete_user'], ['user_id' => '1;DROP TABLE Machine;']);
		$this->assertContains('false', $output);
		$output = $this->request('POST', ['Admin', 'delete_user'], ['echo' => '-1']);
		$this->assertContains('false', $output);
	}
	
	// ban user
	
	public function test_ban_user_good_id()
	{
		$this->request->setCallablePreConstructor(
            function () {
                // Get mock object
                $auth = $this->getDouble(
                    'aauth', ['is_admin' => TRUE, 'get_user' => TRUE, 'ban_user' => TRUE]
                );
                // Inject mock object
                load_class_instance('aauth', $auth);
            }
        );
		$output = $this->request('POST', ['Admin', 'ban_user'], ['user_id' => '1']);
		$this->assertContains('true', $output);
	}
	
	public function test_ban_user_invalid_id_or_post_field()
	{
		$this->request->setCallablePreConstructor(
            function () {
                // Get mock object
                $auth = $this->getDouble(
                    'aauth', ['is_admin' => TRUE]
                );
                // Inject mock object
                load_class_instance('aauth', $auth);
            }
        );
		$output = $this->request('POST', ['Admin', 'ban_user'], ['user_id' => '-1']);
		$this->assertContains('false', $output);
		
		$this->request->setCallablePreConstructor(
            function () {
                // Get mock object
                $auth = $this->getDouble(
                    'aauth', ['is_admin' => TRUE]
                );
                // Inject mock object
                load_class_instance('aauth', $auth);
            }
        );
		$output = $this->request('POST', ['Admin', 'ban_user'], ['user_id' => '1;DROP TABLE Machine;']);
		$this->assertContains('false', $output);
		$output = $this->request('POST', ['Admin', 'ban_user'], ['echo' => '-1']);
		$this->assertContains('false', $output);
	}
	
	// unban user
	
	public function test_unban_user_good_id()
	{
		$this->request->setCallablePreConstructor(
            function () {
                // Get mock object
                $auth = $this->getDouble(
                    'aauth', ['is_admin' => TRUE, 'get_user' => TRUE, 'unban_user' => TRUE]
                );
                // Inject mock object
                load_class_instance('aauth', $auth);
            }
        );
		$output = $this->request('POST', ['Admin', 'unban_user'], ['user_id' => '1']);
		$this->assertContains('true', $output);
	}
	
	public function test_unban_user_invalid_id_or_post_field()
	{
		$this->request->setCallablePreConstructor(
            function () {
                // Get mock object
                $auth = $this->getDouble(
                    'aauth', ['is_admin' => TRUE]
                );
                // Inject mock object
                load_class_instance('aauth', $auth);
            }
        );
		$output = $this->request('POST', ['Admin', 'unban_user'], ['user_id' => '-1']);
		$this->assertContains('false', $output);
		
		$this->request->setCallablePreConstructor(
            function () {
                // Get mock object
                $auth = $this->getDouble(
                    'aauth', ['is_admin' => TRUE]
                );
                // Inject mock object
                load_class_instance('aauth', $auth);
            }
        );
		$output = $this->request('POST', ['Admin', 'unban_user'], ['user_id' => '1;DROP TABLE Machine;']);
		$this->assertContains('false', $output);
		$output = $this->request('POST', ['Admin', 'unban_user'], ['echo' => '-1']);
		$this->assertContains('false', $output);
	}
	public function test_schedule_copy_invalid_request_get()
	{
		$this->request->setCallablePreConstructor(
				function () {
					// Get mock object
					$auth = $this->getDouble(
							'aauth', ['is_admin' => TRUE]
							);
					// Inject mock object
					load_class_instance('aauth', $auth);
				}
				);
		$output = $this->request('GET', ['Admin', 'schedule_copy'], ['startDate' => '2010-11-11 02:00:00', 'endDate' => '2010-12-12 02:00:00', 'copyStartDate' => '2010-12-15 02:00:00' ]);
		$this->assertNull($output);
	}
	public function test_schedule_delete_invalid_request_get()
	{
		$this->request->setCallablePreConstructor(
				function () {
					// Get mock object
					$auth = $this->getDouble(
							'aauth', ['is_admin' => TRUE]
							);
					// Inject mock object
					load_class_instance('aauth', $auth);
				}
				);
		$output = $this->request('GET', ['Admin', 'schedule_delete'], ['startDate' => '2010-11-11 02:00:00', 'endDate' => '2010-12-12 02:00:00', 'copyStartDate' => '2010-12-15 02:00:00' ]);
		$this->assertNull($output);
	}
}