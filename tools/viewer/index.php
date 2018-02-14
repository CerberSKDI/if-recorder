<!DOCTYPE html>
<html>
<head>
<title>Transcript viewer</title>

<meta charset="utf-8">
<meta name="Robots" content="noindex,nofollow" />

</head>
<body>
<?php 
include_once( '../include/db.php' );

$query = $db->query( "SELECT * FROM {$dbSettings[ 'prefix' ]}stories WHERE 1 ORDER BY started DESC" ) or database_error( $db->errorInfo() );

$statusline = 'off';

if( !empty( $_GET[ 'statusline' ] ) ) {
	$statusline = $_GET[ 'statusline' ];
}

?>

<div style="float:right;">
	<div>
		Status lines: <strong><?php 
			if( $statusline == 'inline' ) { 
				echo 'ON';
			}
			else {
				echo 'OFF';
			}
		?></strong>
	</div>
	<div>
		<a href="<?php echo $_SERVER[ 'PHP_SELF' ]; ?>?statusline=<?php 
		 if( $statusline == 'inline' ) { 
				echo 'off';
			}
			else {
				echo 'inline';
			}
		?>">change</a>
	</div>
</div>

<?php 

if( empty( $query ) ) {
	echo '<h1>No transcripts in the database</h1>';
} 
else {
	echo '<ul id="status'.$statusline.'">';

	foreach( $query as $q ) {
		echo '<li>';
		echo '<a href="transcript.php?'.
		 "session={$q[ 'session' ]}&statusline=$statusline".
		 '">'.
		 $q[ 'story' ].
		 '</a>'.
		 " ({$q[ 'started' ]}; {$q[ 'inputcount' ]} turn".( $q[ 'inputcount' ] != 1 ? 's' : '' ).")";
	 	echo '</li>';
	}
	
	echo '</ul>';
}
?>

</body>
</html>