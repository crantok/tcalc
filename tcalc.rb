#!/usr/bin/env ruby

=begin

  tcalc.rb - Perform calculations with times in hh:mm format.
  
  Written by justin@ecobee.org / justin.hellings@gmail.com
  
=end

def to_hours hr_min
  hours, minutes = hr_min.split( ':', 2 )
  hours.to_f + minutes.to_f/60
end

def calc_and_out hr_min_eqn
#puts hr_min_eqn
  sanitised_hrs_min_eqn = hr_min_eqn.gsub( /(x)/, '*' )
#puts sanitised_hrs_min_eqn
  hrs_eqn = sanitised_hrs_min_eqn.gsub( /([.:\d]+)/ ) { (to_hours $1).to_s }
#puts hrs_eqn
  pretty_hrs_eqn = hr_min_eqn.gsub( /([.:\d]+)/ ) { sprintf( '%.3f', (to_hours $1).to_s ) }
#puts pretty_hrs_eqn
  result = eval hrs_eqn
#puts result
  pretty_result = sprintf( "%.3f", result )
#puts pretty_result
  puts '=> ' + pretty_result + ' <= ' + pretty_hrs_eqn
end


if ARGV.length > 0
  hrs_min_eqn = ARGV.join ' '
  calc_and_out hrs_min_eqn
else
  while true
    input = gets.chomp
    if input.empty?
      next
    elsif [ 'q', 'quit', 'exit' ].include? input.downcase
      break
    else
      begin
        calc_and_out input
      rescue Exception=>e
        puts 'Evaluation error'
      end
    end
  end
end
