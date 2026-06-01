import os

with open(r'c:\Users\lizar\Desktop\download\admin.php', 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace(r'\$', '$')
content = content.replace(r'\`', '`')

with open(r'c:\Users\lizar\Desktop\download\admin.php', 'w', encoding='utf-8') as f:
    f.write(content)
print("Fix applied")
