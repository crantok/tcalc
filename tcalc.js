
function to_hours( hr_mn ) {
  components = hr_mn.split( ':', 2 );
  return parseFloat( components[0] ) + parseFloat( components[1] ) / 60;
}

print( to_hours( "2:30" ) );
