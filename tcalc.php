#!/usr/bin/env php
<?php

/**
 * tcalc.php - Perform calculations with times in hh:mm format.
 * 
 * Written by justin@ecobee.org / justin.hellings@gmail.com
*/

function to_hours( $hr_min ) {
  list( $hours, $minutes ) = explode( ':', $hr_min, 2 );
  return ( 1.0 * $hours ) + ( $minutes / 60.0 );
}

function calc_and_out( $hr_min_eqn ) {
//echo $hr_min_eqn . "\n";

  $sanitised_hrs_min_eqn = str_replace( 'x', '*', $hr_min_eqn );
//echo $sanitised_hrs_min_eqn . "\n";

  // Find all times that are expressed as [hh]:[mm]
  // NOTE: Making sure at least one colon in string, else explode() complains.
  $hr_mn_times = array();
  preg_match_all( '#[.\d]*:[.\d]*#', $sanitised_hrs_min_eqn, $hr_mn_times );
  
  // Convert hh:mm times to regexes, in order to replace them in the original
  // string.
  $hr_mn_regexes = array();
  foreach( $hr_mn_times[0] as $hr_mn_time ) {
    $hr_mn_regexes[] = '#' . $hr_mn_time . '#';
  }
  
  // We will use preg_replace rather than a plain string replace function
  // because preg_replace has the facility to limit the number of times each
  // replacement is performed. e.g...
  // Plain string replace:
  //    1: + 1:30  =>  1.0 + 1.030
  // Regex, single replacement only.
  //    1: + 1:30  =>  1.0 + 1.5

  // Get times in hours from from times in hh:mm format, and replace.
  $hr_times = array();
  foreach( $hr_mn_times[0] as $hr_mn_time ) {
    $hr_times[] = to_hours( $hr_mn_time );
  }
  $hrs_eqn = preg_replace( $hr_mn_regexes, $hr_times, $sanitised_hrs_min_eqn, 1 );
//echo $hrs_eqn . "\n";

  // Get times in hours, but with a maximum of 3 decimal places, from from times
  // in hh:mm format, and replace. The new string is for readable output.
  $pretty_hr_times = array();
  foreach( $hr_times as $hr_time ) {
    $pretty_hr_times[] = sprintf( '%.3f',  $hr_time );
  }
  $pretty_hrs_eqn = preg_replace(
    $hr_mn_regexes, $pretty_hr_times, $sanitised_hrs_min_eqn, 1 );
//echo $pretty_hrs_eqn . "\n";

  @$result = eval( 'return ' . $hrs_eqn . ';' );
//echo $result . "\n";

  if ( $result ) {
    $pretty_result = sprintf( "%.3f", $result );
//echo $pretty_result . "\n";

    echo '=> ' . $pretty_result . ' <= ' . $pretty_hrs_eqn . "\n";
  }
  else {
    print "Evaluation error\n";
  }
}


if ( count( $argv ) > 1 ) {

  array_shift( $argv );   // Get rid of script name.
  $raw_eqn = implode( ' ', $argv );
  calc_and_out( $raw_eqn );
}
else {
  while ( TRUE ) {
    $input = trim(fgets(STDIN));
    if ( ! $input ) {
      continue;
    }
    elseif ( in_array( strtolower( $input ), array( 'q', 'quit', 'exit' ) ) ) {
      break;
    }
    else {
      calc_and_out( $input );
    }
  }
}
