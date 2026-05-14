document.addEventListener('DOMContentLoaded', () => {
    // 1. MAGNETIC CURSOR
    const cursor = document.createElement('div');
    cursor.id = 'magnetic-cursor';
    document.body.appendChild(cursor);

    let mouseX = 0, mouseY = 0;
    let cursorX = 0, cursorY = 0;

    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        
        // Parallax effect on main images/illustrations
        document.querySelectorAll('img:not(.logo):not(.brand-logo):not(.footer-logo)').forEach(img => {
            const speed = img.getAttribute('data-speed') || 0.05;
            const x = (window.innerWidth - e.pageX * speed) / 100;
            const y = (window.innerHeight - e.pageY * speed) / 100;
            img.style.transform = `translate(${x}px, ${y}px)`;
        });
    });

    const loop = () => {
        cursorX += (mouseX - cursorX) * 0.15; // smoothness
        cursorY += (mouseY - cursorY) * 0.15;
        cursor.style.transform = `translate3d(${cursorX}px, ${cursorY}px, 0)`;
        requestAnimationFrame(loop);
    };
    loop();

    // Magnetic buttons
    const magneticElements = document.querySelectorAll('.btn, .nav-link, button, .subcompany-card, .quick-action, a');
    magneticElements.forEach(el => {
        el.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            // Calculate center of element
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            
            // Calculate distance from center
            const x = e.clientX - centerX;
            const y = e.clientY - centerY;
            
            // Move element slightly towards mouse
            if(!this.classList.contains('carousel-nav')) {
                this.style.transform = `translate(${x * 0.15}px, ${y * 0.15}px)`;
            }
            cursor.classList.add('cursor-hover');
        });

        el.addEventListener('mouseleave', function() {
            if(!this.classList.contains('carousel-nav')) {
                this.style.transform = 'translate(0px, 0px)';
            }
            cursor.classList.remove('cursor-hover');
        });
    });

    // 2. CHATBOT VOICE RECOGNITION (Mic button)
    // Run periodically to catch chatbot widget if loaded dynamically
    const initMicBtn = () => {
        const inputArea = document.querySelector('.chatbot-input-area');
        if (inputArea && !document.getElementById('chatbot-mic')) {
            const micBtn = document.createElement('button');
            micBtn.id = 'chatbot-mic';
            micBtn.className = 'chatbot-mic';
            micBtn.setAttribute('aria-label', 'Hablar');
            micBtn.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
                    <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                    <line x1="12" y1="19" x2="12" y2="23"></line>
                    <line x1="8" y1="23" x2="16" y2="23"></line>
                </svg>
            `;
            const sendBtn = document.getElementById('chatbot-send');
            if (sendBtn) {
                inputArea.insertBefore(micBtn, sendBtn);
            } else {
                inputArea.appendChild(micBtn);
            }

            if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
                const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
                const recognition = new SpeechRecognition();
                recognition.lang = 'es-ES';
                recognition.interimResults = false;
                recognition.maxAlternatives = 1;

                micBtn.addEventListener('click', () => {
                    if (micBtn.classList.contains('recording')) {
                        recognition.stop();
                        micBtn.classList.remove('recording');
                    } else {
                        recognition.start();
                        micBtn.classList.add('recording');
                        playAudio('click');
                    }
                });

                recognition.onresult = (event) => {
                    const speechResult = event.results[0][0].transcript;
                    const inputField = document.getElementById('chatbot-input');
                    if (inputField) {
                        inputField.value = speechResult;
                        // Auto-send if chatbot is accessible
                        setTimeout(() => {
                            if(sendBtn) sendBtn.click();
                        }, 500);
                    }
                    micBtn.classList.remove('recording');
                };

                recognition.onspeechend = () => {
                    recognition.stop();
                    micBtn.classList.remove('recording');
                };

                recognition.onerror = (event) => {
                    console.error('Speech recognition error', event.error);
                    micBtn.classList.remove('recording');
                };
            } else {
                micBtn.style.display = 'none'; // Not supported
            }
        }
    };
    initMicBtn();
    setTimeout(initMicBtn, 1000); // Check again in case of async load

    // 3. THEME TOGGLER (Cyber Glassmorphism)
    // Find the right place to put the toggle
    const headerNav = document.querySelector('.main-nav, .nav-menu, header nav');
    if (headerNav) {
        const themeBtn = document.createElement('button');
        themeBtn.id = 'theme-toggle';
        themeBtn.className = 'theme-toggle';
        themeBtn.innerHTML = '✨ Modo Cyber';
        
        // Append before the first link or at the end
        headerNav.appendChild(themeBtn);

        themeBtn.addEventListener('click', () => {
            document.body.classList.toggle('cyber-theme');
            if (document.body.classList.contains('cyber-theme')) {
                themeBtn.innerHTML = '🌙 Modo Clásico';
                playAudio('cyber');
            } else {
                themeBtn.innerHTML = '✨ Modo Cyber';
                playAudio('classic');
            }
            
            // Update carousel backgrounds if they exist
            document.querySelectorAll('.slide-bg').forEach(bg => {
                if(document.body.classList.contains('cyber-theme')) {
                    bg.style.background = bg.style.background.replace(/rgba\(212, 175, 55,/g, 'rgba(0, 240, 255,');
                } else {
                    bg.style.background = bg.style.background.replace(/rgba\(0, 240, 255,/g, 'rgba(212, 175, 55,');
                }
            });
        });
    }

    // 4. ADVANCED SCROLL REVEAL (Dynamic masking)
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('innovative-reveal-visible');
                // Optional: unobserve after reveal
                // observer.unobserve(entry.target); 
            }
        });
    }, observerOptions);

    document.querySelectorAll('section, .card, .step, .pc, .sc, .proceso-step').forEach(el => {
        // Skip elements that already have a reveal logic from original script to prevent conflicts,
        // or just apply our innovative reveal. We'll use our own class.
        if(!el.classList.contains('hero') && !el.classList.contains('hero-full-carousel')) {
            el.classList.add('innovative-reveal');
            observer.observe(el);
        }
    });

    // 5. AUDIO MICRO-INTERACTIONS
    let audioCtx = null;
    
    function initAudio() {
        if (!audioCtx) {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        }
        if (audioCtx.state === 'suspended') {
            audioCtx.resume();
        }
    }

    // Initialize audio on first user interaction to bypass browser autoplay policies
    document.body.addEventListener('click', initAudio, { once: true });
    
    function playAudio(type) {
        if (!audioCtx) return;
        if (audioCtx.state === 'suspended') audioCtx.resume();
        
        const osc = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();
        osc.connect(gainNode);
        gainNode.connect(audioCtx.destination);
        
        const now = audioCtx.currentTime;
        
        if (type === 'hover') {
            osc.type = 'sine';
            osc.frequency.setValueAtTime(800, now);
            osc.frequency.exponentialRampToValueAtTime(1200, now + 0.05);
            gainNode.gain.setValueAtTime(0.01, now); // Very subtle
            gainNode.gain.exponentialRampToValueAtTime(0.001, now + 0.1);
            osc.start(now);
            osc.stop(now + 0.1);
        } else if (type === 'click') {
            osc.type = 'triangle';
            osc.frequency.setValueAtTime(400, now);
            osc.frequency.exponentialRampToValueAtTime(800, now + 0.1);
            gainNode.gain.setValueAtTime(0.03, now);
            gainNode.gain.exponentialRampToValueAtTime(0.001, now + 0.2);
            osc.start(now);
            osc.stop(now + 0.2);
        } else if (type === 'cyber') {
            // Futuristic boot up sound
            osc.type = 'sawtooth';
            osc.frequency.setValueAtTime(150, now);
            osc.frequency.exponentialRampToValueAtTime(600, now + 0.3);
            gainNode.gain.setValueAtTime(0.05, now);
            gainNode.gain.exponentialRampToValueAtTime(0.001, now + 0.4);
            osc.start(now);
            osc.stop(now + 0.4);
        } else if (type === 'classic') {
            // Power down / soft sound
            osc.type = 'sine';
            osc.frequency.setValueAtTime(600, now);
            osc.frequency.exponentialRampToValueAtTime(200, now + 0.3);
            gainNode.gain.setValueAtTime(0.05, now);
            gainNode.gain.exponentialRampToValueAtTime(0.001, now + 0.4);
            osc.start(now);
            osc.stop(now + 0.4);
        }
    }

    // Attach subtle sounds
    document.querySelectorAll('.btn, .nav-link, .ptab, .chatbot-toggle').forEach(el => {
        el.addEventListener('mouseenter', () => playAudio('hover'));
        el.addEventListener('click', () => playAudio('click'));
    });

    // 6. SCROLL PROGRESS INDICATOR (Cyber/Gold Glow)
    const progressBar = document.createElement('div');
    progressBar.id = 'scroll-progress';
    Object.assign(progressBar.style, {
        position: 'fixed',
        top: '0',
        left: '0',
        height: '4px',
        background: 'var(--gold, #d4af37)',
        width: '0%',
        zIndex: '99999',
        transition: 'width 0.1s ease',
        boxShadow: '0 0 10px var(--gold, #d4af37)',
        borderBottomRightRadius: '4px',
        borderTopRightRadius: '4px'
    });
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrollPercent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
        progressBar.style.width = scrollPercent + '%';
        
        if (document.body.classList.contains('cyber-theme')) {
            progressBar.style.background = '#00f0ff';
            progressBar.style.boxShadow = '0 0 15px #00f0ff, 0 0 5px #00f0ff';
        } else {
            progressBar.style.background = 'var(--gold, #d4af37)';
            progressBar.style.boxShadow = '0 0 15px var(--gold, #d4af37), 0 0 5px var(--gold, #d4af37)';
        }
    });

    // 7. 3D TILT EFFECT FOR CARDS (Glassmorphism interaction)
    const tiltElements = document.querySelectorAll('.card, .subcompany-card, .service-card, .proceso-step, .testimonial-card');
    tiltElements.forEach(el => {
        el.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = ((y - centerY) / centerY) * -8; // Max 8 degrees
            const rotateY = ((x - centerX) / centerX) * 8;
            
            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
            this.style.transition = 'transform 0.1s ease';
            this.style.zIndex = '10';
        });

        el.addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
            this.style.transition = 'transform 0.5s ease';
            this.style.zIndex = '1';
        });
    });

    // 8. TEXT SCRAMBLE EFFECT ON HOVER (Cyberpunk Matrix effect)
    const scrambleLetters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%&*<>/|";
    const scrambleElements = document.querySelectorAll('h2, .hero-label');
    
    scrambleElements.forEach(el => {
        el.dataset.original = el.innerText;
        el.addEventListener('mouseenter', event => {
            let iterations = 0;
            clearInterval(el.scrambleInterval);
            
            el.scrambleInterval = setInterval(() => {
                event.target.innerText = event.target.innerText.split("").map((letter, index) => {
                    if(index < iterations) {
                        return event.target.dataset.original[index];
                    }
                    return scrambleLetters[Math.floor(Math.random() * scrambleLetters.length)];
                }).join("");
                
                if(iterations >= event.target.dataset.original.length){
                    clearInterval(el.scrambleInterval);
                    event.target.innerText = event.target.dataset.original; // ensure exact match at end
                }
                iterations += 1/2; // Speed of scramble
            }, 30);
            
            // Small mechanical sound effect for scramble
            if (Math.random() > 0.5) playAudio('hover');
        });
    });

    // 9. DYNAMIC BACKGROUND PARTICLES (Interactive Constellation)
    const canvas = document.createElement('canvas');
    canvas.id = 'particle-network';
    Object.assign(canvas.style, {
        position: 'fixed',
        top: '0',
        left: '0',
        width: '100vw',
        height: '100vh',
        zIndex: '-5', // Behind everything
        pointerEvents: 'none',
        opacity: '0.5'
    });
    document.body.prepend(canvas);
    
    const ctx = canvas.getContext('2d');
    let width, height;
    let particles = [];
    
    function resize() {
        width = window.innerWidth;
        height = window.innerHeight;
        canvas.width = width;
        canvas.height = height;
    }
    window.addEventListener('resize', resize);
    resize();
    
    class Particle {
        constructor() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.vx = (Math.random() - 0.5) * 0.8; // speed
            this.vy = (Math.random() - 0.5) * 0.8;
            this.radius = Math.random() * 2 + 1;
        }
        update() {
            this.x += this.vx;
            this.y += this.vy;
            if (this.x < 0 || this.x > width) this.vx *= -1;
            if (this.y < 0 || this.y > height) this.vy *= -1;
        }
        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            const isCyber = document.body.classList.contains('cyber-theme');
            ctx.fillStyle = isCyber ? 'rgba(0, 240, 255, 0.6)' : 'rgba(212, 175, 55, 0.6)';
            ctx.fill();
        }
    }
    
    // Density based on screen size
    const particleCount = Math.floor((window.innerWidth * window.innerHeight) / 15000);
    for (let i = 0; i < Math.min(particleCount, 80); i++) particles.push(new Particle());
    
    function animateParticles() {
        ctx.clearRect(0, 0, width, height);
        
        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
            
            // Connect to mouse (using the cursor variables from Magnetic Cursor)
            const dx = cursorX - particles[i].x;
            const dy = cursorY - particles[i].y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            
            if (dist < 180) {
                ctx.beginPath();
                ctx.moveTo(particles[i].x, particles[i].y);
                ctx.lineTo(cursorX, cursorY);
                const isCyber = document.body.classList.contains('cyber-theme');
                ctx.strokeStyle = isCyber ? `rgba(0, 240, 255, ${0.8 - dist/180})` : `rgba(212, 175, 55, ${0.8 - dist/180})`;
                ctx.lineWidth = 1.5;
                ctx.stroke();
            }
            
            // Connect to other particles
            for (let j = i + 1; j < particles.length; j++) {
                const dx2 = particles[i].x - particles[j].x;
                const dy2 = particles[i].y - particles[j].y;
                const dist2 = Math.sqrt(dx2 * dx2 + dy2 * dy2);
                
                if (dist2 < 120) {
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    const isCyber = document.body.classList.contains('cyber-theme');
                    ctx.strokeStyle = isCyber ? `rgba(0, 240, 255, ${0.3 * (1 - dist2/120)})` : `rgba(212, 175, 55, ${0.3 * (1 - dist2/120)})`;
                    ctx.lineWidth = 1;
                    ctx.stroke();
                }
            }
        }
        requestAnimationFrame(animateParticles);
    }
    animateParticles();
});
