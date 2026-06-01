/**
 * Chatbot IA - 180° Software Estudio (Sitio Principal)
 * Motor: Gemini 2.0 Flash con fallback inteligente
 */

// ============================================
// CONFIGURACIÓN DE IA (GEMINI)
// ============================================

const GEMINI_API_KEY = "AIzaSyBK_eiodE_Q3rO5kS68287VGTDYJLgnX-g";
const GEMINI_MODELS = [
  "gemini-2.0-flash",
  "gemini-2.0-flash-lite",
  "gemini-1.5-flash-latest"
];
const GEMINI_BASE_URL = "https://generativelanguage.googleapis.com/v1beta/models";

// ============================================
// SYSTEM PROMPT - Sitio Principal
// ============================================

const SYSTEM_PROMPT = `
Eres el asistente virtual experto y consultor estratégico del Grupo Empresarial 180°.

Tu PROPÓSITO: Ayudar a los visitantes, resolver sus dudas de manera consultiva, actuar como un asesor que aporta valor, y canalizarlos a la unidad de negocio adecuada.

INFORMACIÓN CLAVE DEL GRUPO:
- Nombre: Grupo Empresarial 180°
- Slogan: "Transformamos ideas en resultados, creatividad en innovación y proyectos en negocios exitosos."
- Misión: Inspirar y potenciar la evolución de empresas mediante soluciones estratégicas.
- Correo Electrónico: teamempresa180@gmail.com
- WhatsApp / Teléfono: +57 311 8966083
- Redes Sociales: Estamos en Facebook e Instagram como @grupoempresarial180grados.

NUESTRAS UNIDADES DE NEGOCIO:
1. 180° Agencia Digital: Especialistas en marketing, branding, redes sociales completas, fotografía, producción audiovisual, campañas publicitarias (Meta Ads, Google Ads) y SEO.
2. 180° Software Studio: Expertos en desarrollo de software a medida, aplicaciones móviles (iOS/Android), páginas web corporativas y tiendas online (ecommerce), sistemas empresariales (CRM, ERP), e Inteligencia Artificial / automatización.

### REGLAS INQUEBRANTABLES
1. TONO CONSULTIVO: Sé un asesor experto, profesional, empático y cercano. Usa emojis como 🚀, ✨, 🙌, 💡, 💻 de forma natural pero no excesiva.
2. APORTA VALOR: Si el cliente hace preguntas generales (ej. "¿Por qué necesito una web?" o "¿Para qué sirve el SEO?"), explícale brevemente el beneficio y luego ofrécele nuestra ayuda.
3. BREVEDAD Y CLARIDAD: Tus respuestas deben ser directas, usando viñetas o listas si es necesario, de 1 a 3 párrafos cortos.
4. REDIRECCIÓN INTELIGENTE: Si el usuario requiere diseño, redes sociales o marketing, menciona que "180° Agencia Digital" es su mejor aliado. Si requiere software, IA o webs, menciona a "180° Software Studio".
5. CIERRE COMERCIAL Y LLAMADO A LA ACCIÓN: Busca siempre avanzar la conversación hacia una cotización o agendar una reunión. Concluye recordando: "Gracias por comunicarte con Grupo Empresarial 180° 🚀. Será un gusto acompañarte." o pregunta "¿Te gustaría que un especialista te contacte?".

### PREGUNTAS FRECUENTES Y BASE DE CONOCIMIENTO (FAQ)
P: ¿Qué servicios ofrecen?
R: Ayudamos a empresas a crecer con: ✨ Branding y diseño, 📱 Redes sociales, 📸 Fotografía/Video, 🔎 SEO, y 💻 Desarrollo de software, apps y páginas web.

P: ¿Cómo solicito una cotización o me contacto?
R: Para cotizar, cuéntanos: • Tu marca • Servicio • Objetivo • Ciudad. Puedes escribirnos por aquí, enviarnos un mensaje al WhatsApp +57 311 8966083 o al correo teamempresa180@gmail.com.

P: ¿Tienen precios o paquetes fijos?
R: Cada proyecto es único y lo trabajamos a la medida para garantizar resultados reales. Tras una breve charla sobre tus necesidades, te entregaremos una propuesta económica precisa.

P: ¿Trabajan con emprendimientos o solo empresas grandes?
R: ¡Ambos! Trabajamos con emprendimientos, empresas en crecimiento y marcas consolidadas 🚀. Nos adaptamos a la etapa de tu negocio.

P: ¿Trabajan de manera presencial o virtual?
R: Sí ✨. Trabajamos presencial y de forma virtual (online) con clientes de diferentes ciudades y países.

P: ¿Por qué necesito redes sociales o qué incluye el servicio?
R: Las redes validan tu marca y atraen clientes. Nos encargamos de todo: estrategia, diseño, copies, parrilla y acompañamiento continuo 📱.

P: ¿Desarrollan tiendas online (ecommerce) o solo páginas informativas?
R: Desarrollamos desde landing pages informativas hasta tiendas online completas y plataformas complejas a medida 💻.

P: ¿Qué es SEO y para qué sirve?
R: El SEO posiciona tu web en los primeros resultados de Google 🔎, atrayendo visitas de personas que ya buscan lo que ofreces (tráfico orgánico).

P: ¿Cómo es el proceso de trabajo?
R: Conocemos tu proyecto (Diagnóstico) -> Analizamos necesidades -> Desarrollamos propuesta -> Ejecutamos con entregas progresivas -> Seguimiento constante ✨.

P: ¿Hacen campañas publicitarias pagas?
R: Sí 🚀. Creamos y optimizamos campañas en Meta Ads (Facebook/Instagram) y Google Ads enfocadas en retorno de inversión (ROI) y ventas.

P: ¿Cuánto tiempo tarda un proyecto?
R: Depende del alcance 👌. Una web puede tomar un par de semanas, mientras que un desarrollo de software tomará más tiempo. Siempre te damos un cronograma claro antes de iniciar.

P: ¿Están contratando / Busco empleo?
R: Publicamos nuestras vacantes en nuestras redes sociales (Instagram/Facebook). Te invitamos a seguirnos para enterarte de nuevas oportunidades 🙌.
`;

// ============================================
// RESPUESTAS FALLBACK INTELIGENTES
// ============================================

const FALLBACK_RESPONSES = {
  servicios: `En Grupo Empresarial 180° ayudamos a empresas y marcas a crecer a través de soluciones creativas y tecnológicas 🚀\nNuestros servicios incluyen:\n✨ Branding y diseño de marca\n📱 Redes sociales y contenido digital\n📸 Fotografía y producción audiovisual\n🔎 SEO y posicionamiento web\n💻 Desarrollo de software y páginas web\nTrabajamos cada proyecto de manera estratégica. ¿Qué servicio te interesa en este momento?`,
  
  cotizacion: `¡Claro! 🙌\nPara enviarte una cotización más precisa necesitamos conocer un poco sobre tu proyecto.\nPuedes compartirnos:\n• Nombre de tu marca o empresa\n• Servicio que necesitas\n• Objetivo principal\n• Ciudad o país\n¿Sobre qué servicio te gustaría cotizar?`,

  proceso: `Nuestro proceso busca que todo sea claro, organizado y estratégico ✨\nPrimero conocemos tu proyecto y objetivos, luego analizamos lo que necesitas y finalmente desarrollamos una propuesta personalizada para tu marca o empresa.\nDurante todo el proceso mantenemos comunicación y seguimiento constante 🚀\n¿Te gustaría que agendáramos una reunión para conocer mejor tu proyecto?`,

  default: `Gracias por comunicarte con Grupo Empresarial 180° 🚀\nSerá un gusto acompañarte y ayudarte a llevar tu proyecto al siguiente nivel.\nQuedamos atentos a tu mensaje ✨\n¿Qué te gustaría potenciar o mejorar actualmente en tu marca o empresa?`
};

function getFallbackResponse(message) {
  const lower = message.toLowerCase();
  if (lower.includes('servicio') || lower.includes('ofrecen') || lower.includes('hacen')) {
    return FALLBACK_RESPONSES.servicios;
  }
  if (lower.includes('cotiz') || lower.includes('presupuesto') || lower.includes('costo') || lower.includes('precio')) {
    return FALLBACK_RESPONSES.cotizacion;
  }
  if (lower.includes('proceso') || lower.includes('trabajan') || lower.includes('pasos')) {
    return FALLBACK_RESPONSES.proceso;
  }
  return FALLBACK_RESPONSES.default;
}

// ============================================
// MOTOR CONVERSACIONAL CON IA (GEMINI)
// ============================================

class ChatbotIA {
  constructor() {
    this.widget = document.getElementById('chatbot-widget');
    this.toggle = document.getElementById('chatbot-toggle');
    this.window = document.getElementById('chatbot-window');
    this.close = document.getElementById('chatbot-close');
    this.clear = document.getElementById('chatbot-clear');
    this.messages = document.getElementById('chatbot-messages');
    this.input = document.getElementById('chatbot-input');
    this.send = document.getElementById('chatbot-send');

    if (!this.validateElements()) {
      console.error('Error: No se encontraron todos los elementos del chatbot en el DOM');
      return;
    }

    this.isTyping = false;
    this.conversationHistory = [];

    this.init();
    console.log('✓ Chatbot IA inicializado correctamente');
  }

  validateElements() {
    return this.widget && this.toggle && this.window && this.close && this.messages && this.input && this.send;
  }

  init() {
    this.toggle.addEventListener('click', () => this.toggleChat());
    this.close.addEventListener('click', () => this.closeChat());
    if (this.clear) this.clear.addEventListener('click', () => this.resetChat());
    this.send.addEventListener('click', () => this.handleUserInput());

    this.input.addEventListener('keypress', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        this.handleUserInput();
      }
    });

    // Botones de acciones rápidas iniciales
    this.messages.querySelectorAll('.quick-action').forEach(btn => {
      btn.addEventListener('click', () => {
        const query = btn.dataset.query;
        const queries = {
          servicios: "¿Cuáles son los servicios que ofrecen?",
          cotizacion: "¿Cómo puedo solicitar una cotización?",
          proceso: "¿Cómo es el proceso de trabajo?"
        };
        if (queries[query]) {
          this.addMessage(queries[query], 'user');
          this.conversationHistory.push({ role: 'user', parts: [{ text: queries[query] }] });
          this.getGeminiResponse(queries[query]);
        }
      });
    });
  }

  toggleChat() {
    this.window.classList.toggle('is-open');
    if (this.window.classList.contains('is-open')) {
      this.input.focus();
    }
  }

  closeChat() {
    this.window.classList.remove('is-open');
  }

  resetChat() {
    if(confirm("¿Estás seguro de que quieres limpiar la conversación?")) {
      this.messages.innerHTML = '';
      this.conversationHistory = [];
      const welcome = `Hola 👋<br>¡Gracias por comunicarte con Grupo Empresarial 180°! 🚀<br>Somos un grupo empresarial especializado en marketing, branding, contenido digital y desarrollo tecnológico.<br>Queremos conocer más sobre tu proyecto para ayudarte de la mejor manera ✨<br>Cuéntanos:<br>• Tu nombre<br>• El servicio que te interesa<br>• Y qué objetivo quieres lograr actualmente con tu marca o empresa`;
      this.addMessage(welcome, 'bot', false, true);
      
      const actionsDiv = document.createElement('div');
      actionsDiv.className = 'quick-actions';
      actionsDiv.innerHTML = `
        <button class="quick-action" data-query="servicios">¿Qué servicios ofrecen?</button>
        <button class="quick-action" data-query="cotizacion">Solicitar cotización</button>
        <button class="quick-action" data-query="proceso">¿Cómo es el proceso?</button>
      `;
      this.messages.lastChild.querySelector('.message-content').appendChild(actionsDiv);
      this.attachQuickActions(actionsDiv);
    }
  }

  attachQuickActions(container) {
    container.querySelectorAll('.quick-action').forEach(btn => {
      btn.addEventListener('click', () => {
        const query = btn.dataset.query;
        const queries = {
          servicios: "¿Cuáles son los servicios que ofrecen?",
          cotizacion: "¿Cómo puedo solicitar una cotización?",
          proceso: "¿Cómo es el proceso de trabajo?"
        };
        if (queries[query]) {
          this.addMessage(queries[query], 'user');
          this.conversationHistory.push({ role: 'user', parts: [{ text: queries[query] }] });
          this.getGeminiResponse(queries[query]);
        }
      });
    });
  }

  handleUserInput() {
    const text = this.input.value.trim();
    if (!text || this.isTyping) return;

    this.addMessage(text, 'user');
    this.input.value = '';

    this.conversationHistory.push({ role: 'user', parts: [{ text }] });
    this.getGeminiResponse(text);
  }

  async tryGeminiModel(modelName) {
    const url = `${GEMINI_BASE_URL}/${modelName}:generateContent?key=${GEMINI_API_KEY}`;
    const contents = [
      { role: 'user', parts: [{ text: SYSTEM_PROMPT }] },
      { role: 'model', parts: [{ text: "Entendido. Soy el asistente de Grupo Empresarial 180°. Utilizaré la base de conocimiento de FAQ proporcionada para responder." }] },
      ...this.conversationHistory
    ];

    const response = await fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        contents,
        generationConfig: { maxOutputTokens: 500, temperature: 0.7 }
      }),
    });

    if (!response.ok) {
      const errorData = await response.json().catch(() => ({}));
      throw Object.assign(new Error(`API Error: ${response.status}`), { status: response.status, data: errorData });
    }

    const data = await response.json();
    return data.candidates[0].content.parts[0].text;
  }

  async getGeminiResponse(userMessage) {
    this.isTyping = true;
    this.send.disabled = true;
    this.addTypingIndicator();

    let botResponse = null;

    // Intentar con cada modelo disponible
    for (const model of GEMINI_MODELS) {
      try {
        botResponse = await this.tryGeminiModel(model);
        console.log(`✓ Respuesta obtenida con modelo: ${model}`);
        break;
      } catch (error) {
        console.warn(`✗ Falló modelo ${model}: ${error.message}`);
        if (error.status === 429) {
          // Rate limit - esperar 2s antes del siguiente modelo
          await new Promise(resolve => setTimeout(resolve, 2000));
        }
      }
    }

    this.removeTypingIndicator();

    if (botResponse) {
      this.conversationHistory.push({ role: 'model', parts: [{ text: botResponse }] });
      this.addMessage(botResponse, 'bot');
    } else {
      // Usar respuesta predefinida inteligente
      const fallback = getFallbackResponse(userMessage);
      this.conversationHistory.push({ role: 'model', parts: [{ text: fallback }] });
      this.addMessage(fallback, 'bot');
    }

    this.playNotificationSound();

    this.isTyping = false;
    this.send.disabled = false;
  }

  playNotificationSound() {
    try {
      const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
      const oscillator = audioCtx.createOscillator();
      const gainNode = audioCtx.createGain();
      oscillator.type = 'sine';
      oscillator.frequency.setValueAtTime(600, audioCtx.currentTime);
      oscillator.frequency.exponentialRampToValueAtTime(800, audioCtx.currentTime + 0.1);
      gainNode.gain.setValueAtTime(0, audioCtx.currentTime);
      gainNode.gain.linearRampToValueAtTime(0.1, audioCtx.currentTime + 0.05);
      gainNode.gain.linearRampToValueAtTime(0, audioCtx.currentTime + 0.15);
      oscillator.connect(gainNode);
      gainNode.connect(audioCtx.destination);
      oscillator.start();
      oscillator.stop(audioCtx.currentTime + 0.2);
    } catch(e) {}
  }

  addMessage(content, sender, noFormat = false, isHtml = false) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `chatbot-message ${sender}`;
    
    let parsedContent = content;
    if (!noFormat && !isHtml) {
        parsedContent = parsedContent.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
        parsedContent = parsedContent.replace(/\n/g, '<br>');
    }
    
    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    let copyBtnHtml = '';
    
    if (sender === 'bot') {
        copyBtnHtml = `<button class="copy-msg-btn" aria-label="Copiar mensaje" style="background:none; border:none; color:var(--gold); cursor:pointer; font-size: 0.8rem; margin-top: 8px; display: flex; align-items: center; gap: 4px; opacity: 0.8;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
            Copiar
        </button>`;
    }

    messageDiv.innerHTML = `<div class="message-content">
      ${parsedContent}
      ${copyBtnHtml}
      <div style="font-size: 0.7rem; color: rgba(255,255,255,0.4); text-align: right; margin-top: 5px;">${time}</div>
    </div>`;
    
    if (sender === 'bot') {
        const copyBtn = messageDiv.querySelector('.copy-msg-btn');
        if (copyBtn) {
            copyBtn.addEventListener('click', () => {
                navigator.clipboard.writeText(content).then(() => {
                    copyBtn.innerHTML = '¡Copiado! ✓';
                    setTimeout(() => {
                        copyBtn.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> Copiar`;
                    }, 2000);
                });
            });
        }
    }

    this.messages.appendChild(messageDiv);
    this.scrollToBottom();
  }

  addTypingIndicator() {
    if (this.messages.querySelector('.typing-message')) return;
    const typingDiv = document.createElement('div');
    typingDiv.className = 'chatbot-message bot typing-message';
    typingDiv.innerHTML = `<div class="message-content typing-indicator"><span></span><span></span><span></span></div>`;
    this.messages.appendChild(typingDiv);
    this.scrollToBottom();
  }

  removeTypingIndicator() {
    const typing = this.messages.querySelector('.typing-message');
    if (typing) typing.remove();
  }

  scrollToBottom() {
    this.messages.scrollTop = this.messages.scrollHeight;
  }
}

// ============================================
// INICIALIZACIÓN
// ============================================
function initializeChatbot() {
  try {
    window.chatbot = new ChatbotIA();
    console.log('✓ Chatbot inicializado exitosamente');
  } catch (error) {
    console.error('✗ Error al inicializar chatbot:', error);
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initializeChatbot);
} else {
  initializeChatbot();
}