import os
import re

def process_file(file_path, replacements, sections_to_keep, sections_to_remove):
    if not os.path.exists(file_path):
        print(f"File not found: {file_path}")
        return
        
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # 1. Replace Navigation links
    for old, new in replacements:
        content = content.replace(old, new)
        
    # 2. Remove specified sections
    for sec_pattern in sections_to_remove:
        content = re.sub(sec_pattern, '', content, flags=re.DOTALL)
        
    return content

# -------------------------------------------------------------------
# 1. Grupo Empresarial
# -------------------------------------------------------------------
base_dir_1 = r"c:\Users\lizar\Desktop\download"
file_1 = os.path.join(base_dir_1, "index.html")

nav_reps_1 = [
    ('<a href="#inicio">Inicio</a>', '<a href="index.html">Inicio</a>'),
    ('<a href="#unidades-de-negocio">Unidades de negocio</a>', '<a href="unidades.html">Unidades de negocio</a>'),
    ('<a href="#nosotros">Nosotros</a>', '<a href="nosotros.html">Nosotros</a>'),
    ('<a href="#contacto">Contáctenos</a>', '<a href="contacto.html">Contáctenos</a>'),
    ('href="#unidades-de-negocio"', 'href="unidades.html"'), # Update CTA buttons in hero
    ('href="#contacto"', 'href="contacto.html"') # Update CTA buttons elsewhere
]

# Patterns for Grupo Empresarial
p_inicio_1 = r'<section id="inicio".*?</section>'
p_unidades_1 = r'<section id="unidades-de-negocio".*?</section>'
p_nosotros_1 = r'<section id="nosotros".*?</section>\s*<section class="testimonial-section.*?</section>'
p_cta_1 = r'<div style="text-align: center; padding: 20px 40px 80px; display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">.*?</div>'
p_footer_1 = r'<footer id="contacto".*?</footer>'

# index.html
content = process_file(file_1, nav_reps_1, [], [p_unidades_1, p_nosotros_1])
with open(os.path.join(base_dir_1, "index.html"), "w", encoding="utf-8") as f: f.write(content)

# unidades.html
with open(file_1, 'r', encoding='utf-8') as f: orig_content_1 = f.read()
content = process_file(file_1, nav_reps_1, [], [p_inicio_1, p_nosotros_1, p_cta_1])
with open(os.path.join(base_dir_1, "unidades.html"), "w", encoding="utf-8") as f: f.write(content)

# nosotros.html
content = process_file(file_1, nav_reps_1, [], [p_inicio_1, p_unidades_1, p_cta_1])
with open(os.path.join(base_dir_1, "nosotros.html"), "w", encoding="utf-8") as f: f.write(content)

# contacto.html (Just keep the footer as the main content, remove other sections)
content = process_file(file_1, nav_reps_1, [], [p_inicio_1, p_unidades_1, p_nosotros_1, p_cta_1])
with open(os.path.join(base_dir_1, "contacto.html"), "w", encoding="utf-8") as f: f.write(content)


# -------------------------------------------------------------------
# 2. Agencia Digital
# -------------------------------------------------------------------
base_dir_2 = r"c:\Users\lizar\Desktop\download\SITIO GRUPO AGENCIA DIGITAL 180°"
file_2 = os.path.join(base_dir_2, "index.html")

nav_reps_2 = [
    ('<a href="#nosotros" class="nav-link">Nosotros</a>', '<a href="nosotros.html" class="nav-link">Nosotros</a>'),
    ('<a href="#servicios" class="nav-link">Servicios</a>', '<a href="servicios.html" class="nav-link">Servicios</a>'),
    ('<a href="#proceso" class="nav-link">Proceso</a>', '<a href="proceso.html" class="nav-link">Proceso</a>'),
    ('<a href="#contacto" class="nav-link cta-nav">Contacto</a>', '<a href="contacto.html" class="nav-link cta-nav">Contacto</a>'),
    ('href="#nosotros"', 'href="nosotros.html"'),
    ('href="#servicios"', 'href="servicios.html"'),
    ('href="#proceso"', 'href="proceso.html"'),
    ('href="#contacto"', 'href="contacto.html"')
]

p_inicio_2 = r'<section id="inicio".*?</section>'
p_marquee_2 = r'<div class="marquee-container">.*?</div>'
p_nosotros_2 = r'<section id="nosotros".*?</section>'
p_servicios_2 = r'<section id="servicios".*?</section>'
p_proceso_2 = r'<section id="proceso".*?</section>'
p_contacto_2 = r'<section id="contacto" class="cta-section">.*?</section>'

with open(file_2, 'r', encoding='utf-8') as f: orig_content_2 = f.read()

# index.html
content = process_file(file_2, nav_reps_2, [], [p_nosotros_2, p_servicios_2, p_proceso_2, p_contacto_2])
with open(os.path.join(base_dir_2, "index.html"), "w", encoding="utf-8") as f: f.write(content)

# nosotros.html
content = process_file(file_2, nav_reps_2, [], [p_inicio_2, p_marquee_2, p_servicios_2, p_proceso_2, p_contacto_2])
with open(os.path.join(base_dir_2, "nosotros.html"), "w", encoding="utf-8") as f: f.write(content)

# servicios.html
content = process_file(file_2, nav_reps_2, [], [p_inicio_2, p_marquee_2, p_nosotros_2, p_proceso_2, p_contacto_2])
with open(os.path.join(base_dir_2, "servicios.html"), "w", encoding="utf-8") as f: f.write(content)

# proceso.html
content = process_file(file_2, nav_reps_2, [], [p_inicio_2, p_marquee_2, p_nosotros_2, p_servicios_2, p_contacto_2])
with open(os.path.join(base_dir_2, "proceso.html"), "w", encoding="utf-8") as f: f.write(content)

# contacto.html
content = process_file(file_2, nav_reps_2, [], [p_inicio_2, p_marquee_2, p_nosotros_2, p_servicios_2, p_proceso_2])
with open(os.path.join(base_dir_2, "contacto.html"), "w", encoding="utf-8") as f: f.write(content)


# -------------------------------------------------------------------
# 3. Software Studio
# -------------------------------------------------------------------
base_dir_3 = r"c:\Users\lizar\Desktop\download\SITIO SOFTWARE STUDIO 180°"
file_3 = os.path.join(base_dir_3, "index.html")

nav_reps_3 = [
    ('<a href="#servicios" class="nav-link">Servicio</a>', '<a href="servicios.html" class="nav-link">Servicio</a>'),
    ('<a href="#proceso" class="nav-link">Proceso</a>', '<a href="proceso.html" class="nav-link">Proceso</a>'),
    ('<a href="#tecnologias" class="nav-link">Tecnologías</a>', '<a href="tecnologias.html" class="nav-link">Tecnologías</a>'),
    ('<a href="#contacto" class="nav-link cta-nav">Contacto</a>', '<a href="contacto.html" class="nav-link cta-nav">Contacto</a>'),
    ('href="#inicio"', 'href="index.html"'),
    ('href="#servicios"', 'href="servicios.html"'),
    ('href="#proceso"', 'href="proceso.html"'),
    ('href="#tecnologias"', 'href="tecnologias.html"'),
    ('href="#contacto"', 'href="contacto.html"')
]

p_inicio_3 = r'<section id="inicio".*?</section>'
p_servicios_3 = r'<section id="servicios".*?</section>'
p_proceso_3 = r'<section id="proceso".*?</section>'
p_tecnologias_3 = r'<section id="tecnologias".*?</section>'
p_contacto_3 = r'<section id="contacto" class="cta-section">.*?</section>'

with open(file_3, 'r', encoding='utf-8') as f: orig_content_3 = f.read()

# index.html
content = process_file(file_3, nav_reps_3, [], [p_servicios_3, p_proceso_3, p_tecnologias_3, p_contacto_3])
with open(os.path.join(base_dir_3, "index.html"), "w", encoding="utf-8") as f: f.write(content)

# servicios.html
content = process_file(file_3, nav_reps_3, [], [p_inicio_3, p_proceso_3, p_tecnologias_3, p_contacto_3])
with open(os.path.join(base_dir_3, "servicios.html"), "w", encoding="utf-8") as f: f.write(content)

# proceso.html
content = process_file(file_3, nav_reps_3, [], [p_inicio_3, p_servicios_3, p_tecnologias_3, p_contacto_3])
with open(os.path.join(base_dir_3, "proceso.html"), "w", encoding="utf-8") as f: f.write(content)

# tecnologias.html
content = process_file(file_3, nav_reps_3, [], [p_inicio_3, p_servicios_3, p_proceso_3, p_contacto_3])
with open(os.path.join(base_dir_3, "tecnologias.html"), "w", encoding="utf-8") as f: f.write(content)

# contacto.html
content = process_file(file_3, nav_reps_3, [], [p_inicio_3, p_servicios_3, p_proceso_3, p_tecnologias_3])
with open(os.path.join(base_dir_3, "contacto.html"), "w", encoding="utf-8") as f: f.write(content)

print("Done processing all sites.")
