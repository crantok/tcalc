importPackage(java.io);
importPackage(java.lang);

function to_hours( hr_mn ) {
  components = hr_mn.split( ':', 2 );
  return parseFloat( components[0] ) + parseFloat( components[1] ) / 60;
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
