#!/usr/bin/env ruby

=begin

  tcalc.rb - perform calculations with times
  
  Written by justin@ecobee.org
  
  Add, subtract, multiply or divide two times written in hours:minutes format.

=end

def to_hours hr_min
  hours, minutes = hr_min.split( ':', 2 )
  hours.to_f + minutes.to_f/60
end

if ARGV.length < 3
  puts 'Usage... tcalc hh:mm [+-x/] hh:mm'
  Process.exit
end

hrs1 = to_hours(ARGV[0])
hrs2 = to_hours(ARGV[2])

# replace the character 'x' with a multiplication symbol
operator = ARGV[1] == 'x' ? '*' : ARGV[1]

equation = "#{hrs1} #{operator} #{hrs2}"
result = eval equation

pretty_eqn = sprintf "%.3f %s %.3f", hrs1, ARGV[1], hrs2
pretty_result = sprintf "%.3f", result
puts pretty_eqn + ' = ' + pretty_result + ' hours'
