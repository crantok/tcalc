
These tcalc.* scripts can be used in one of two ways:

1) Execute a single calculation on the command line.
2) Use the script in an interactive mode.


Option 1 - single command line 
------------------------------

I don't know how to use option (1) on windows. On linux, you can make the script
executable (if it isn't already) and then run something like the following...

  ./tcalc.xxx 12:12 - 08:42 + :12

...which takes the difference between two times and adds 12 minutes.

NOTES: You can escape the multiplication symbol '*' and parentheses '(' and ')'
using the backslash, e.g.

  ./tcalc.xxx \( 12:12 - 08:42 \) \* 2

You can also use a lower case 'x' to denote multiplication, e.g.

  ./tcalc.xxx \( 12:12 - 08:42 \) x 2

You can avoid escaping characters by enclosing the expression in quotes, e.g.

  ./tcalc.xxx "( 12:12 - 08:42 ) * 2"


Option 2 - interactive mode
---------------------------

If you start one of the scripts without any command line parameters then you
will be dropped in to an interactive mode. Every time you press the enter key,
the text you have types on that line will be evaluated as an expression. You do
not need to escape special characters in this mode. To exit the script, you can
type 'q', 'quit' or 'exit'. The exit commands are not case sensitive.


