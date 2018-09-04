#!/usr/bin/env python3

print('Content-type: text/html')
print()

def hcf(x, y):
  min = x if x < y else y;

  for div in range(min, 0, -1):
    if x % div == 0 and y % div == 0:
      return div

print('<p>(1000, 1200):', hcf(1000, 1200), '</p>')
print('<p>(2903, 6679):', hcf(2903, 6679), '</p>')
