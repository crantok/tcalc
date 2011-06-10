import string
import sys

def to_hours( hr_mn_time ) :
  ( hr, mn ) = hr_mn_time.split( ':' )
  return string.atof( hr ) + string.atof( mn ) / 60

args = sys.argv[1:]

print to_hours( "12:34" )
print args
