<?php

// Brute force throttling

// IMPORTANT: The session is used for demonstration purposes only.
// A hacker attempting a brute force attack would not bother to send
// cookies, which would mean that you could not use the session
// (which is referenced by a cookie).
// In real life, use a real database.

function record_failed_login($email) {
	$failed_login = find_user_email_in_failed_logins(sql_prep($email));

	if(!isset($failed_login)) {
		// $failed_login = [
		// 	'email' => sql_prep($email),
		// 	'count' => 1,
		// 	'last_time' => time()
		// ];
		$failed_login['email'] = sql_prep($email);
		$failed_login['attempt'] = 1;
		$failed_login['last_time'] = time();
		add_record_to_failed_logins($failed_login);
	} else {
		// existing failed_login record
		$failed_login['attempt'] = $failed_login['attempt'] + 1;
		$failed_login['last_time'] = time();
		update_record_in_failed_logins($failed_login);
	}

	return true;
}

function clear_failed_logins($email) {
	$failed_login = find_user_email_in_failed_logins(sql_prep($email));

	if(isset($failed_login)) {
		$failed_login['attempt'] = 0;
		$failed_login['last_time'] = time();
		update_record_in_failed_logins ($failed_login);
	}

	return true;
}

// Returns the number of minutes to wait until logins
// are allowed again.
function throttle_failed_logins($email) {
	$throttle_at = 5;
	$delay_in_minutes = 1;
	$delay = 60 * $delay_in_minutes;

	$failed_login = find_user_email_in_failed_logins(sql_prep($email));

	// Once failure count is over $throttle_at value,
	// user must wait for the $delay period to pass.
	if(isset($failed_login) && $failed_login['attempt'] >= $throttle_at) {
		$remaining_delay = ($failed_login['last_time'] + $delay) - time();
		$remaining_delay_in_minutes = ceil($remaining_delay / 60);
		return $remaining_delay_in_minutes;
	} else {
		return 0;
	}
}

?>
