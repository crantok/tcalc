
/**
 * tcalc.js - Perform calculations with times in hh:mm format.
 * 
 * NOTE: I've tested this script using rhino cli, hence the java I/O code.
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

// Seem to need to pull in java packages to provide IO :-(
importPackage(java.io);
importPackage(java.lang);


function to_hours( hr_mn ) {
  components = hr_mn.split( ':', 2 );
  return parseFloat( '0' + components[0] ) + parseFloat( '0' + components[1] ) / 60;
}

function calc_and_out( hr_min_eqn ) {
//print( hr_min_eqn );

  hr_min_eqn = hr_min_eqn.replace( 'x', '*' );
//print( hr_min_eqn );
  
  var hr_min_times = hr_min_eqn.match( /[.\d]*:[.\d]*/g );

  var hrs_eqn = hr_min_eqn;
  for ( var idx in hr_min_times ) {
    hrs_eqn = hrs_eqn.replace(
      hr_min_times[idx],
      to_hours( hr_min_times[idx] )
    );
  }
//print( hrs_eqn );
  
  var pretty_hrs_eqn = hr_min_eqn;
  for ( var idx in hr_min_times ) {
    pretty_hrs_eqn = pretty_hrs_eqn.replace(
      hr_min_times[idx],
      to_hours( hr_min_times[idx] ).toFixed(3)
    );
  }
//print( pretty_hrs_eqn );
  
  result = eval( hrs_eqn );
//print( result );
  pretty_result = result.toFixed(3);
//print( pretty_result );
  print( '=> ' + pretty_result + ' <= ' + pretty_hrs_eqn );
}

stdin = new BufferedReader( new InputStreamReader(System['in']) );

while ( true ) {
  var input = String( stdin.readLine() );

  if ( input === '' ) {
    continue;
  }
  else if ( -1 != [ 'q', 'quit', 'exit' ].indexOf( input.toLowerCase() ) ) {
    break;
  }
  else {
    try {
      calc_and_out( input );
    }
    catch (e) {
      System.out.println( 'Evaluation error' );
    }
  }
}
