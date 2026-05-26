import os
import glob

# Standard CP1252 mapping for positions 0x80 to 0x9F
cp1252_map = {
    0x80: 0x20AC, 0x82: 0x201A, 0x83: 0x0192, 0x84: 0x201E,
    0x85: 0x2026, 0x86: 0x2020, 0x87: 0x2021, 0x88: 0x02C6,
    0x89: 0x2030, 0x8A: 0x0160, 0x8B: 0x2039, 0x8C: 0x0152,
    0x8E: 0x017D, 0x91: 0x2018, 0x92: 0x2019, 0x93: 0x201C,
    0x94: 0x201D, 0x95: 0x2022, 0x96: 0x2013, 0x97: 0x2014,
    0x98: 0x02DC, 0x99: 0x2122, 0x9A: 0x0161, 0x9B: 0x203A,
    0x9C: 0x0153, 0x9E: 0x017E, 0x9F: 0x0178
}
cp1252_reverse_map = {val: key for key, val in cp1252_map.items()}

def char_to_byte(c):
    o = ord(c)
    if o in cp1252_reverse_map:
        return cp1252_reverse_map[o]
    elif o <= 0xFF:
        return o
    else:
        raise ValueError(f"Cannot map character U+{o:04X} to byte")

def fix_selective_double_utf8(filepath):
    """
    Robustly decodes double UTF-8 encoded sequences (2, 3, and 4-byte sequences)
    that were interpreted as CP1252 and saved in UTF-8.
    """
    try:
        with open(filepath, 'rb') as f:
            raw = f.read()
        
        # Try decoding as strict UTF-8
        try:
            text = raw.decode('utf-8')
        except UnicodeDecodeError:
            return False, "Not valid UTF-8, skipped"

        fixed_chars = []
        i = 0
        n = len(text)
        new_text_list = []
        
        while i < n:
            # 1. Check 4-character sequence first (4-byte UTF-8, like emojis)
            if i < n - 3:
                try:
                    c1, c2, c3, c4 = text[i], text[i+1], text[i+2], text[i+3]
                    o1 = char_to_byte(c1)
                    o2 = char_to_byte(c2)
                    o3 = char_to_byte(c3)
                    o4 = char_to_byte(c4)
                    if 0xF0 <= o1 <= 0xF4 and all(0x80 <= o <= 0xBF for o in (o2, o3, o4)):
                        b = bytes([o1, o2, o3, o4])
                        decoded = b.decode('utf-8')
                        new_text_list.append(decoded)
                        # We sanitize representations to print safely
                        fixed_chars.append(f"Emoji4->{decoded}")
                        i += 4
                        continue
                except Exception:
                    pass

            # 2. Check 3-character sequence (3-byte UTF-8, like emoticons/symbols)
            if i < n - 2:
                try:
                    c1, c2, c3 = text[i], text[i+1], text[i+2]
                    o1 = char_to_byte(c1)
                    o2 = char_to_byte(c2)
                    o3 = char_to_byte(c3)
                    if 0xE0 <= o1 <= 0xEF and all(0x80 <= o <= 0xBF for o in (o2, o3)):
                        b = bytes([o1, o2, o3])
                        decoded = b.decode('utf-8')
                        new_text_list.append(decoded)
                        fixed_chars.append(f"Sym3->{decoded}")
                        i += 3
                        continue
                except Exception:
                    pass

            # 3. Check 2-character sequence (2-byte UTF-8, like Spanish accented letters)
            if i < n - 1:
                try:
                    c1, c2 = text[i], text[i+1]
                    o1 = char_to_byte(c1)
                    o2 = char_to_byte(c2)
                    if 0xC2 <= o1 <= 0xDF and 0x80 <= o2 <= 0xBF:
                        b = bytes([o1, o2])
                        decoded = b.decode('utf-8')
                        new_text_list.append(decoded)
                        fixed_chars.append(f"{c1}{c2}->{decoded}")
                        i += 2
                        continue
                except Exception:
                    pass

            new_text_list.append(text[i])
            i += 1

        if len(fixed_chars) > 0:
            fixed_text = "".join(new_text_list)
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(fixed_text)
            return True, f"Fixed {len(fixed_chars)} sequences: {', '.join(fixed_chars[:5])}"
        else:
            return False, "No double UTF-8 sequences found"
            
    except Exception as e:
        return False, f"Error: {str(e)}"

# Find all files in base directory recursively
base = r'c:\Users\lizar\Desktop\download'
extensions = ['*.php', '*.css', '*.html', '*.js']
files_to_fix = []

for ext in extensions:
    files_to_fix.extend(glob.glob(os.path.join(base, '**', ext), recursive=True))

print(f"Found {len(files_to_fix)} files to inspect.")
fixed_count = 0

for filepath in files_to_fix:
    rel = os.path.relpath(filepath, base)
    success, msg = fix_selective_double_utf8(filepath)
    status = "[FIXED]" if success else "[skip]"
    try:
        print(f"  {status}  {rel}  - {msg}")
    except Exception:
        # fallback printing
        sanitized = msg.encode('ascii', errors='replace').decode('ascii')
        print(f"  {status}  {rel}  - {sanitized}")
    if success:
        fixed_count += 1

print(f"\nEncoding repair complete! Fixed {fixed_count} / {len(files_to_fix)} files.")
