#!/usr/bin/env python3

from random import randint
import cgi


def makeMessage(guesses, reds, whites):
  if guesses == 0:
    message = 'I have chosen a 4 digit number, can you guess it?'
  elif reds == 4:
    message = 'Well done, you got the number in ' + \
        str(guesses) + ' guesses. <a class="text-warning" href="">Play again</a>'
  else:
    message = '<span class="text-warning mr-4">Guess ' + \
        str(guesses) + ':</span><span class="mr-4">'
    for digit in guess:
      message += digit + ' '

    message += '</span>'

    if reds > 0:
      message += '<span class = "mr-2">'

      for i in range(reds):
        message += '<span class="bg-danger">&nbsp;&nbsp;</span> '

      message += '</span>'

    for i in range(whites):
      message += '<span class="bg-white">&nbsp;&nbsp;</span> '

  return message

print('Content-type: text/html')
print()

form = cgi.FieldStorage()

number = ''

if 'number' in form:
  number = form.getvalue('number')
else:
  for i in range(4):
    number += str(randint(0, 9))

guesses = int(form.getvalue('guesses')) if 'guesses' in form else 0

reds = 0
whites = 0

if 'guess' in form:
  guesses += 1
  guess = form.getvalue('guess')

  for idx, digit in enumerate(guess):
    if digit == number[idx]:
      reds += 1
    else:
      for numberDigit in number:
        if numberDigit == digit:
          whites += 1    
          break
else:
  guess = ''

message = makeMessage(guesses, reds, whites)

print(f"""
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#000000">
    <link rel="stylesheet" href="https://bootswatch.com/4/pulse/bootstrap.min.css">
    <title>Mastermind</title>
  </head>
  <body>
    <div class="container">
      <h1 class="display-4 text-center">Mastermind</h1>

      <h3 class="bg-dark text-white p-2 my-5">%s</h3>

      <form method="post">
        <input type="hidden" name="number" value="%s">
        <input type="hidden" name="guesses" value="%d">
        <input type="text" name="guess" value="%s" autofocus>
        <button type="submit">Guess</button>
      </form>
    </div>
  </body>
</html>
""" %(message, number, guesses, guess))
