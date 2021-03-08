<?php
// Escapes a string to render it safe for SQL.
// Assumes your database connection is assigned to $database.
// Modify this if you use something else ($db, $sqli, $mysql, etc.).
function sql_prep($string) {
	global $db;
	if($db) {
		return mysqli_real_escape_string($db, $string);
	} else {
		// addslashes is almost the same, but not quite as secure.
		// Fallback only when there is no database connection available.
		return addslashes($string);
	}
}
?>