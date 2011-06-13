#!/usr/bin/env php
<?php

/**
 * tcalc.php - Perform calculations with times in hh:mm format.
 * 
 * Copyright 2011 Justin Hellings justin@ecobee.org/justin.hellings@gmail.com
 * 
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
  // NOTE: Implementations in other languages use a simpler regex but explode()
  // complains if we try to split a string on colons where no colons occur.
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

  // PHP eval() does not raise an exception on failure so this script is
  // structurally slightly different from the others.
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
