# Epic Prompts - Universal AI Prompts Platform

Piattaforma gamificata per la condivisione e scoperta di **prompts per tutte le piattaforme AI**.

## 🚀 Panoramica

Epic Prompts è una piattaforma WordPress universale che permette agli utenti di:
- Condividere prompt AI per **qualsiasi piattaforma**: ChatGPT, Claude, Midjourney, DALL-E, Stable Diffusion, GitHub Copilot, Suno AI, e molte altre
- Gestire prompt per **tutti i tipi di output**: testo, immagini, codice, video, audio/musica
- Votare e reagire ai prompt della community
- Guadagnare XP, salire di livello e sbloccare badge
- Competere nelle leaderboard mensili e globali
- Verificare l'efficacia dei prompt

## 📋 Requisiti

- PHP 7.4+ (8.0+ raccomandato)
- MySQL 5.7+ o MariaDB 10.3+
- WordPress 6.0+
- Server web (Apache/Nginx)

## 🔧 Installazione

### 1. Setup WordPress

```bash
# Se non hai ancora WordPress installato
# Scarica e installa WordPress nella tua directory web
```

### 2. Installa Plugin

```bash
# Copia il plugin nella directory plugins di WordPress
cp -r wp-content/plugins/epic-prompts-core /path/to/wordpress/wp-content/plugins/

# Attiva il plugin dal pannello WordPress
# WP Admin > Plugin > Epic Prompts Core > Attiva
```

### 3. Installa Tema

```bash
# Copia il tema nella directory themes di WordPress
cp -r wp-content/themes/epic-prompts /path/to/wordpress/wp-content/themes/

# Attiva il tema dal pannello WordPress
# WP Admin > Aspetto > Temi > Epic Prompts > Attiva
```

### 4. Configura Permalink

Vai su **Impostazioni > Permalink** e seleziona "Nome articolo" o un'altra struttura custom.

### 5. Crea Pagine Necessarie

Crea le seguenti pagine con i rispettivi template:

#### Pagina Submit (Template: Submit Prompt)
- Titolo: "Submit Prompt"
- Slug: `submit`
- Template: Submit Prompt

#### Pagina Leaderboard (Template: Leaderboard)
- Titolo: "Leaderboard"
- Slug: `leaderboard`
- Template: Leaderboard

## 🎨 Struttura Progetto

```
epic-prompts/
├── wp-content/
│   ├── plugins/
│   │   └── epic-prompts-core/          # Plugin principale
│   │       ├── epic-prompts-core.php   # File principale plugin
│   │       ├── includes/               # Logica backend
│   │       │   ├── post-types.php      # Custom Post Types
│   │       │   ├── taxonomies.php      # Taxonomies (50+ piattaforme AI)
│   │       │   ├── user-functions.php  # Funzioni utente
│   │       │   ├── xp-system.php       # Sistema XP e livelli
│   │       │   └── ajax-handlers.php   # Handler AJAX
│   │       └── assets/
│   │           ├── js/
│   │           └── css/
│   │
│   └── themes/
│       └── epic-prompts/               # Tema frontend
│           ├── style.css               # Stili principali
│           ├── functions.php           # Funzioni tema
│           ├── header.php              # Header
│           ├── footer.php              # Footer
│           ├── index.php               # Homepage
│           ├── archive-ai_prompt.php   # Griglia prompts
│           ├── single-ai_prompt.php    # Singolo prompt
│           ├── author.php              # Profilo utente
│           ├── page-submit.php         # Form submission
│           ├── page-leaderboard.php    # Leaderboard
│           ├── template-parts/
│           │   └── prompt-card.php     # Card prompt
│           ├── js/
│           │   └── main.js             # JavaScript principale
│           └── css/
│               └── custom.css          # CSS aggiuntivo
```

## 🎮 Features MVP

### ✅ Completate

1. **Custom Post Types**
   - `ai_prompt` - Prompt AI universali
   - `prompt_vote` - Voti e recensioni
   - `prompt_collection` - Collezioni (futuro)

2. **Taxonomies**
   - `ai_platform` - **50+ Piattaforme AI**:
     - **Text/Chat**: ChatGPT 3.5/4/4 Turbo/o1, Claude 3 (Haiku/Sonnet/Opus), Gemini 1.0/1.5/2.0, Perplexity, Microsoft Copilot, Llama 3, Mistral AI, Grok
     - **Image Generation**: Midjourney v5/v6/v7, DALL-E 2/3, Stable Diffusion XL/3, Leonardo.ai, Adobe Firefly, Ideogram, Flux
     - **Video Generation**: Runway Gen-3, Sora, Pika Labs, Synthesia, HeyGen
     - **Code Generation**: GitHub Copilot, Cursor AI, Replit AI, Amazon CodeWhisperer, Tabnine
     - **Audio/Music**: ElevenLabs, Suno AI, Udio, Mubert
     - **Other Tools**: Jasper AI, Copy.ai, Notion AI, Gamma AI
   - `prompt_type` - **20+ Tipi di Prompt**:
     - Text Generation, Image Generation, Code Generation, Video Generation, Audio Generation, Music Generation
     - Data Analysis, Content Writing, Creative Writing, Translation, Summarization
     - Question Answering, Chatbot, Role-Playing, Brainstorming, Problem Solving
     - Education, Business, Marketing, SEO
   - `prompt_category` - **40+ Categorie** organizzate per dominio
   - `prompt_tag` - Tag liberi

3. **Sistema Gamification**
   - Sistema XP con guadagno automatico
   - Livelli calcolati da XP (floor(XP/100) + 1)
   - Titoli basati su livello
   - Badge system (struttura pronta)
   - Coins virtuali

4. **Reactions System (AJAX)**
   - 5 tipi di reaction: 🔥 Fire, 💎 Gem, 🎨 Creative, 🚀 Rocket, 💡 Mindblown
   - Un voto per utente, modificabile
   - XP per chi vota (+2) e per il creator (+5)

5. **Frontend Features**
   - Browse grid con filtri (piattaforma, tipo, categoria, sort)
   - Single prompt page con reactions
   - Submit form universale con **immagine opzionale**
   - User profile con stats e badge
   - Leaderboard globale e mensile

6. **User Stats Tracking**
   - XP totale e mensile
   - Prompts submitted
   - Votes cast
   - Reviews written
   - Streak days
   - Reputation score

7. **Upload Sistema**
   - Upload immagini/screenshot opzionale
   - Max 10MB (JPG, PNG, WebP, GIF)
   - Supporto per prompt senza immagini (text, code, ecc.)

## 🎯 Guadagno XP

| Azione | XP Guadagnati |
|--------|---------------|
| Submit prompt | +10 XP |
| Vote/React | +2 XP |
| Comment | +5 XP |
| Received reaction (creator) | +5 XP |
| Daily login | +5 XP |
| Detailed review | +10 XP |
| Prompt verified | +50 XP |
| Verify prompt | +10 XP |

## 📊 Sistema Livelli

| Livello | Range XP | Titolo |
|---------|----------|--------|
| 1-5 | 0-500 | Novice Prompter |
| 6-10 | 501-2,000 | Skilled Prompter |
| 11-15 | 2,001-5,000 | Expert Prompter |
| 16-20 | 5,001-10,000 | Master Prompter |
| 21-25 | 10,001-20,000 | Prompt Architect |
| 26+ | 20,001+ | Legendary Prompter |

## 🔐 Sicurezza

- Nonce verification su tutte le chiamate AJAX
- Sanitization di tutti gli input utente
- Validation lato server per upload immagini (max 10MB, solo JPG/PNG/WebP/GIF)
- MIME type verification per file upload
- Capability checks per azioni privilegiate
- Rate limiting preparato (da implementare in produzione)

## 💡 Casi d'Uso

Epic Prompts supporta prompt per:

### 📝 Text & Content
- Email templates
- Blog post structures
- Social media captions
- Marketing copy
- Technical documentation

### 🎨 Visual & Creative
- Image generation prompts
- Art style descriptions
- Character designs
- Product photography setups

### 💻 Code & Development
- Code generation templates
- Bug fix prompts
- Code review guidelines
- Architecture suggestions

### 🎬 Multimedia
- Video generation scripts
- Music composition prompts
- Audio narration styles
- Voice cloning settings

### 🤖 Specialized AI
- Role-playing scenarios
- Educational tutoring
- Business analysis
- Data interpretation

## 🚧 TODO / Roadmap

### Fase 2 (Post-MVP)
- [ ] Filtri per Prompt Type nell'archive
- [ ] Verification system completo con upload risultati
- [ ] Rating dettagliato (5 criteri)
- [ ] Collections pubbliche/private
- [ ] Following system
- [ ] Notification system in-app
- [ ] Email notifications
- [ ] Daily/Weekly quests
- [ ] Duels/Battles system
- [ ] Seasonal events

### Fase 3 (Advanced)
- [ ] Mobile PWA
- [ ] API pubblica
- [ ] AI-powered prompt suggestions
- [ ] Prompt testing playground
- [ ] Premium features opzionali
- [ ] Localizzazione italiana
- [ ] Integration con API dirette (OpenAI, Anthropic, ecc.)

## 🎨 Design System

### Colori

```css
--primary: #6366F1 (Indigo)
--secondary: #EC4899 (Pink)
--accent: #10B981 (Green)
--background: #F9FAFB (Light gray)
--text: #111827 (Dark gray)
```

### Typography
- Headings: System fonts
- Body: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto

## 🌍 Supporto Multilingua

Attualmente supportato:
- 🇬🇧 Inglese (default)

Pianificati:
- 🇮🇹 Italiano
- 🇪🇸 Spagnolo
- 🇫🇷 Francese
- 🇩🇪 Tedesco

## 🤝 Contribuire

Epic Prompts è in fase MVP. Contributi benvenuti!

## 📝 License

Proprietario - Epic Prompts Team

## 🐛 Bug Reports

Segnala bug e richieste features via GitHub Issues.

---

**Built with ❤️ for the universal AI community**

*Version: 1.1.0 - Universal Platform*
*Date: November 2025*
*Now supporting 50+ AI platforms and 20+ prompt types!*
