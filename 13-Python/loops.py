#!/usr/bin/env python3

print('Content-type: text/html')
print()

for i in range(1, 11):  # 1..10
  print(i)

foods = {'Pizza', 'Curry', 'Egg Salad'}

for i in foods:
  print('<p>I like eating', i, '</p>')

i = 1

while (i <= 10):
  print('<p>No.', i, '</p>')
  i += 1    # No ++i
