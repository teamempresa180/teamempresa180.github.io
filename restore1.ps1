$text = @"
1: <!DOCTYPE html>
2: <html lang="es">
3: 
4: <head>
5:   <meta charset="UTF-8" />
6:   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
7:   <title>Grupo Empresarial 180°</title>
8:   <link rel="stylesheet" href="styles.css" />
9:   <link rel="icon" href="./IMG/LOGO GRUPO EMPRESARIAL NEGATIVO.svg">
10:   <link rel="stylesheet" href="innovative-features.css" />
11: </head>
12: 
13: <body>
14:   <header class="site-header">
15:     <div class="brand">
16:       <img src="./IMG/LOGO GRUPO EMPRESARIAL NEGATIVO.svg" alt="Grupo Empresarial 180°" class="brand-logo" />
17:       <div>
18:         <h1 style="text-transform: none; font-size: 1.2rem;">Grupo Empresarial</h1>
19:       </div>
20:     </div>
21:     <nav class="main-nav">
22:       <a href="#inicio">Inicio</a>
23:       <a href="#unidades-de-negocio">Unidades de negocio</a>
24:       <a href="#nosotros">Nosotros</a>
25:       <a href="#contacto">Contáctenos</a>
26:     </nav>
27:   </header>
28: 
29:   <main>
30:     <section id="inicio" class="hero-full-carousel">
31:       <style>
32:         @keyframes growBar {
33:           0% { height: 10px; }
34:           100% { height: 40px; }
35:         }
36:       </style>
37:       <div class="carousel-slides">
38: 
39:         <!-- Slide 1: Software -->
40:         <div class="carousel-slide active">
41:           <div class="slide-bg">
42:             <img src="./IMG/SLIDERS%20SEMANALES/S1/SLIDE%20SOFTWARE.svg" alt="Software Graphic" class="hero-split-image" />
43:             <div class="golden-separator"></div>
44:           </div>
45:           <div class="slide-content">
46:             <div class="slide-copy" style="align-items: center;">
47:               <h2 class="hero-headline" style="color: white; text-align: center; font-size: clamp(2rem, 5vw, 3.5rem); text-shadow: 0 4px 10px rgba(0,0,0,0.5); margin-bottom: 30px; font-weight: bold;">Transformamos tu idea en un negocio digital</h2>
48:               <div class="visual-glass-element" style="animation: float 5s ease-in-out infinite 1s; position: relative; display: flex; align-items: center; justify-content: center; width: 220px; height: 220px; border-radius: 50%; padding: 0;">
49:                 <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; border: 2px dashed rgba(212, 175, 55, 0.3); animation: spin 12s linear infinite;"></div>
50:                 <div style="position: absolute; width: 75%; height: 75%; border-radius: 50%; border: 2px solid rgba(255, 255, 255, 0.05); border-top-color: var(--gold); animation: spin 7s linear infinite reverse;"></div>
51:                 <code style="color: var(--gold); font-size: 1.4rem; letter-spacing: 2px; z-index: 2; text-shadow: 0 0 12px rgba(212, 175, 55, 0.6); font-weight: bold;">&lt;Code/&gt;</code>
52:               </div>
53:               <div class="hero-actions" style="margin-top: 20px;">
54:                 <a href="#unidades-de-negocio" class="btn primary">Desarrollar mi idea</a>
55:               </div>
56:             </div>
57:             <div class="slide-visual"></div>
58:           </div>
59:         </div>
60: 
61:         <!-- Slide 2: SEO -->
62:         <div class="carousel-slide">
63:           <div class="slide-bg">
64:             <img src="./IMG/SLIDERS%20SEMANALES/S1/SLIDE%20SEO.svg" alt="SEO Graphic" class="hero-split-image" />
65:             <div class="golden-separator"></div>
66:           </div>
67:           <div class="slide-content">
68:             <div class="slide-copy" style="align-items: center;">
69:               <h2 class="hero-headline" style="color: white; text-align: center; font-size: clamp(2rem, 5vw, 3.5rem); text-shadow: 0 4px 10px rgba(0,0,0,0.5); margin-bottom: 30px; font-weight: bold;">Transformamos tu idea en un negocio digital</h2>
70:               <div class="visual-glass-element" style="animation: float 6s ease-in-out infinite; width: 220px; height: 220px; border-radius: 50%; display: flex; flex-direction: column; gap: 15px; padding: 0;">
71:                   <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.5));">
72:                     <circle cx="11" cy="11" r="8"></circle>
73:                     <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
74:                   </svg>
75:                   <div style="display: flex; gap: 8px; align-items: flex-end; height: 40px;">
76:                     <div style="width: 12px; background: rgba(212, 175, 55, 0.3); border-radius: 3px; animation: growBar 2s infinite alternate;"></div>
77:                     <div style="width: 12px; background: rgba(212, 175, 55, 0.6); border-radius: 3px; animation: growBar 2s infinite alternate 0.4s;"></div>
78:                     <div style="width: 12px; background: var(--gold); border-radius: 3px; box-shadow: 0 0 10px var(--gold); animation: growBar 2s infinite alternate 0.8s;"></div>
79:                   </div>
80:               </div>
81:               <div class="hero-actions" style="margin-top: 20px;">
82:                 <a href="#unidades-de-negocio" class="btn primary">Impulsar mi marca</a>
83:               </div>
84:             </div>
85:             <div class="slide-visual"></div>
86:           </div>
87:         </div>
88: 
89:         <!-- Slide 3: Social Media -->
90:         <div class="carousel-slide">
91:           <div class="slide-bg">
92:             <img src="./IMG/SLIDERS%20SEMANALES/S1/SLIDE%20SOCIAL%20MEDIA.svg" alt="Social Media Graphic" class="hero-split-image" />
93:             <div class="golden-separator"></div>
94:           </div>
95:           <div class="slide-content">
96:             <div class="slide-copy" style="align-items: center;">
97:               <h2 class="hero-headline" style="color: white; text-align: center; font-size: clamp(2rem, 5vw, 3.5rem); text-shadow: 0 4px 10px rgba(0,0,0,0.5); margin-bottom: 30px; font-weight: bold;">Transformamos tu idea en un negocio digital</h2>
98:               <div class="visual-glass-element" style="animation: float 7s ease-in-out infinite 0.5s; position: relative; width: 220px; height: 220px; border-radius: 50%; padding: 0;">
99:                 <div style="position: absolute; top: 25%; left: 25%; animation: float 4s ease-in-out infinite;">
100:                    <svg width="45" height="45" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" style="filter: drop-shadow(0 0 8px rgba(212, 175, 55, 0.6));"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
101:                 </div>
102:                 <div style="position: absolute; bottom: 25%; right: 25%; animation: float 5s ease-in-out infinite 1s;">
103:                    <svg width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" style="opacity: 0.8;"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
104:                 </div>
105:                 <div style="position: absolute; top: 15%; right: 15%; animation: float 6s ease-in-out infinite 2s;">
106:                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
107:                 </div>
108:               </div>
109:               <div class="hero-actions" style="margin-top: 20px;">
110:                 <a href="#unidades-de-negocio" class="btn primary">Conectar con mi audiencia</a>
111:               </div>
112:             </div>
113:             <div class="slide-visual"></div>
114:           </div>
115:         </div>
116: 
117:         <!-- Slide 4: Branding -->
118:         <div class="carousel-slide">
119:           <div class="slide-bg">
120:             <img src="./IMG/SLIDERS%20SEMANALES/S1/SLIDE%20BRANDING.svg" alt="Branding Graphic" class="hero-split-image" />
121:             <div class="golden-separator"></div>
122:           </div>
123:           <div class="slide-content">
124:             <div class="slide-copy" style="align-items: center;">
125:               <h2 class="hero-headline" style="color: white; text-align: center; font-size: clamp(2rem, 5vw, 3.5rem); text-shadow: 0 4px 10px rgba(0,0,0,0.5); margin-bottom: 30px; font-weight: bold;">Transformamos tu idea en un negocio digital</h2>
126:               <div class="visual-glass-element" style="animation: float 6s ease-in-out infinite 0.8s; position: relative; width: 220px; height: 220px; border-radius: 50%; padding: 0;">
127:                 <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
128:                    <svg width="55" height="55" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" style="filter: drop-shadow(0 0 8px rgba(212, 175, 55, 0.6));">
129:                      <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
130:                    </svg>
131:                 </div>
132:                 <div style="position: absolute; width: 100%; height: 100%; border-radius: 50%; border: 2px dashed rgba(212, 175, 55, 0.4); animation: spin 15s linear infinite;"></div>
133:               </div>
134:               <div class="hero-actions" style="margin-top: 20px;">
135:                 <a href="#unidades-de-negocio" class="btn primary">Construir mi marca</a>
136:               </div>
137:             </div>
138:             <div class="slide-visual"></div>
139:           </div>
140:         </div>
141: 
142:         <!-- Slide 5: Fotografías -->
143:         <div class="carousel-slide">
144:           <div class="slide-bg">
145:             <img src="./IMG/SLIDERS%20SEMANALES/S1/SLIDE%20FOTOGRAFIAS.svg" alt="Fotografías Graphic" class="hero-split-image" />
146:             <div class="golden-separator"></div>
147:           </div>
148:           <div class="slide-content">
149:             <div class="slide-copy" style="align-items: center;">
150:               <h2 class="hero-headline" style="color: white; text-align: center; font-size: clamp(2rem, 5vw, 3.5rem); text-shadow: 0 4px 10px rgba(0,0,0,0.5); margin-bottom: 30px; font-weight: bold;">Transformamos tu idea en un negocio digital</h2>
151:               <div class="visual-glass-element" style="animation: float 5.5s ease-in-out infinite 1.2s; position: relative; width: 220px; height: 220px; border-radius: 50%; padding: 0;">
152:                 <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
153:                    <svg width="55" height="55" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2" style="filter: drop-shadow(0 0 8px rgba(212, 175, 55, 0.6));">
154:                      <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
155:                      <circle cx="12" cy="13" r="4"></circle>
156:                    </svg>
157:                 </div>
158:                 <div style="position: absolute; width: 80%; height: 80%; border-radius: 50%; border: 2px solid rgba(255, 255, 255, 0.05); border-top-color: var(--gold); animation: spin 9s linear infinite reverse;"></div>
159:               </div>
160:               <div class="hero-actions" style="margin-top: 20px;">
161:                 <a href="#unidades-de-negocio" class="btn primary">Capturar momentos</a>
162:               </div>
163:             </div>
164:             <div class="slide-visual"></div>
165:           </div>
166:         </div>
167: 
168:       </div>
169: 
170:       <!-- Controles del Carrusel -->
171:       <div class="carousel-controls full-width-controls">
172:         <button class="carousel-dot active" aria-label="Slide 1"></button>
173:         <button class="carousel-dot" aria-label="Slide 2"></button>
174:         <button class="carousel-dot" aria-label="Slide 3"></button>
175:         <button class="carousel-dot" aria-label="Slide 4"></button>
176:         <button class="carousel-dot" aria-label="Slide 5"></button>
177:       </div>
178: 
179:       <!-- Flechas -->
180:       <button class="carousel-nav prev" aria-label="Anterior">
181:         <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
182:           <polyline points="15 18 9 12 15 6"></polyline>
183:         </svg>
184:       </button>
185:       <button class="carousel-nav next" aria-label="Siguiente">
186:         <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
187:           <polyline points="9 18 15 12 9 6"></polyline>
188:         </svg>
189:       </button>
190: 
191:       <div class="hero-watermark" aria-hidden="true" style="z-index: 1;">
192:         <img src="Logo.svg" alt="" />
193:       </div>
194:     </section>
195: 
196:     <section id="unidades-de-negocio" class="subcompanies-section reveal">
197:       <div class="section-header">
198:         <span>Ecosistema 180°</span>
199:         <h3>Encuentra las unidades de negocio del grupo empresarial</h3>
200:       </div>
201:       <div class="service-buttons">
202:         <a href="./SITIO GRUPO AGENCIA DIGITAL 180°/index.html" class="subcompany-card" style="flex-direction: column; justify-content: center;">
203:           <img src="./IMG/Logo agencia.svg" alt="Logo Agencia" style="margin-bottom: 25px; width: 140px; height: auto;" />
204:           <span style="margin-bottom: 15px; font-size: 1.6rem; font-weight: 700; text-align: center;">Agencia digital</span>
205:           <p style="font-size: 1.1rem; color: var(--muted); text-align: center; margin: 0; line-height: 1.5; font-weight: normal;">Diseño, branding y redes sociales</p>
206:         </a>
207:         <a href="./SITIO SOFTWARE STUDIO 180°/index.html" class="subcompany-card" style="flex-direction: column; justify-content: center;">
208:           <img src="./IMG/Logo Software Studio.svg" alt="Logo 180 Software Studio" style="margin-bottom: 25px; width: 140px; height: auto;" />
209:           <span style="margin-bottom: 15px; font-size: 1.6rem; font-weight: 700; text-align: center;">180 Software Studio</span>
210:           <p style="font-size: 1.1rem; color: var(--muted); text-align: center; margin: 0; line-height: 1.5; font-weight: normal;">Desarrollo de software a medida</p>
211:         </a>
212:       </div>
213:       <div style="text-align: center; margin-top: 50px; display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
214:         <a href="#contacto" class="btn primary">Quiero una estrategia</a>
215:         <a href="#contacto" class="btn secondary" style="border: 1px solid var(--gold); color: var(--gold); padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 600;">Necesito una web</a>
216:       </div>
217:     </section>
218: 
219:     <section id="nosotros" class="about-section reveal" style="max-width: 1200px; margin: 0 auto; padding: 100px clamp(20px, 4vw, 48px) 40px;">
220:       <div class="testimonial-card dark" style="text-align: center; padding: 50px clamp(20px, 4vw, 60px); margin-bottom: 40px;">
221:         <span class="eyebrow" style="justify-content: center; margin-bottom: 20px;">Nosotros</span>
222:         <h3 style="margin-bottom: 30px; font-size: 2.5rem; color: var(--text);">¿Quiénes somos?</h3>
223:         <p style="margin: 0 auto 20px; font-size: 1.15rem; max-width: 900px; color: #d9d0af; line-height: 1.7;">Somos una organización que impulsa cambios reales. No solo acompañamos empresas, las ayudamos a dar el giro que necesitan para evolucionar, adaptarse y abrir nuevas oportunidades. Vemos más allá de lo evidente, identificamos el potencial y lo convertimos en resultados.</p>
224:       </div>
225: 
226:       <div class="testimonial-card" style="text-align: center; padding: 50px clamp(20px, 4vw, 60px); margin-bottom: 40px;">
227:         <span class="eyebrow" style="justify-content: center; margin-bottom: 20px;">Propósito</span>
228:         <h3 style="margin-bottom: 30px; font-size: 2.5rem; color: var(--text);">Por qué nació Grupo Empresarial 180°</h3>
229:         <p style="margin: 0 auto 20px; font-size: 1.15rem; max-width: 900px; color: var(--text); line-height: 1.7;">Nacimos con la idea de crear un ecosistema capaz de unir creatividad, tecnología e innovación para transformar negocios. Un enfoque humano, con visión y propósito, diseñado para conectar más y llevar las ideas al siguiente nivel.</p>
230:       </div>
231: 
232:       <div style="text-align: center; margin-bottom: 40px;">
233:         <span class="eyebrow" style="justify-content: center; margin-bottom: 20px;">Nuestro Equipo</span>
234:         <h3 style="margin-bottom: 30px; font-size: 2.5rem; color: var(--text);">Conoce a los humanos detrás de 180°</h3>
235:         <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin-top: 30px;">
236:           <div class="testimonial-card dark" style="padding: 30px; text-align: center; display: flex; flex-direction: column; align-items: center;">
237:             <div style="position: relative; width: 140px; height: 140px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; animation: float 6s ease-in-out infinite;">
238:               <div style="position: absolute; inset: 0; border-radius: 50%; border: 2px dashed rgba(212, 175, 55, 0.4); animation: spin 15s linear infinite;"></div>
239:               <div style="position: absolute; inset: 8px; border-radius: 50%; border: 2px solid rgba(255, 255, 255, 0.05); border-top-color: var(--gold); animation: spin 10s linear infinite reverse;"></div>
240:               <div style="position: absolute; inset: 20px; border-radius: 50%; background: radial-gradient(circle at top right, #f7d988 0%, var(--gold) 100%); box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3); overflow: hidden; display: flex; align-items: flex-end; justify-content: center;">
241:                 <img src="./IMG/AVATARES/Avatar Nathaly.svg" alt="Community Manager" style="width: 88%; height: 88%; object-fit: contain; object-position: bottom;" />
242:               </div>
243:             </div>
244:             <h4 style="color: var(--text); margin-bottom: 10px; font-size: 1.2rem;">Community Manager</h4>
245:             <p style="color: var(--gold); font-size: 0.95rem; font-weight: bold; margin-bottom: 10px;">Dirección y Crecimiento</p>
246:             <p style="color: var(--muted); font-size: 0.9rem; line-height: 1.5;">Con visión global, orquesta el crecimiento y define el rumbo de los proyectos hacia el éxito rotundo.</p>
247:           </div>
248:           <div class="testimonial-card dark" style="padding: 30px; text-align: center; display: flex; flex-direction: column; align-items: center;">
249:             <div style="position: relative; width: 140px; height: 140px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; animation: float 6s ease-in-out infinite 1s;">
250:               <div style="position: absolute; inset: 0; border-radius: 50%; border: 2px dashed rgba(212, 175, 55, 0.4); animation: spin 14s linear infinite;"></div>
251:               <div style="position: absolute; inset: 8px; border-radius: 50%; border: 2px solid rgba(255, 255, 255, 0.05); border-top-color: var(--gold); animation: spin 11s linear infinite reverse;"></div>
252:               <div style="position: absolute; inset: 20px; border-radius: 50%; background: radial-gradient(circle at top right, #f7d988 0%, var(--gold) 100%); box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3); overflow: hidden; display: flex; align-items: flex-end; justify-content: center;">
253:                 <img src="./IMG/AVATARES/Avatar Anyelo.svg" alt="Desarrolladores de Software" style="width: 88%; height: 88%; object-fit: contain; object-position: bottom;" />
254:               </div>
255:             </div>
256:             <h4 style="color: var(--text); margin-bottom: 10px; font-size: 1.2rem;">Desarrolladores de Software</h4>
257:             <p style="color: var(--gold); font-size: 0.95rem; font-weight: bold; margin-bottom: 10px;">Innovación en Software</p>
258:             <p style="color: var(--muted); font-size: 0.9rem; line-height: 1.5;">Arquitecta de soluciones digitales a medida, transformando la complejidad en código limpio y eficiente.</p>
259:           </div>
260:           <div class="testimonial-card dark" style="padding: 30px; text-align: center; display: flex; flex-direction: column; align-items: center;">
261:             <div style="position: relative; width: 140px; height: 140px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; animation: float 6s ease-in-out infinite 2s;">
262:               <div style="position: absolute; inset: 0; border-radius: 50%; border: 2px dashed rgba(212, 175, 55, 0.4); animation: spin 16s linear infinite;"></div>
263:               <div style="position: absolute; inset: 8px; border-radius: 50%; border: 2px solid rgba(255, 255, 255, 0.05); border-top-color: var(--gold); animation: spin 9s linear infinite reverse;"></div>
264:               <div style="position: absolute; inset: 20px; border-radius: 50%; background: radial-gradient(circle at top right, #f7d988 0%, var(--gold) 100%); box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3); overflow: hidden; display: flex; align-items: flex-end; justify-content: center;">
265:                 <img src="./IMG/AVATARES/Avatar Natalia.svg" alt="Diseñadores Gráficos" style="width: 88%; height: 88%; object-fit: contain; object-position: bottom;" />
266:               </div>
267:             </div>
268:             <h4 style="color: var(--text); margin-bottom: 10px; font-size: 1.2rem;">Diseñadores Gráficos</h4>
269:             <p style="color: var(--gold); font-size: 0.95rem; font-weight: bold; margin-bottom: 10px;">Diseño y Branding</p>
270:             <p style="color: var(--muted); font-size: 0.9rem; line-height: 1.5;">Da vida a las ideas a través de experiencias visuales únicas que conectan verdaderamente con la audiencia.</p>
271:           </div>
272:         </div>
273:       </div>
274:     </section>
275: 
276:     <section class="testimonial-section reveal" style="padding-top: 0; padding-bottom: 20px;">
277:       <div class="testimonial-card">
278:         <span class="eyebrow">Visión</span>
279:         <p style="margin-top: 20px; font-size: 1.15rem; line-height: 1.7; color: var(--text);">Ser una marca que trascienda en el tiempo por su capacidad de transformar realidades, impulsar empresas y dejar huella en cada proyecto, convirtiéndonos en un símbolo de evolución, confianza y crecimiento.</p>
280:       </div>
281:       <div class="testimonial-card dark">
282:         <span class="eyebrow">Misión</span>
283:         <p style="margin-top: 20px; font-size: 1.15rem; line-height: 1.7; color: var(--text);">Inspirar y potenciar la evolución de empresas y personas, generando oportunidades de crecimiento a través de soluciones estratégicas, innovación constante y una visión transformadora.</p>
284:       </div>
285:     </section>
286: 
287:     <div style="text-align: center; padding: 20px 40px 80px; display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
288:       <a href="#contacto" class="btn primary">Hablemos de crecimiento</a>
289:       <a href="#contacto" class="btn secondary" style="border: 1px solid var(--gold); color: var(--gold); padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 600;">Cotizar proyecto</a>
290:       <a href="#contacto" class="btn primary">Agendar reunión</a>
291:     </div>
292:   </main>
293: 
294:   <footer id="contacto" class="site-footer reveal" style="display: flex; flex-direction: column; gap: 40px; padding: 80px clamp(20px, 4vw, 48px) 40px;">
295:     <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 50px;">
296:       
297:       <!-- Contact Info -->
298:       <div class="footer-brand">
299:         <img src="./IMG/LOGO GRUPO EMPRESARIAL NEGATIVO.svg" alt="Grupo Empresarial" class="footer-logo" style="margin-bottom: 24px;" />
300:         <p style="color: var(--text); font-size: 1.2rem; margin-bottom: 16px;"><strong>Hablemos de tu proyecto</strong></p>
301:         <p style="display: flex; align-items: center; gap: 10px;">✉️ teamempresa180@gmail.com</p>
302:         <p style="display: flex; align-items: center; gap: 10px;">📱 +57 311 8966083 (WhatsApp)</p>
303:         <div style="display: flex; gap: 20px; margin-top: 20px;">
304:           <a href="https://www.instagram.com/grupoempresarial180grados/" style="color: var(--gold); text-decoration: none; font-weight: 500;">Instagram</a>
305:           <a href="https://www.facebook.com/profile.php?id=61560443625594&rdid=mBMAQriqxA1TxyXw&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F1cSjcWGSrW%2F#" style="color: var(--gold); text-decoration: none; font-weight: 500;">Facebook</a>
306:         </div>
307:       </div>
308: 
309:       <!-- CRM Lead Form -->
310:       <div class="footer-form" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 30px; border-radius: 12px;">
311:         <h3 style="color: var(--gold); margin-bottom: 20px;">Envíanos un mensaje</h3>
312:         <form id="crm-contact-form" onsubmit="submitToCRM(event)" style="display: flex; flex-direction: column; gap: 15px;">
313:           <input type="text" id="crm-name" placeholder="Tu Nombre o Empresa" required style="background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 12px; border-radius: 6px; outline: none;">
314:           <input type="email" id="crm-email" placeholder="Tu Correo Electrónico" required style="background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 12px; border-radius: 6px; outline: none;">
315:           <textarea id="crm-message" placeholder="¿En qué te podemos ayudar?" required rows="4" style="background: rgba(0,0,0,0.5); border: 1px solid rgba(255,255,255,0.1); color: white; padding: 12px; border-radius: 6px; outline: none; resize: none;"></textarea>
316:           <button type="submit" class="btn primary" style="width: 100%; border: none; cursor: pointer;">Enviar Mensaje</button>
317:           <p id="crm-success-msg" style="color: #4CAF50; font-size: 0.9rem; display: none; margin: 0;">¡Mensaje recibido! Te contactaremos pronto.</p>
318:         </form>
319:       </div>
320: 
321:       <!-- Legal Links -->
322:       <div class="footer-links" style="padding-top: 10px;">
323:         <p style="color: var(--text); font-size: 1.2rem; margin-bottom: 16px;"><strong>Legal e Interno</strong></p>
324:         <a href="#" style="color: #c8b884; text-decoration: none; margin-bottom: 12px; display: block;">Política de privacidad</a>
325:         <a href="#" style="color: #c8b884; text-decoration: none; margin-bottom: 12px; display: block;">Tratamiento de datos</a>
326:         <a href="admin.html" target="_blank" style="color: var(--gold); text-decoration: none; margin-top: 20px; display: inline-block; padding: 5px 10px; border: 1px solid var(--gold); border-radius: 4px; font-size: 0.8rem;">🔒 Acceso CRM</a>
327:       </div>
328:     </div>
329: 
330:     <div style="border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 40px; text-align: center; color: var(--muted); font-size: 0.95rem;">
331:       <p>© 2026 Grupo Empresarial 180 Grados. Todos los derechos reservados.</p>
332:       <p style="margin-top: 10px;">Diseñado para impulsar evolución y crecimiento empresarial.</p>
333:     </div>
334:     
335:     <script>
336:       function submitToCRM(e) {
337:         e.preventDefault();
338:         const name = document.getElementById('crm-name').value;
339:         const email = document.getElementById('crm-email').value;
340:         const message = document.getElementById('crm-message').value;
341:         
342:         // Save to LocalStorage Database
343:         const DB_KEY = '180_crm_leads';
344:         const leads = JSON.parse(localStorage.getItem(DB_KEY) || '[]');
345:         leads.push({
346:           id: 'lead_' + Date.now(),
347:           name: name,
348:           email: email,
349:           message: message,
350:           source: 'Web Grupo Empresarial',
351:           status: 'nuevos',
352:           date: new Date().toLocaleDateString()
353:         });
354:         localStorage.setItem(DB_KEY, JSON.stringify(leads));
355:         
356:         // Show success
357:         document.getElementById('crm-success-msg').style.display = 'block';
358:         document.getElementById('crm-contact-form').reset();
359:         setTimeout(() => {
360:            document.getElementById('crm-success-msg').style.display = 'none';
361:         }, 4000);
362:       }
363:     </script>
364:   </footer>
365: 
366:   <!-- Chatbot IA - Grupo Empresarial 180° -->
367:   <div id="chatbot-widget" class="chatbot-widget">
368:     <button id="chatbot-toggle" class="chatbot-toggle" aria-label="Abrir chat con IA">
369:       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
370:         <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
371:       </svg>
372:       <span class="chatbot-badge">IA</span>
373:     </button>
374: 
375:     <div id="chatbot-window" class="chatbot-window">
376:       <div class="chatbot-header">
377:         <div class="chatbot-avatar">
378:           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
379:             <polygon
380:               points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
381:             </polygon>
382:           </svg>
383:         </div>
384:         <div class="chatbot-title">
385:           <strong>Asistente IA</strong>
386:           <span>Grupo Empresarial 180°</span>
387:         </div>
388:         <button id="chatbot-clear" class="chatbot-action-btn" aria-label="Limpiar chat" style="background:none; border:none; color:currentColor; cursor:pointer; opacity:0.7; transition:opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.7">
389:           <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
390:             <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
391:           </svg>
392:         </button>
393:         <button id="chatbot-close" class="chatbot-close" aria-label="Cerrar chat">
394:           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
395:             <line x1="18" y1="6" x2="6" y2="18"></line>
396:             <line x1="6" y1="6" x2="18" y2="18"></line>
397:           </svg>
398:         </button>
399:       </div>
400: 
401:       <div id="chatbot-messages" class="chatbot-messages">
402:         <div class="chatbot-message bot">
403:           <div class="message-content">
404:             <p>Hola 👋</p>
405:             <p>¡Gracias por comunicarte con Grupo Empresarial 180°! 🚀</p>
406:             <p>Somos un grupo empresarial especializado en marketing, branding, contenido digital y desarrollo tecnológico.</p>
407:             <p>Queremos conocer más sobre tu proyecto para ayudarte de la mejor manera ✨</p>
408:             <p>Cuéntanos:</p>
409:             <ul>
410:               <li>Tu nombre</li>
411:               <li>El servicio que te interesa</li>
412:               <li>Y qué objetivo quieres lograr actualmente con tu marca o empresa</li>
413:             </ul>
414:             <div class="quick-actions">
415:               <button class="quick-action" data-query="servicios">¿Qué servicios ofrecen?</button>
416:               <button class="quick-action" data-query="cotizacion">Solicitar cotización</button>
417:               <button class="quick-action" data-query="proceso">¿Cómo es el proceso?</button>
418:             </div>
419:           </div>
420:         </div>
421:       </div>
422: 
423:       <div class="chatbot-input-area">
424:         <input type="text" id="chatbot-input" placeholder="Escribe tu mensaje..." autocomplete="off">
425:         <button id="chatbot-send" class="chatbot-send" aria-label="Enviar mensaje">
426:           <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
427:             <line x1="22" y1="2" x2="11" y2="13"></line>
428:             <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
429:           </svg>
430:         </button>
431:       </div>
432:     </div>
433:   </div>
434: 
435:   <script src="script.js"></script>
436:   <script src="chatbot.js"></script>
437:   <script src="innovative-features.js"></script>
438: </body>
439: 
440: </html>
"@
$clean = [Regex]::Replace($text, "(?m)^\d+: ", "")
[IO.File]::WriteAllText("c:\Users\lizar\Desktop\download\index.html", $clean, [Text.Encoding]::UTF8)
