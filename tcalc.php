#!/usr/bin/env php
<?php

/**
  tcalc.php - perform calculations with times
  
  Written by justin@ecobee.org
  
  Add, subtract, multiply or divide two times written in hours:minutes format.

*/

function to_hours( $hr_min ) {
  list( $hours, $minutes ) = explode( ':', $hr_min, 2 );
  return ( 1.0 * $hours ) + ( $minutes / 60.0 );
}

if ( count( $argv ) < 4 ) {
  echo "Usage...  " . $argv[0] . "  hh:mm  [+-x/]  hh:mm\n";
  exit( 1 );
}

$hrs1 = to_hours($argv[1]);
$hrs2 = to_hours($argv[3]);

// replace the character 'x' with a multiplication symbol
$operator = $argv[2] == 'x' ? '*' : $argv[2];

$equation = "return $hrs1 $operator $hrs2;";
$result = eval( $equation );

$pretty_eqn = sprintf( "%.3f %s %.3f", $hrs1, $argv[2], $hrs2 );
$pretty_result = sprintf( "%.3f", $result );
echo $pretty_eqn . ' = ' . $pretty_result . " hours\n";
