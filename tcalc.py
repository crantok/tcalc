#!/usr/bin/env python
#
# tcalc.py - Perform calculations with times in hh:mm format.
#  
# Written by justin@ecobee.org / justin.hellings@gmail.com
#

import string
import sys
import re

def to_hours( hr_mn ) :
  ( hr, mn ) = hr_mn.group().split( ':' )
  return float( '0' + hr ) + float( '0' + mn ) / 60

def calc_and_out( hr_min_eqn ) :
  #print hr_min_eqn
  hr_min_eqn = re.sub( 'x', '*', hr_min_eqn )
  #print hr_min_eqn
  regex = re.compile( r'[.:\d]+' )
  hrs_eqn = regex.sub( lambda m: str( to_hours(m) ), hr_min_eqn )
  #print hrs_eqn
  pretty_hrs_eqn = regex.sub( lambda m: ( '%.3f' % to_hours(m) ), hr_min_eqn )
  #print pretty_hrs_eqn
  result = eval( hrs_eqn )
  #print result
  pretty_result = "%.3f" % result
  #print pretty_result
  print '=> ' + pretty_result + ' <= ' + pretty_hrs_eqn


if len( sys.argv ) > 1 :
  calc_and_out( ' '.join( sys.argv[1:] ) )
else :
  while True :
    input = raw_input()
    if not input :
      next
    elif input.lower() in [ 'q', 'quit', 'exit' ] :
      break
    else :
      try :
        calc_and_out( input )
      except :
        print 'Evaluation error'
