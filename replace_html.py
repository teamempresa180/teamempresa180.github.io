import os
import re

directories = [
    ".",
    "SITIO GRUPO AGENCIA DIGITAL 180°",
    "SITIO SOFTWARE STUDIO 180°"
]

def replace_in_file(filepath):
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Replace links to .html with .php
        new_content = re.sub(r'href="([^"]+)\.html"', r'href="\1.php"', content)
        new_content = re.sub(r'window\.location\.href\s*=\s*\'([^\']+)\.html\'', r"window.location.href='\1.php'", new_content)
        
        if content != new_content:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(new_content)
            print(f"Updated links in {filepath}")
    except Exception as e:
        print(f"Error processing {filepath}: {e}")

for d in directories:
    for filename in os.listdir(d):
        if filename.endswith(".php") or filename.endswith(".html"):
            filepath = os.path.join(d, filename)
            replace_in_file(filepath)

print("Done.")
