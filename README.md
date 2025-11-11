# Epic Prompts - MVP

Piattaforma gamificata per la condivisione e scoperta di prompt AI.

## 🚀 Panoramica

Epic Prompts è una piattaforma WordPress che permette agli utenti di:
- Condividere prompt AI per image generation (Midjourney, DALL-E, Stable Diffusion, Leonardo.ai)
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
│   │       │   ├── taxonomies.php      # Taxonomies
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
   - `ai_prompt` - Prompt AI
   - `prompt_vote` - Voti e recensioni
   - `prompt_collection` - Collezioni (futuro)

2. **Taxonomies**
   - `ai_platform` - Piattaforme AI (Midjourney, DALL-E, etc.)
   - `prompt_category` - Categorie (Character Design, Landscapes, etc.)
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
   - Browse grid con filtri (piattaforma, categoria, sort)
   - Single prompt page con reactions
   - Submit form con upload immagini
   - User profile con stats e badge
   - Leaderboard globale

6. **User Stats Tracking**
   - XP totale e mensile
   - Prompts submitted
   - Votes cast
   - Reviews written
   - Streak days
   - Reputation score

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
- Validation lato server per upload immagini (max 5MB, solo JPG/PNG/WebP)
- Capability checks per azioni privilegiate
- Rate limiting preparato (da implementare in produzione)

## 🚧 TODO / Roadmap

### Fase 2 (Post-MVP)
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
- [ ] Video prompts (Sora, Runway)
- [ ] ChatGPT/Claude prompts
- [ ] Premium features opzionali
- [ ] Localizzazione italiana

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

## 🤝 Contribuire

Epic Prompts è in fase MVP. Contributi benvenuti!

## 📝 License

Proprietario - Epic Prompts Team

## 🐛 Bug Reports

Segnala bug e richieste features via GitHub Issues.

---

**Built with ❤️ for the AI community**

*Version: 1.0.0 - MVP*
*Date: November 2025*
