#!/usr/bin/env python3

print('Content-type: text/html')
print()

ages = {'Julian': 51, 'Tara': 21, 'Clara': 47}

for i in ages:
  print('<p>', i, ':', ages[i], '</p>')
