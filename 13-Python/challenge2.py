#!/usr/bin/env python3

print('Content-type: text/html')
print()

primes = [2, *range(3, 10001, 2)]

for div in primes:
  idx = div + 1

  while(idx < len(primes)):
    if (primes[idx] % div == 0):
      del primes[idx]

    idx += 1

print(primes)
