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
  $hr_mn_times = array();
  preg_match_all( '#[.:\d]+#', $sanitised_hrs_min_eqn, $hr_mn_times );
  $hr_times = array();
  foreach( $hr_mn_times[0] as $hr_mn_time ) {
    $hr_times[] = to_hours( $hr_mn_time );
  }
  $hrs_eqn = str_replace( $hr_mn_times[0], $hr_times, $sanitised_hrs_min_eqn );
//echo $hrs_eqn . "\n";
  $pretty_hr_times = array();
  foreach( $hr_times as $hr_time ) {
    $pretty_hr_times[] = sprintf( '%.3f',  $hr_time );
  }
  $pretty_hrs_eqn = str_replace( $hr_mn_times[0], $pretty_hr_times, $sanitised_hrs_min_eqn );
//echo $pretty_hrs_eqn . "\n";
  $result = eval( 'return ' . $hrs_eqn . ';' );
//echo $result . "\n";
  $pretty_result = sprintf( "%.3f", $result );
//echo $pretty_result . "\n";
  echo '=> ' . $pretty_result . ' <= ' . $pretty_hrs_eqn . "\n";
}

// Get rid of script name.
array_shift( $argv );

$raw_eqn = implode( ' ', $argv );

calc_and_out( $raw_eqn );
