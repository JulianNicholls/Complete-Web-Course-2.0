#!/usr/bin/env python3

import cgi

print('Content-type: text/html')
print()

form = cgi.FieldStorage()

if ('name' in form):
  print('Name:', form.getvalue('name'))
else:
  print('the man with no name')

if ('age' in form):
  print('Age:', form.getvalue('age'))
else:
  print('Ageless');
