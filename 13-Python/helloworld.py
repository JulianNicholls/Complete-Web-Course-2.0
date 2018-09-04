#!/usr/bin/python3

print('Content-type: text/html')
print()

# Strings

str = "Test String"

print('<p>String: ', str, '</p>') # Whole string
print('<p>str[3]: ', str[3], '</p>') # 4th character
print('<p>str[0:5]: "', str[0:5], '"</p>') # 0-4th character
print('<p>str[0:7]: "', str[0:7], '"</p>') # 0-6th character
print('<p>str[1:7]: "', str[1:7], '"</p>') # 1-6th character

# Lists (Arrays)

mylist = ['Julian', 'Tara', 'Clara'];

print('<p>List: ', mylist, '</p>') # Whole array
print('<p>List[1]: ', mylist[1], '</p>')
print('<p>List[0:2]: ', mylist[0:2], '</p>')

# Tuples (Read-only lists)

mytuple = {1, 2, 3, 4}

print('<p>Tuple: ', mytuple, '</p>') # Whole tuple

# Dictionary

dict = {}
dict['dad'] = 'Julian'
dict[1] = 'Tara'
dict['home'] = 'Bournemouth'

print('<p>Dictionary: ', dict, '</p>') # Whole tuple
print('<p>Dictionary keys: ', dict.keys(), '</p>') # Whole tuple
print('<p>Dictionary values: ', dict.values(), '</p>') # Whole tuple
