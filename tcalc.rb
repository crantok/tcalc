#!/usr/bin/env ruby

=begin

  tcalc.rb - Perform calculations with times in hh:mm format.
  
  Copyright 2011 Justin Hellings justin@ecobee.org/justin.hellings@gmail.com
  
  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
  
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
