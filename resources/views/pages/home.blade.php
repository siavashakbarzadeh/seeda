<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Seeda — Premium Software Solutions</title>
  <meta name="description"
    content="Seeda is a cutting-edge software company delivering innovative web, mobile, and cloud solutions. Explore our portfolio of 10+ successful projects." />
  <link rel="stylesheet" href="{{ asset('style.css') }}" />
  <link rel="icon"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌱</text></svg>" />
</head>

<body>

  <!-- Background Glow -->
  <div class="bg-glow">
    <div class="orb"></div>
    <div class="orb"></div>
    <div class="orb"></div>
  </div>

  <!-- Navbar -->
  <nav class="navbar" id="navbar">
    <div class="container">
      <a href="#" class="logo">Seeda<span>.</span></a>
      <ul class="nav-links" id="navLinks">
        <li><a href="#about" data-en="About" data-it="Chi Siamo">About</a></li>
        <li><a href="#services" data-en="Services" data-it="Servizi">Services</a></li>
        <li><a href="#catalog" data-en="Catalog" data-it="Catalogo">Catalog</a></li>
        <li><a href="#portfolio" data-en="Portfolio" data-it="Portfolio">Portfolio</a></li>
        <li><a href="#tech" data-en="Technologies" data-it="Tecnologie">Technologies</a></li>
        <li><a href="#testimonials" data-en="Reviews" data-it="Recensioni">Reviews</a></li>
        <li><a href="#pricing" data-en="Pricing" data-it="Prezzi">Pricing</a></li>
        <li><a href="#contact" class="nav-cta" data-en="Contact Us" data-it="Contattaci">Contact Us</a></li>
        <li><a href="{{ route('filament.admin.auth.login') }}" class="nav-cta" style="background: var(--gradient-3);" data-en="Login" data-it="Accedi">Login</a></li>
        <li>
          <button class="lang-switcher" id="langSwitcher" onclick="toggleLanguage()">
            <span class="lang-flag" id="langFlag">🇬🇧</span>
            <span class="lang-text" id="langText">EN</span>
          </button>
        </li>
      </ul>
      <div class="hamburger" id="hamburger" onclick="toggleMenu()">
        <span></span><span></span><span></span>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero" id="hero">
    <div class="container">
      <div class="hero-content">
        <div class="hero-text">
          <div class="hero-badge">
            <span class="dot"></span>
            Available for new projects
          </div>
          <h1>We Build <span class="highlight">Digital Products</span> That Matter</h1>
          <p>From concept to launch, Seeda transforms bold ideas into powerful software solutions. We craft experiences
            that users love and businesses trust.</p>
          <div class="hero-buttons">
            <a href="#portfolio" class="btn-primary">View Our Work</a>
            <a href="#contact" class="btn-secondary">Get a Quote</a>
          </div>
        </div>
        <div class="hero-visual">
          <div class="hero-card">
            <div class="code-lines">
              <div class="line"><span class="num">1</span><span class="keyword">const</span> <span
                  class="func">seeda</span> = {</div>
              <div class="line"><span class="num">2</span>&nbsp;&nbsp;<span class="func">mission</span>: <span
                  class="str">"Innovate"</span>,</div>
              <div class="line"><span class="num">3</span>&nbsp;&nbsp;<span class="func">quality</span>: <span
                  class="str">"Premium"</span>,</div>
              <div class="line"><span class="num">4</span>&nbsp;&nbsp;<span class="func">clients</span>: <span
                  class="str">"150+"</span>,</div>
              <div class="line"><span class="num">5</span>&nbsp;&nbsp;<span class="func">passion</span>: <span
                  class="str">"∞"</span>,</div>
              <div class="line"><span class="num">6</span>};</div>
              <div class="line"><span class="num">7</span><span class="comment">// Let's build something great 🚀</span>
              </div>
            </div>
          </div>
          <div class="floating-badge top-right">
            ✅ 99.9% Uptime
          </div>
          <div class="floating-badge bottom-left">
            🚀 Fast Delivery
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats -->
  <div class="stats-bar">
    <div class="container">
      <div class="stats-grid">
        <div class="stat-item fade-in">
          <h3>150+</h3>
          <p>Projects Delivered</p>
        </div>
        <div class="stat-item fade-in">
          <h3>80+</h3>
          <p>Happy Clients</p>
        </div>
        <div class="stat-item fade-in">
          <h3>12+</h3>
          <p>Years Experience</p>
        </div>
        <div class="stat-item fade-in">
          <h3>25+</h3>
          <p>Team Members</p>
        </div>
      </div>
    </div>
  </div>

  <!-- About -->
  <section id="about">
    <div class="container">
      <div class="about-grid">
        <div class="about-text fade-in">
          <span class="section-label">Who We Are</span>
          <h3>Crafting Software with Purpose & Precision</h3>
          <p>Seeda is a forward-thinking software company specializing in building scalable, beautiful, and
            high-performance digital solutions. We partner with startups and enterprises to turn complex challenges into
            elegant software.</p>
          <p>Our team combines deep technical expertise with creative design thinking to deliver products that stand out
            in today's competitive landscape.</p>
          <div class="about-features">
            <div class="about-feature"><span class="icon">⚡</span> Agile Development</div>
            <div class="about-feature"><span class="icon">🎨</span> UX-First Design</div>
            <div class="about-feature"><span class="icon">🔒</span> Secure & Scalable</div>
            <div class="about-feature"><span class="icon">🤝</span> Dedicated Support</div>
          </div>
        </div>
        <div class="about-visual fade-in">
          <div class="about-card">
            <div class="number">98%</div>
            <div class="label">Client Satisfaction</div>
          </div>
          <div class="about-card">
            <div class="number">3x</div>
            <div class="label">Faster Delivery</div>
          </div>
          <div class="about-card">
            <div class="number">24/7</div>
            <div class="label">Technical Support</div>
          </div>
          <div class="about-card">
            <div class="number">50+</div>
            <div class="label">Industries Served</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services -->
  <section id="services">
    <div class="container">
      <div class="section-header fade-in">
        <span class="section-label">Our Services</span>
        <h2>What We Do Best</h2>
        <p>End-to-end software development services tailored to your business needs</p>
      </div>
      <div class="services-grid">
        <div class="service-card fade-in">
          <div class="service-icon">🌐</div>
          <h3>Web Development</h3>
          <p>Custom web applications built with the latest frameworks — React, Next.js, Vue, and more. Responsive, fast,
            and scalable.</p>
        </div>
        <div class="service-card fade-in">
          <div class="service-icon">📱</div>
          <h3>Mobile Apps</h3>
          <p>Native and cross-platform mobile applications for iOS and Android using Flutter, React Native, and Swift.
          </p>
        </div>
        <div class="service-card fade-in">
          <div class="service-icon">🎨</div>
          <h3>UI/UX Design</h3>
          <p>Human-centered design that converts. We create wireframes, prototypes, and stunning interfaces users love.
          </p>
        </div>
        <div class="service-card fade-in">
          <div class="service-icon">☁️</div>
          <h3>Cloud & DevOps</h3>
          <p>AWS, Google Cloud, Azure infrastructure setup. CI/CD pipelines, containerization, and serverless
            architecture.</p>
        </div>
        <div class="service-card fade-in">
          <div class="service-icon">🤖</div>
          <h3>AI & Machine Learning</h3>
          <p>Intelligent solutions powered by ML models, NLP, computer vision, and recommendation engines for smarter
            products.</p>
        </div>
        <div class="service-card fade-in">
          <div class="service-icon">🛡️</div>
          <h3>Cybersecurity</h3>
          <p>Comprehensive security audits, penetration testing, and secure development practices to protect your
            business.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== SERVICE CATALOG ===== -->
  <div id="catalog">

    <!-- === SIDEBAR + CATALOG SECTIONS === -->
    <section class="catalog-wrapper">
      <div class="container">
        <div class="catalog-layout">

          <!-- Sidebar Nav -->
          <aside class="catalog-sidebar fade-in">
            <div class="sidebar-group">
              <h4 data-en="Coding" data-it="Coding">Coding</h4>
              <a href="#cat-web" class="sidebar-link active" data-en="web development" data-it="sviluppo web">web development</a>
              <a href="#cat-software" class="sidebar-link" data-en="software development" data-it="sviluppo software">software development</a>
              <a href="#cat-virtual" class="sidebar-link" data-en="virtual experiences" data-it="esperienze virtuali">virtual experiences</a>
            </div>
            <div class="sidebar-group">
              <h4 data-en="Consulting" data-it="Consulenza">Consulting</h4>
              <a href="#cat-analysis" class="sidebar-link" data-en="business analysis" data-it="analisi di business">business analysis</a>
              <a href="#cat-growth" class="sidebar-link" data-en="business development" data-it="sviluppo di business">business development</a>
              <a href="#cat-research" class="sidebar-link" data-en="market research" data-it="ricerche di mercato">market research</a>
            </div>
            <div class="sidebar-group">
              <h4 data-en="Design" data-it="Design">Design</h4>
              <a href="#cat-graphic" class="sidebar-link" data-en="graphics" data-it="grafica">graphics</a>
              <a href="#cat-industrial" class="sidebar-link" data-en="industrial design" data-it="design industriale">industrial design</a>
              <a href="#cat-webdesign" class="sidebar-link" data-en="web design" data-it="web design">web design</a>
            </div>
            <div class="sidebar-brand">
              <span class="sidebar-logo">Seeda</span>
              <span class="sidebar-tagline" data-en="we like it simple" data-it="ci piace la semplicità">we like it simple</span>
            </div>
          </aside>

          <!-- Main Catalog Content -->
          <div class="catalog-content">

            <!-- ====== WEB DEVELOPMENT ====== -->
            <div id="cat-web" class="catalog-section fade-in">
              <h2 class="catalog-title" data-en="web development" data-it="sviluppo web">web development</h2>
              <p class="catalog-desc" data-en="Need a website to best represent your business or want to develop an innovative business idea but don't know how to turn it into an application? At Seeda, we accompany our clients at every stage of the project, offering tailor-made solutions to meet their needs and realize their visions." data-it="Hai bisogno di un sito web per rappresentare al meglio la tua azienda o vuoi sviluppare un modello di business innovativo ma non sai come trasformarlo in un'applicazione? In Seeda, accompagniamo i nostri clienti in ogni fase del progetto, offrendo soluzioni su misura per soddisfare le loro esigenze e realizzare le loro visioni.">Need a website to best represent your business or want to develop an innovative business idea but don't know how to turn it into an application? At Seeda, we accompany our clients at every stage of the project, offering tailor-made solutions to meet their needs and realize their visions.</p>
              <div class="catalog-cards">
                <!-- Card 1 -->
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-teal-cyan">
                    <span class="catalog-price-badge">from 1,950.00 €</span>
                    <div class="catalog-shapes">
                      <div class="shape circle"></div>
                      <div class="shape circle sm"></div>
                      <div class="shape cross"></div>
                      <div class="shape cross"></div>
                      <div class="shape triangle"></div>
                    </div>
                  </div>
                  <div class="catalog-card-body">
                    <h3 data-en="web app development" data-it="sviluppo applicazioni web">web app development</h3>
                    <p data-en="Have a digital business model in mind or need a custom management platform? A web application is the ideal solution. At Seeda, we are here to support you, from concept to deployment." data-it="Hai un modello di business digitale in mente o hai bisogno di una piattaforma gestionale su misura per la tua attività? Un'applicazione web è la soluzione ideale. In Seeda, siamo qui per supportarti.">Have a digital business model in mind or need a custom management platform? A web application is the ideal solution. At Seeda, we are here to support you, from concept to deployment.</p>
                    <a href="#contact" class="catalog-cta" data-en="explore web app development" data-it="esplora sviluppo applicazioni web">explore web app development</a>
                  </div>
                </div>
                <!-- Card 2 -->
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-green-emerald">
                    <span class="catalog-price-badge">from 45.00 €</span>
                    <div class="catalog-shapes">
                      <div class="shape circle"></div>
                      <div class="shape circle lg"></div>
                      <div class="shape cross"></div>
                      <div class="shape cross"></div>
                    </div>
                  </div>
                  <div class="catalog-card-body">
                    <h3 data-en="hosting + maintenance" data-it="hosting + manutenzione">hosting + maintenance</h3>
                    <p data-en="Have you built your website or web app with us? We also handle maintenance and hosting. You can relax and focus on growing your business while we take care of the technical side." data-it="Hai realizzato il tuo sito web o la tua web app con noi? Ci occupiamo anche della manutenzione e dell'hosting. Puoi rilassarti e concentrarti sulla crescita della tua attività, mentre noi ci occupiamo della parte tecnica.">Have you built your website or web app with us? We also handle maintenance and hosting. You can relax and focus on growing your business while we take care of the technical side.</p>
                    <a href="#contact" class="catalog-cta" data-en="explore hosting + maintenance" data-it="esplora hosting + manutenzione">explore hosting + maintenance</a>
                  </div>
                </div>
                <!-- Card 3 -->
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-blue-violet">
                    <span class="catalog-price-badge">from 650.00 €</span>
                    <div class="catalog-shapes">
                      <div class="shape square"></div>
                      <div class="shape cross"></div>
                      <div class="shape cross"></div>
                      <div class="shape square sm"></div>
                    </div>
                  </div>
                  <div class="catalog-card-body">
                    <h3 data-en="static website" data-it="sito statico">static website</h3>
                    <p data-en="Want a site to showcase your clients and present your company or your business idea? At Seeda, we create unique styled websites thanks to our expertise in graphics and design." data-it="Desideri un sito da mostrare ai tuoi clienti per presentare la tua azienda o la tua idea di business? In Seeda, creiamo siti web dallo stile unico, grazie alla nostra expertise in grafica e design.">Want a site to showcase your clients and present your company or your business idea? At Seeda, we create unique styled websites thanks to our expertise in graphics and design.</p>
                    <a href="#contact" class="catalog-cta" data-en="explore static website" data-it="esplora sito statico">explore static website</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- ====== SOFTWARE DEVELOPMENT ====== -->
            <div id="cat-software" class="catalog-section fade-in">
              <h2 class="catalog-title" data-en="software development" data-it="sviluppo software">software development</h2>
              <p class="catalog-desc" data-en="Want to develop software but don't know where to start? Trust us. We'll help you choose the best solution among the infinite opportunities technology offers, to build exactly what you have in mind. The only limit? Your imagination." data-it="Vuoi sviluppare un software ma non sai da dove iniziare? Affidati a noi. Ti aiuteremo a scegliere la soluzione migliore tra le infinite opportunità che la tecnologia offre, per realizzare esattamente ciò che hai in mente. L'unico limite? La tua immaginazione.">Want to develop software but don't know where to start? Trust us. We'll help you choose the best solution among the infinite opportunities technology offers, to build exactly what you have in mind. The only limit? Your imagination.</p>
              <div class="catalog-cards">
                <!-- Card 1 -->
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-teal-cyan">
                    <span class="catalog-price-badge">from 65.00 €</span>
                    <div class="catalog-shapes">
                      <div class="shape triangle"></div>
                      <div class="shape circle sm"></div>
                      <div class="shape cross"></div>
                      <div class="shape triangle"></div>
                    </div>
                  </div>
                  <div class="catalog-card-body">
                    <h3 data-en="IT consulting (hourly)" data-it="consulenza IT (prezzo orario)">IT consulting (hourly)</h3>
                    <p data-en="Unlock the potential of your business with our IT consulting services. We help you evaluate and implement technology strategies aligned with your business goals." data-it="Sblocca il potenziale del tuo business con i nostri servizi di consulenza IT. Ti aiutiamo a valutare e implementare strategie tecnologiche allineate ai tuoi obiettivi aziendali.">Unlock the potential of your business with our IT consulting services. We help you evaluate and implement technology strategies aligned with your business goals.</p>
                    <a href="#contact" class="catalog-cta" data-en="explore IT consulting" data-it="esplora consulenza IT (prezzo orario)">explore IT consulting</a>
                  </div>
                </div>
                <!-- Card 2 -->
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-purple-violet">
                    <span class="catalog-price-badge">from 1,950.00 €</span>
                    <div class="catalog-shapes">
                      <div class="shape rect"></div>
                      <div class="shape rect"></div>
                      <div class="shape rect"></div>
                    </div>
                  </div>
                  <div class="catalog-card-body">
                    <h3 data-en="software prototyping" data-it="prototipazione software">software prototyping</h3>
                    <p data-en="Improve your software development process with our prototyping services. Create alternative versions of your application for progressive improvement. Our prototypes help you iterate faster." data-it="Migliora il tuo processo di sviluppo software con i nostri servizi di prototipazione. Crea versioni alternative della tua applicazione per favorire un miglioramento progressivo. I nostri prototipi ti aiutano a iterare più velocemente.">Improve your software development process with our prototyping services. Create alternative versions of your application for progressive improvement. Our prototypes help you iterate faster.</p>
                    <a href="#contact" class="catalog-cta" data-en="explore software prototyping" data-it="esplora prototipazione software">explore software prototyping</a>
                  </div>
                </div>
                <!-- Card 3 -->
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-blue-violet">
                    <span class="catalog-price-badge">from 1,950.00 €</span>
                    <div class="catalog-shapes">
                      <div class="shape circle"></div>
                      <div class="shape triangle"></div>
                      <div class="shape cross"></div>
                    </div>
                  </div>
                  <div class="catalog-card-body">
                    <h3 data-en="custom software" data-it="custom software">custom software</h3>
                    <p data-en="Need customized digital solutions for your business, like management software? Contact us! We'll help you choose the most suitable platforms and develop exactly what you need." data-it="Hai bisogno di soluzioni digitali personalizzate per la tua azienda, come un applicativo gestionale? Contattaci! Ti aiuteremo a scegliere le piattaforme più adatte e a sviluppare esattamente ciò di cui hai bisogno.">Need customized digital solutions for your business, like management software? Contact us! We'll help you choose the most suitable platforms and develop exactly what you need.</p>
                    <a href="#contact" class="catalog-cta" data-en="explore custom software" data-it="esplora custom software">explore custom software</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- ====== VIRTUAL EXPERIENCES ====== -->
            <div id="cat-virtual" class="catalog-section fade-in">
              <h2 class="catalog-title" data-en="virtual experiences" data-it="esperienze virtuali">virtual experiences</h2>
              <p class="catalog-desc" data-en="We are passionate about art, software, and music. From the intersection of these three worlds, interactive applications are born that can tell stories and convey deep messages. At Seeda, we love creating immersive virtual experiences from the simplest video games to augmented reality applications." data-it="Siamo innamorati di arte, software e musica. Dall'incontro di questi tre mondi nascono applicazioni interattive in grado di raccontare storie e trasmettere messaggi profondi. In Seeda, amiamo creare e vivere esperienze virtuali: dai videogiochi più semplici alle applicazioni di realtà aumentata.">We are passionate about art, software, and music. From the intersection of these three worlds, interactive applications are born that can tell stories and convey deep messages. At Seeda, we love creating immersive virtual experiences from the simplest video games to augmented reality applications.</p>
              <div class="catalog-cards">
                <!-- Card 1 -->
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-teal-cyan">
                    <span class="catalog-price-badge">from 1,950.00 €</span>
                    <div class="catalog-shapes">
                      <div class="shape circle"></div>
                      <div class="shape circle sm"></div>
                      <div class="shape cross"></div>
                    </div>
                  </div>
                  <div class="catalog-card-body">
                    <h3 data-en="AR application" data-it="applicazione AR">AR application</h3>
                    <p data-en="Augmented reality has transformed many of our daily activities in recent years. From interactive advertising to cultural guides, it's a technology that continues to fascinate and innovate." data-it="La realtà aumentata ha trasformato molte delle nostre attività quotidiane negli ultimi anni. Dalla pubblicità interattiva alle guide culturali, è una tecnologia che continua ad affascinare e innovare.">Augmented reality has transformed many of our daily activities in recent years. From interactive advertising to cultural guides, it's a technology that continues to fascinate and innovate.</p>
                    <a href="#contact" class="catalog-cta" data-en="explore AR application" data-it="esplora applicazione AR">explore AR application</a>
                  </div>
                </div>
                <!-- Card 2 -->
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-purple-violet">
                    <span class="catalog-price-badge">from 1,950.00 €</span>
                    <div class="catalog-shapes">
                      <div class="shape triangle"></div>
                      <div class="shape triangle rot"></div>
                      <div class="shape cross"></div>
                    </div>
                  </div>
                  <div class="catalog-card-body">
                    <h3 data-en="VR application" data-it="applicazione VR">VR application</h3>
                    <p data-en="Virtual reality is revolutionizing the way we experience digital interactions, immersing us in interactive and engaging worlds. From entertainment to education, from medical to architectural applications." data-it="La realtà virtuale sta rivoluzionando il modo in cui viviamo esperienze digitali, immergendoci in mondi interattivi e coinvolgenti. Dall'intrattenimento all'educazione, fino alle applicazioni mediche e architettoniche.">Virtual reality is revolutionizing the way we experience digital interactions, immersing us in interactive and engaging worlds. From entertainment to education, from medical to architectural applications.</p>
                    <a href="#contact" class="catalog-cta" data-en="explore VR application" data-it="esplora applicazione VR">explore VR application</a>
                  </div>
                </div>
                <!-- Card 3: videogame design -->
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-blue-violet"><span class="catalog-price-badge">from 1,950.00 €</span><div class="catalog-shapes"><div class="shape circle"></div><div class="shape triangle"></div><div class="shape cross"></div><div class="shape triangle rot"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="videogame design" data-it="videogame design">videogame design</h3><p data-en="Creating a video game is an extraordinary journey where art, storytelling, and technology merge to give life to immersive and engaging experiences." data-it="La creazione di un videogioco è un viaggio straordinario, in cui arte, narrazione e tecnologia si fondono per dar vita a esperienze immersive e coinvolgenti.">Creating a video game is an extraordinary journey where art, storytelling, and technology merge.</p><a href="#contact" class="catalog-cta" data-en="explore videogame design" data-it="esplora videogame design">explore videogame design</a></div>
                </div>
              </div>
            </div>

            <!-- ====== BUSINESS ANALYSIS ====== -->
            <div id="cat-analysis" class="catalog-section fade-in">
              <h2 class="catalog-title" data-en="business analysis" data-it="analisi di business">business analysis</h2>
              <p class="catalog-desc" data-en="Ever wondered what it would be like to observe your business from above? At Seeda, we use the best business analysis tools to develop winning strategies." data-it="Ti sei mai chiesto come sarebbe osservare la tua azienda dall'alto? In Seeda utilizziamo i migliori strumenti di analisi aziendale per sviluppare strategie vincenti.">Ever wondered what it would be like to observe your business from above?</p>
              <div class="catalog-cards">
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-warm-pink"><span class="catalog-price-badge">from 550.00 €</span><div class="catalog-shapes"><div class="shape circle"></div><div class="shape circle sm"></div><div class="shape circle lg"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="competitors + benchmarking" data-it="competitors + benchmarking">competitors + benchmarking</h3><p data-en="Compare your company's performance with competitors and industry best practices to identify improvement opportunities." data-it="Confronta le performance della tua azienda con quelle dei concorrenti e delle migliori pratiche del settore.">Compare your company's performance with competitors and best practices.</p><a href="#contact" class="catalog-cta" data-en="explore benchmarking" data-it="esplora benchmarking">explore benchmarking</a></div>
                </div>
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-mauve-pink"><span class="catalog-price-badge">from 750.00 €</span><div class="catalog-shapes"><div class="shape triangle"></div><div class="shape triangle rot"></div><div class="shape cross"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="canvas model" data-it="canvas model">canvas model</h3><p data-en="Create a control tower for your business and monitor every aspect of your company for the best decisions." data-it="Crea una torre di controllo per il tuo business e monitora ogni aspetto della tua azienda.">Create a control tower for your business and monitor every aspect.</p><a href="#contact" class="catalog-cta" data-en="explore canvas model" data-it="esplora canvas model">explore canvas model</a></div>
                </div>
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-purple-pink"><span class="catalog-price-badge">from 550.00 €</span><div class="catalog-shapes"><div class="shape circle sm"></div><div class="shape cross"></div><div class="shape triangle"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="SWOT analysis" data-it="analisi SWOT">SWOT analysis</h3><p data-en="Identify your strengths and weaknesses, threats and opportunities. Create your strategic compass." data-it="Identifica i tuoi punti di forza e di debolezza, le minacce e le opportunità. Crea la tua bussola strategica.">Identify your strengths, weaknesses, threats and opportunities.</p><a href="#contact" class="catalog-cta" data-en="explore SWOT" data-it="esplora analisi SWOT">explore SWOT</a></div>
                </div>
              </div>
            </div>

            <!-- ====== BUSINESS DEVELOPMENT ====== -->
            <div id="cat-growth" class="catalog-section fade-in">
              <h2 class="catalog-title" data-en="business development" data-it="sviluppo di business">business development</h2>
              <p class="catalog-desc" data-en="Through research, we define winning strategies for every area of your business, discovering new customer segments and opportunities." data-it="Attraverso la ricerca, definiamo strategie vincenti in ogni area della tua azienda, scoprendo nuovi segmenti e opportunità.">Through research, we define winning strategies for every area of your business.</p>
              <div class="catalog-cards">
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-warm-sunset"><span class="catalog-price-badge">from 550.00 €</span><div class="catalog-shapes"><div class="shape circle"></div><div class="shape circle sm"></div><div class="shape triangle"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="positioning" data-it="positioning">positioning</h3><p data-en="How is your product perceived in the market? Let's make it recognizable and unique against the competition." data-it="Come viene percepito il tuo prodotto sul mercato? Rendiamolo riconoscibile e unico rispetto alla concorrenza.">How is your product perceived in the market?</p><a href="#contact" class="catalog-cta" data-en="explore positioning" data-it="esplora positioning">explore positioning</a></div>
                </div>
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-mauve-pink"><span class="catalog-price-badge">from 550.00 €</span><div class="catalog-shapes"><div class="shape circle"></div><div class="shape cross"></div><div class="shape triangle rot"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="targeting" data-it="targeting">targeting</h3><p data-en="Identify and select specific market segments to target with your marketing and sales activities." data-it="Identifica e seleziona i segmenti di mercato specifici a cui indirizzare le tue attività di marketing e vendita.">Identify and select specific market segments to target.</p><a href="#contact" class="catalog-cta" data-en="explore targeting" data-it="esplora targeting">explore targeting</a></div>
                </div>
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-purple-violet"><span class="catalog-price-badge">from 750.00 €</span><div class="catalog-shapes"><div class="shape triangle"></div><div class="shape circle sm"></div><div class="shape cross"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="visioning" data-it="visioning">visioning</h3><p data-en="Define the long-term vision for your business, establishing strategic directions and future objectives." data-it="Definisci la visione a lungo termine della tua azienda, stabilendo direzioni strategiche e obiettivi futuri.">Define the long-term vision for your business.</p><a href="#contact" class="catalog-cta" data-en="explore visioning" data-it="esplora visioning">explore visioning</a></div>
                </div>
              </div>
            </div>

            <!-- ====== MARKET RESEARCH ====== -->
            <div id="cat-research" class="catalog-section fade-in">
              <h2 class="catalog-title" data-en="market research" data-it="ricerche di mercato">market research</h2>
              <p class="catalog-desc" data-en="Market research provides deep understanding of the economic system, giving us the tools to define steps for the best results." data-it="Le ricerche di mercato ci offrono una comprensione approfondita del sistema economico, fornendoci gli strumenti per definire i passaggi necessari.">Market research provides deep understanding of the economic system.</p>
              <div class="catalog-cards">
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-warm-pink"><span class="catalog-price-badge">from 550.00 €</span><div class="catalog-shapes"><div class="shape circle"></div><div class="shape circle sm"></div><div class="shape square"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="personas" data-it="personas">personas</h3><p data-en="Create detailed profiles of your ideal clients based on market research and demographic data." data-it="Crea profili dettagliati dei tuoi clienti ideali, basati su ricerche di mercato e dati demografici.">Create detailed profiles of your ideal clients.</p><a href="#contact" class="catalog-cta" data-en="explore personas" data-it="esplora personas">explore personas</a></div>
                </div>
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-mauve-pink"><span class="catalog-price-badge">from 950.00 €</span><div class="catalog-shapes"><div class="shape triangle"></div><div class="shape triangle rot"></div><div class="shape cross"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="complete market research" data-it="ricerca di mercato completa">complete market research</h3><p data-en="A detailed overview including competitor analysis, benchmarking, positioning, SWOT, personas and targeting." data-it="Una panoramica dettagliata con analisi concorrenti, benchmarking, posizionamento, SWOT, personas e targeting.">A detailed overview including competitor analysis and benchmarking.</p><a href="#contact" class="catalog-cta" data-en="explore market research" data-it="esplora ricerca di mercato">explore market research</a></div>
                </div>
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-purple-pink"><span class="catalog-price-badge">from 550.00 €</span><div class="catalog-shapes"><div class="shape circle"></div><div class="shape cross"></div><div class="shape square sm"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="market positioning" data-it="posizionamento">market positioning</h3><p data-en="There is always a special place in the market where your product can shine. Let's discover it together!" data-it="Nel mercato esiste sempre un posto speciale dove il tuo prodotto può brillare. Scopriamolo insieme!">Find the special place where your product can shine.</p><a href="#contact" class="catalog-cta" data-en="explore market positioning" data-it="esplora posizionamento">explore market positioning</a></div>
                </div>
              </div>
            </div>

            <!-- ====== GRAPHICS ====== -->
            <div id="cat-graphic" class="catalog-section fade-in">
              <h2 class="catalog-title" data-en="graphics" data-it="grafica">graphics</h2>
              <p class="catalog-desc" data-en="We are passionate about graphics and typography, creating clean and recognizable designs for your brand." data-it="Siamo appassionati di grafica e tipografia, creando design puliti e riconoscibili per il tuo brand.">We are passionate about graphics and typography.</p>
              <div class="catalog-cards">
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-golden-amber"><span class="catalog-price-badge">from 950.00 €</span><div class="catalog-shapes"><div class="shape diamond"></div><div class="shape star"></div><div class="shape cross"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="brand identity" data-it="brand identity">brand identity</h3><p data-en="Visual elements that represent your brand: logo design, brand guidelines, and stationery items." data-it="Elementi visivi che rappresentano il tuo marchio: progettazione del logo, linee guida e materiali.">Visual elements that represent your brand.</p><a href="#contact" class="catalog-cta" data-en="explore brand identity" data-it="esplora brand identity">explore brand identity</a></div>
                </div>
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-golden-amber"><span class="catalog-price-badge">from 250.00 €</span><div class="catalog-shapes"><div class="shape rect"></div><div class="shape star"></div><div class="shape cross"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="advertising graphics" data-it="grafica pubblicitaria">advertising graphics</h3><p data-en="We master the arts of typography, advertising, digital design, and print for your communication needs." data-it="Padroneggiamo le arti della tipografia, della pubblicità, del design digitale e della stampa.">Advertising, digital design, and print for your communication.</p><a href="#contact" class="catalog-cta" data-en="explore advertising graphics" data-it="esplora grafica pubblicitaria">explore advertising graphics</a></div>
                </div>
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-golden-amber"><span class="catalog-price-badge">from 95.00 €</span><div class="catalog-shapes"><div class="shape star"></div><div class="shape diamond"></div><div class="shape cross"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="logo design" data-it="logo design">logo design</h3><p data-en="A recognizable logo is fundamental for your brand. We create visual identities that stand out." data-it="Un logo riconoscibile è fondamentale per il tuo brand. Creiamo identità visive che si distinguono.">A recognizable logo is fundamental for your brand.</p><a href="#contact" class="catalog-cta" data-en="explore logo design" data-it="esplora logo design">explore logo design</a></div>
                </div>
              </div>
            </div>

            <!-- ====== INDUSTRIAL DESIGN ====== -->
            <div id="cat-industrial" class="catalog-section fade-in">
              <h2 class="catalog-title" data-en="industrial design" data-it="design industriale">industrial design</h2>
              <p class="catalog-desc" data-en="We support you in every phase of creating a physical product: from concept design to 3D modeling, rendering and final presentation." data-it="Ti supportiamo in ogni fase della creazione di un prodotto fisico: dal concept design alla modellazione 3D, al rendering e alla presentazione finale.">We support every phase of creating a physical product.</p>
              <div class="catalog-cards">
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-golden-amber"><span class="catalog-price-badge">from 1,950.00 €</span><div class="catalog-shapes"><div class="shape diamond"></div><div class="shape cross"></div><div class="shape star"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="concept design" data-it="concept design">concept design</h3><p data-en="Ideas and concepts for new products with sketches, 3D models, and renderings to visualize the project." data-it="Idee e concetti per nuovi prodotti con schizzi, modelli 3D e rendering per visualizzare il progetto.">Ideas and concepts with sketches, 3D models, and renderings.</p><a href="#contact" class="catalog-cta" data-en="explore concept design" data-it="esplora concept design">explore concept design</a></div>
                </div>
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-golden-amber"><span class="catalog-price-badge">from 2,950.00 €</span><div class="catalog-shapes"><div class="shape star"></div><div class="shape diamond"></div><div class="shape cross"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="meta-design" data-it="metaprogetto">meta-design</h3><p data-en="A crucial phase defining conceptual foundations and strategies that guide product development." data-it="Una fase cruciale che definisce le basi concettuali e le strategie che guidano lo sviluppo del prodotto.">Conceptual foundations and strategies guiding development.</p><a href="#contact" class="catalog-cta" data-en="explore meta-design" data-it="esplora metaprogetto">explore meta-design</a></div>
                </div>
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-golden-amber"><span class="catalog-price-badge">from 550.00 €</span><div class="catalog-shapes"><div class="shape diamond"></div><div class="shape triangle"></div><div class="shape cross"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="production technology" data-it="scelta della tecnologia di produzione">production technology</h3><p data-en="Choosing the right production technologies to optimize your product and maximize production." data-it="Scegliere le tecnologie produttive giuste per ottimizzare il prodotto e massimizzare la produzione.">Choosing the right production technologies.</p><a href="#contact" class="catalog-cta" data-en="explore production tech" data-it="esplora tecnologia di produzione">explore production tech</a></div>
                </div>
              </div>
            </div>

            <!-- ====== WEB DESIGN ====== -->
            <div id="cat-webdesign" class="catalog-section fade-in">
              <h2 class="catalog-title" data-en="web design" data-it="web design">web design</h2>
              <p class="catalog-desc" data-en="From the union of our passion for design and coding, we create HTML interfaces and complete web systems every day." data-it="Dall'unione della nostra passione per il design e il coding, creiamo ogni giorno interfacce HTML e sistemi web completi.">We create HTML interfaces and complete web systems every day.</p>
              <div class="catalog-cards">
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-golden-amber"><span class="catalog-price-badge">from 1,450.00 €</span><div class="catalog-shapes"><div class="shape circle"></div><div class="shape diamond"></div><div class="shape cross"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="UX design" data-it="UX design">UX design</h3><p data-en="Designing user interactions to be fluid, intuitive, and satisfying with focus on accessibility." data-it="Progettiamo le interazioni utente per essere fluide, intuitive e soddisfacenti con attenzione all'accessibilità.">Designing user interactions to be fluid and intuitive.</p><a href="#contact" class="catalog-cta" data-en="explore UX design" data-it="esplora UX design">explore UX design</a></div>
                </div>
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-golden-amber"><span class="catalog-price-badge">from 1,450.00 €</span><div class="catalog-shapes"><div class="shape square"></div><div class="shape star"></div><div class="shape cross"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="visual design" data-it="visual design">visual design</h3><p data-en="Focus on aesthetic and visual aspects: color choices, typography, images, layouts, and graphic elements." data-it="Aspetti estetici e visivi: scelte di colore, tipografia, immagini, layout e elementi grafici.">Focus on aesthetic and visual aspects of a website.</p><a href="#contact" class="catalog-cta" data-en="explore visual design" data-it="esplora visual design">explore visual design</a></div>
                </div>
                <div class="catalog-card">
                  <div class="catalog-card-thumb grad-golden-amber"><span class="catalog-price-badge">from 1,450.00 €</span><div class="catalog-shapes"><div class="shape triangle"></div><div class="shape diamond"></div><div class="shape cross"></div></div></div>
                  <div class="catalog-card-body"><h3 data-en="UI &amp; front-end development" data-it="UI e sviluppo front-end">UI &amp; front-end development</h3><p data-en="Translating visual design into code with React or Next.js for fast, responsive pages." data-it="Traduciamo il design visivo in codice con React o NextJS per pagine veloci e responsive.">Translating design into code with modern frameworks.</p><a href="#contact" class="catalog-cta" data-en="explore UI &amp; front-end" data-it="esplora UI e sviluppo front-end">explore UI &amp; front-end</a></div>
                </div>
              </div>
            </div>

          </div> <!-- /catalog-content -->
        </div> <!-- /catalog-layout -->
      </div>
    </section>
  </div> <!-- /catalog -->

  <!-- Portfolio -->
  <section id="portfolio">
    <div class="container">
      <div class="section-header fade-in">
        <span class="section-label">Our Portfolio</span>
        <h2>Projects We're Proud Of</h2>
        <p>A showcase of our finest work across different industries and technologies</p>
      </div>

      <div class="portfolio-filters fade-in">
        <button class="filter-btn active" onclick="filterPortfolio('all')">All</button>
        <button class="filter-btn" onclick="filterPortfolio('web')">Web</button>
        <button class="filter-btn" onclick="filterPortfolio('mobile')">Mobile</button>
        <button class="filter-btn" onclick="filterPortfolio('ai')">AI/ML</button>
        <button class="filter-btn" onclick="filterPortfolio('cloud')">Cloud</button>
      </div>

      <div class="portfolio-grid">

        <!-- 1 -->
        <div class="portfolio-card fade-in" data-category="web">
          <div class="portfolio-thumb">
            <div class="thumb-bg p-grad-1"></div>
            <span class="thumb-icon">🛒</span>

          </div>
          <div class="portfolio-info">
            <div class="tags"><span class="tag">E-Commerce</span><span class="tag">React</span></div>
            <h3>ShopVerse — E-Commerce Platform</h3>
            <p>A full-stack e-commerce solution with real-time inventory, AI-powered recommendations, and seamless
              checkout.</p>
          </div>
        </div>

        <!-- 2 -->
        <div class="portfolio-card fade-in" data-category="mobile">
          <div class="portfolio-thumb">
            <div class="thumb-bg p-grad-2"></div>
            <span class="thumb-icon">💊</span>

          </div>
          <div class="portfolio-info">
            <div class="tags"><span class="tag">Healthcare</span><span class="tag">Flutter</span></div>
            <h3>MediTrack — Health Management App</h3>
            <p>Mobile app for patients to manage appointments, prescriptions, and communicate with doctors in real-time.
            </p>
          </div>
        </div>

        <!-- 3 -->
        <div class="portfolio-card fade-in" data-category="web">
          <div class="portfolio-thumb">
            <div class="thumb-bg p-grad-3"></div>
            <span class="thumb-icon">🏠</span>

          </div>
          <div class="portfolio-info">
            <div class="tags"><span class="tag">Real Estate</span><span class="tag">Next.js</span></div>
            <h3>PropConnect — Property Marketplace</h3>
            <p>Property listing platform with virtual tours, AI valuation, map search, and mortgage calculator
              integration.</p>
          </div>
        </div>

        <!-- 4 -->
        <div class="portfolio-card fade-in" data-category="ai">
          <div class="portfolio-thumb">
            <div class="thumb-bg p-grad-4"></div>
            <span class="thumb-icon">🧠</span>

          </div>
          <div class="portfolio-info">
            <div class="tags"><span class="tag">AI/ML</span><span class="tag">Python</span></div>
            <h3>InsightAI — Analytics Dashboard</h3>
            <p>AI-powered business intelligence platform with predictive analytics, data visualization, and automated
              reporting.</p>
          </div>
        </div>

        <!-- 5 -->
        <div class="portfolio-card fade-in" data-category="mobile">
          <div class="portfolio-thumb">
            <div class="thumb-bg p-grad-5"></div>
            <span class="thumb-icon">🍔</span>

          </div>
          <div class="portfolio-info">
            <div class="tags"><span class="tag">Food Tech</span><span class="tag">React Native</span></div>
            <h3>BiteNow — Food Delivery App</h3>
            <p>Complete food delivery ecosystem with real-time tracking, restaurant dashboard, and driver management
              system.</p>
          </div>
        </div>

        <!-- 6 -->
        <div class="portfolio-card fade-in" data-category="cloud">
          <div class="portfolio-thumb">
            <div class="thumb-bg p-grad-6"></div>
            <span class="thumb-icon">💰</span>

          </div>
          <div class="portfolio-info">
            <div class="tags"><span class="tag">FinTech</span><span class="tag">Node.js</span></div>
            <h3>PayFlow — Digital Banking</h3>
            <p>Secure digital banking platform with instant transfers, budget tracking, crypto wallet, and financial
              insights.</p>
          </div>
        </div>

        <!-- 7 -->
        <div class="portfolio-card fade-in" data-category="web">
          <div class="portfolio-thumb">
            <div class="thumb-bg p-grad-7"></div>
            <span class="thumb-icon">📚</span>

          </div>
          <div class="portfolio-info">
            <div class="tags"><span class="tag">EdTech</span><span class="tag">Vue.js</span></div>
            <h3>LearnHub — LMS Platform</h3>
            <p>Interactive learning management system with live classes, quizzes, progress tracking, and certificate
              generation.</p>
          </div>
        </div>

        <!-- 8 -->
        <div class="portfolio-card fade-in" data-category="ai">
          <div class="portfolio-thumb">
            <div class="thumb-bg p-grad-8"></div>
            <span class="thumb-icon">🤖</span>

          </div>
          <div class="portfolio-info">
            <div class="tags"><span class="tag">AI Chatbot</span><span class="tag">GPT-4</span></div>
            <h3>ChatGenius — AI Assistant</h3>
            <p>Custom-trained AI chatbot for customer support with multi-language support, sentiment analysis, and CRM
              integration.</p>
          </div>
        </div>

        <!-- 9 -->
        <div class="portfolio-card fade-in" data-category="cloud">
          <div class="portfolio-thumb">
            <div class="thumb-bg p-grad-9"></div>
            <span class="thumb-icon">📊</span>

          </div>
          <div class="portfolio-info">
            <div class="tags"><span class="tag">SaaS</span><span class="tag">AWS</span></div>
            <h3>TaskForge — Project Management</h3>
            <p>Enterprise project management tool with Kanban boards, Gantt charts, team collaboration, and time
              tracking.</p>
          </div>
        </div>

        <!-- 10 -->
        <div class="portfolio-card fade-in" data-category="cloud">
          <div class="portfolio-thumb">
            <div class="thumb-bg p-grad-10"></div>
            <span class="thumb-icon">🏡</span>

          </div>
          <div class="portfolio-info">
            <div class="tags"><span class="tag">IoT</span><span class="tag">Python</span></div>
            <h3>SmartNest — IoT Home System</h3>
            <p>Smart home management platform with device control, energy monitoring, automation rules, and voice
              assistant integration.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Tech Stack -->
  <section id="tech">
    <div class="container">
      <div class="section-header fade-in">
        <span class="section-label">Tech Stack</span>
        <h2>Technologies We Master</h2>
        <p>We use industry-leading tools and frameworks to build world-class products</p>
      </div>
      <div class="tech-grid fade-in">
        <div class="tech-item"><span class="tech-icon">⚛️</span><span>React</span></div>
        <div class="tech-item"><span class="tech-icon">🔺</span><span>Next.js</span></div>
        <div class="tech-item"><span class="tech-icon">💚</span><span>Vue.js</span></div>
        <div class="tech-item"><span class="tech-icon">🟢</span><span>Node.js</span></div>
        <div class="tech-item"><span class="tech-icon">🐍</span><span>Python</span></div>
        <div class="tech-item"><span class="tech-icon">🎯</span><span>Flutter</span></div>
        <div class="tech-item"><span class="tech-icon">☁️</span><span>AWS</span></div>
        <div class="tech-item"><span class="tech-icon">🐳</span><span>Docker</span></div>
        <div class="tech-item"><span class="tech-icon">🗄️</span><span>PostgreSQL</span></div>
        <div class="tech-item"><span class="tech-icon">🔥</span><span>Firebase</span></div>
        <div class="tech-item"><span class="tech-icon">📘</span><span>TypeScript</span></div>
        <div class="tech-item"><span class="tech-icon">🧪</span><span>GraphQL</span></div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section id="testimonials">
    <div class="container">
      <div class="section-header fade-in">
        <span class="section-label">Testimonials</span>
        <h2>What Clients Say</h2>
        <p>Don't just take our word for it — hear from our partners</p>
      </div>
      <div class="testimonials-grid">
        <div class="testimonial-card fade-in">
          <div class="stars">★★★★★</div>
          <blockquote>"Seeda transformed our vision into a stunning product. Their attention to detail and technical
            expertise is unmatched. Truly world-class team."</blockquote>
          <div class="testimonial-author">
            <div class="author-avatar" style="background: var(--gradient-1);">JM</div>
            <div class="author-info">
              <div class="name">James Mitchell</div>
              <div class="role">CEO, ShopVerse</div>
            </div>
          </div>
        </div>
        <div class="testimonial-card fade-in">
          <div class="stars">★★★★★</div>
          <blockquote>"Working with Seeda was the best decision we made. They delivered our app 2 weeks ahead of
            schedule with impeccable quality."</blockquote>
          <div class="testimonial-author">
            <div class="author-avatar" style="background: var(--gradient-2);">SK</div>
            <div class="author-info">
              <div class="name">Sarah Kim</div>
              <div class="role">Founder, MediTrack</div>
            </div>
          </div>
        </div>
        <div class="testimonial-card fade-in">
          <div class="stars">★★★★★</div>
          <blockquote>"Exceptional developers and designers. Seeda understood our complex requirements and delivered a
            scalable enterprise solution."</blockquote>
          <div class="testimonial-author">
            <div class="author-avatar" style="background: var(--gradient-3);">DP</div>
            <div class="author-info">
              <div class="name">David Park</div>
              <div class="role">CTO, TaskForge</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing -->
  <section id="pricing">
    <div class="container">
      <div class="section-header fade-in">
        <span class="section-label">Pricing</span>
        <h2>Transparent Pricing, No Surprises</h2>
        <p>Clear packages for every stage of your business — from launch to scale</p>
      </div>

      <!-- Pricing Category Tabs -->
      <div class="pricing-tabs fade-in">
        <button class="pricing-tab active" onclick="switchPricingTab('web')">
          <span class="tab-icon">🌐</span> Web & App Builds
        </button>
        <button class="pricing-tab" onclick="switchPricingTab('maintenance')">
          <span class="tab-icon">🛡️</span> Maintenance & Hosting
        </button>
        <button class="pricing-tab" onclick="switchPricingTab('data')">
          <span class="tab-icon">🤖</span> Data & ML
        </button>
      </div>

      <!-- ===== Web & App Builds ===== -->
      <div class="pricing-category active" id="pricing-web">
        <div class="pricing-grid">

          <div class="pricing-card fade-in">
            <div class="pricing-card-header">
              <div class="pricing-badge">Starter</div>
              <h3>Launch Website</h3>
              <p class="pricing-tech">WordPress</p>
            </div>
            <div class="pricing-body">
              <div class="pricing-amount">
                <span class="currency">€</span>
                <span class="price">1,200</span>
                <span class="price-range">– 1,500</span>
              </div>
              <span class="pricing-vat">+ VAT · Fixed price</span>
              <p class="pricing-description">Need a clean, fast website to finally look legit online? We'll build a 5–6
                page WordPress site with a modern custom theme, contact form, and basic on‑page SEO.</p>
              <ul class="pricing-features">
                <li><span class="check">✓</span> 5–6 custom pages</li>
                <li><span class="check">✓</span> Modern responsive theme</li>
                <li><span class="check">✓</span> Contact form setup</li>
                <li><span class="check">✓</span> Basic on‑page SEO</li>
                <li><span class="check">✓</span> Mobile‑optimized</li>
              </ul>
              <a href="#contact" class="pricing-cta">Get Started</a>
            </div>
          </div>

          <div class="pricing-card featured fade-in">
            <div class="featured-ribbon">Popular</div>
            <div class="pricing-card-header">
              <div class="pricing-badge">Growth</div>
              <h3>Growth Website</h3>
              <p class="pricing-tech">WordPress / Laravel</p>
            </div>
            <div class="pricing-body">
              <div class="pricing-amount">
                <span class="currency">€</span>
                <span class="price">2,000</span>
                <span class="price-range">– 2,500</span>
              </div>
              <span class="pricing-vat">+ VAT · Fixed price</span>
              <p class="pricing-description">Ready for something a bit more serious? Up to 10 pages on WordPress or
                Laravel, blog setup, extra forms, and simple multi‑language support so your site can grow with your
                business.</p>
              <ul class="pricing-features">
                <li><span class="check">✓</span> Up to 10 pages</li>
                <li><span class="check">✓</span> Blog setup & CMS</li>
                <li><span class="check">✓</span> Advanced forms</li>
                <li><span class="check">✓</span> Multi‑language support</li>
                <li><span class="check">✓</span> Performance optimization</li>
                <li><span class="check">✓</span> Analytics integration</li>
              </ul>
              <a href="#contact" class="pricing-cta featured-cta">Get Started</a>
            </div>
          </div>

          <div class="pricing-card fade-in">
            <div class="pricing-card-header">
              <div class="pricing-badge">Custom</div>
              <h3>Custom Web App</h3>
              <p class="pricing-tech">Laravel</p>
            </div>
            <div class="pricing-body">
              <div class="pricing-amount">
                <span class="currency">€</span>
                <span class="price">3,000</span>
                <span class="price-range">– 6,000</span>
              </div>
              <span class="pricing-vat">+ VAT · Based on complexity</span>
              <p class="pricing-description">Have an idea that doesn't fit into a template? We'll design and build a
                custom Laravel web app with a dedicated backend, API integrations, and an admin panel built around your
                workflow.</p>
              <ul class="pricing-features">
                <li><span class="check">✓</span> Custom Laravel application</li>
                <li><span class="check">✓</span> Dedicated admin panel</li>
                <li><span class="check">✓</span> API integrations</li>
                <li><span class="check">✓</span> Workflow automation</li>
                <li><span class="check">✓</span> Full documentation</li>
                <li><span class="check">✓</span> Deployment & handover</li>
              </ul>
              <a href="#contact" class="pricing-cta">Let's Talk</a>
            </div>
          </div>

        </div>
      </div>

      <!-- ===== Maintenance & Hosting ===== -->
      <div class="pricing-category" id="pricing-maintenance">
        <div class="pricing-grid">

          <div class="pricing-card fade-in">
            <div class="pricing-card-header">
              <div class="pricing-badge">Essential</div>
              <h3>Keep‑It‑Simple Plan</h3>
              <p class="pricing-tech">Hosting & Updates</p>
            </div>
            <div class="pricing-body">
              <div class="pricing-amount monthly">
                <span class="currency">€</span>
                <span class="price">30</span>
                <span class="price-range">– 40</span>
                <span class="price-period">/month</span>
              </div>
              <span class="pricing-vat">€360–480/year + VAT</span>
              <p class="pricing-description">We host your site, keep the domain and SSL active, run backups, and handle
                monthly WordPress updates so you don't have to think about it.</p>
              <ul class="pricing-features">
                <li><span class="check">✓</span> Managed hosting</li>
                <li><span class="check">✓</span> Domain & SSL management</li>
                <li><span class="check">✓</span> Monthly backups</li>
                <li><span class="check">✓</span> WordPress core updates</li>
                <li><span class="check">✓</span> Plugin updates</li>
              </ul>
              <a href="#contact" class="pricing-cta">Get Started</a>
            </div>
          </div>

          <div class="pricing-card featured fade-in">
            <div class="featured-ribbon">Recommended</div>
            <div class="pricing-card-header">
              <div class="pricing-badge">Professional</div>
              <h3>Care & Fix Plan</h3>
              <p class="pricing-tech">Hosting + Support</p>
            </div>
            <div class="pricing-body">
              <div class="pricing-amount monthly">
                <span class="currency">€</span>
                <span class="price">60</span>
                <span class="price-range">– 80</span>
                <span class="price-period">/month</span>
              </div>
              <span class="pricing-vat">€720–960/year + VAT</span>
              <p class="pricing-description">On top of hosting and updates, we monitor security, fix common issues, and
                handle small content tweaks every month within an agreed time budget.</p>
              <ul class="pricing-features">
                <li><span class="check">✓</span> Everything in Keep‑It‑Simple</li>
                <li><span class="check">✓</span> Security monitoring</li>
                <li><span class="check">✓</span> Bug fixes & troubleshooting</li>
                <li><span class="check">✓</span> Monthly content tweaks</li>
                <li><span class="check">✓</span> Priority email support</li>
              </ul>
              <a href="#contact" class="pricing-cta featured-cta">Get Started</a>
            </div>
          </div>

          <div class="pricing-card fade-in">
            <div class="pricing-card-header">
              <div class="pricing-badge">Enterprise</div>
              <h3>All‑In Care Plan</h3>
              <p class="pricing-tech">Full Managed Service</p>
            </div>
            <div class="pricing-body">
              <div class="pricing-amount monthly">
                <span class="currency">€</span>
                <span class="price">120</span>
                <span class="price-range">– 150</span>
                <span class="price-period">/month</span>
              </div>
              <span class="pricing-vat">€1,440–1,800/year + VAT</span>
              <p class="pricing-description">For businesses that don't want to touch anything tech. Performance tuning,
                monthly reports, more time for updates and consulting, plus everything in the other plans.</p>
              <ul class="pricing-features">
                <li><span class="check">✓</span> Everything in Care & Fix</li>
                <li><span class="check">✓</span> Performance optimization</li>
                <li><span class="check">✓</span> Monthly analytics reports</li>
                <li><span class="check">✓</span> Extended update hours</li>
                <li><span class="check">✓</span> Strategy consulting</li>
                <li><span class="check">✓</span> Dedicated account manager</li>
              </ul>
              <a href="#contact" class="pricing-cta">Contact Us</a>
            </div>
          </div>

        </div>
      </div>

      <!-- ===== Data & ML ===== -->
      <div class="pricing-category" id="pricing-data">
        <div class="pricing-grid">

          <div class="pricing-card fade-in">
            <div class="pricing-card-header">
              <div class="pricing-badge">Flexible</div>
              <h3>On‑Demand Data Help</h3>
              <p class="pricing-tech">Consulting & Analysis</p>
            </div>
            <div class="pricing-body">
              <div class="pricing-amount">
                <span class="currency">€</span>
                <span class="price">50</span>
                <span class="price-range">– 70</span>
                <span class="price-period">/hour</span>
              </div>
              <span class="pricing-vat">+ VAT · Min 20–30 hours</span>
              <p class="pricing-description">Need a data person in your corner for a while? Data analysis, ML
                experiments, or consulting billed hourly with a minimum project commitment.</p>
              <ul class="pricing-features">
                <li><span class="check">✓</span> Data analysis & exploration</li>
                <li><span class="check">✓</span> ML experiments</li>
                <li><span class="check">✓</span> Technical consulting</li>
                <li><span class="check">✓</span> Flexible scheduling</li>
                <li><span class="check">✓</span> Progress reports</li>
              </ul>
              <a href="#contact" class="pricing-cta">Book Hours</a>
            </div>
          </div>

          <div class="pricing-card featured fade-in">
            <div class="featured-ribbon">Popular</div>
            <div class="pricing-card-header">
              <div class="pricing-badge">Project</div>
              <h3>Data Deep‑Dive & Dashboard</h3>
              <p class="pricing-tech">Analysis + Visualization</p>
            </div>
            <div class="pricing-body">
              <div class="pricing-amount">
                <span class="currency">€</span>
                <span class="price">2,500</span>
                <span class="price-range">– 3,500</span>
              </div>
              <span class="pricing-vat">+ VAT · ~40 hours</span>
              <p class="pricing-description">We clean your data, explore what's really going on, and deliver a clear
                report plus a simple dashboard your team can actually use. Two milestones: first insights, then final
                delivery.</p>
              <ul class="pricing-features">
                <li><span class="check">✓</span> Data cleaning & preparation</li>
                <li><span class="check">✓</span> Exploratory analysis</li>
                <li><span class="check">✓</span> Interactive dashboard</li>
                <li><span class="check">✓</span> Executive summary report</li>
                <li><span class="check">✓</span> Two milestone deliveries</li>
              </ul>
              <a href="#contact" class="pricing-cta featured-cta">Get Started</a>
            </div>
          </div>

          <div class="pricing-card fade-in">
            <div class="pricing-card-header">
              <div class="pricing-badge">Advanced</div>
              <h3>ML Project Package</h3>
              <p class="pricing-tech">Full ML Pipeline</p>
            </div>
            <div class="pricing-body">
              <div class="pricing-amount">
                <span class="currency">€</span>
                <span class="price">3,000</span>
                <span class="price-range">– 5,000</span>
              </div>
              <span class="pricing-vat">+ VAT · 50–80 hours</span>
              <p class="pricing-description">Want a forecasting or classification model that does something useful, not
                just look cool in a slide? We handle analysis & design, model development, evaluation, documentation,
                and handover.</p>
              <ul class="pricing-features">
                <li><span class="check">✓</span> Problem analysis & design</li>
                <li><span class="check">✓</span> Model development</li>
                <li><span class="check">✓</span> Evaluation & testing</li>
                <li><span class="check">✓</span> Full documentation</li>
                <li><span class="check">✓</span> Team training & handover</li>
                <li><span class="check">✓</span> Production deployment guide</li>
              </ul>
              <a href="#contact" class="pricing-cta">Let's Talk</a>
            </div>
          </div>

        </div>
      </div>

    </div>
  </section>

  <!-- Contact -->
  <section id="contact">
    <div class="container">
      <div class="section-header fade-in">
        <span class="section-label">Get In Touch</span>
        <h2>Start Your Project</h2>
        <p>Ready to bring your idea to life? Let's talk about your next big thing</p>
      </div>
      <div class="contact-grid">
        <div class="contact-info fade-in">
          <h3>Let's Build Something Amazing Together</h3>
          <p>Whether you have a fully-fledged idea or just a spark, we're here to help you every step of the way.</p>
          <div class="contact-details">
            <div class="contact-item">
              <div class="ci-icon">📧</div>
              <div class="ci-text">
                <div class="label">Email</div>
                <div class="value">hello@seeda.uk</div>
              </div>
            </div>
            <div class="contact-item">
              <div class="ci-icon">📞</div>
              <div class="ci-text">
                <div class="label">Phone</div>
                <div class="value">+39 350 528 1393</div>
              </div>
            </div>
            <div class="contact-item">
              <div class="ci-icon">📍</div>
              <div class="ci-text">
                <div class="label">London Office</div>
                <div class="value">Castle House, 37-45 Paul St, London EC2A 4LS, UK</div>
              </div>
            </div>
            <div class="contact-item">
              <div class="ci-icon">📍</div>
              <div class="ci-text">
                <div class="label">Rome Office</div>
                <div class="value">Via S. Biagio Platani, 278, 00133 Roma RM, Italy</div>
              </div>
            </div>
            <div class="contact-item">
              <div class="ci-icon">🕐</div>
              <div class="ci-text">
                <div class="label">Working Hours</div>
                <div class="value">Mon - Fri, 9:00 - 18:00 GMT</div>
              </div>
            </div>
          </div>
        </div>
        <div class="faq-list fade-in">
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <span>How long does a typical project take?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <div class="faq-answer-inner">
                <p>Timelines vary based on scope. A simple website takes 2–4 weeks, while complex web apps or mobile
                  applications can take 2–4 months. We always provide a detailed timeline before starting.</p>
              </div>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <span>What technologies do you specialize in?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <div class="faq-answer-inner">
                <p>We work with React, Next.js, Vue.js, Flutter, React Native, Node.js, Python, AWS, Google Cloud,
                  Docker, and more. We choose the best stack based on your project's needs.</p>
              </div>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <span>Do you offer ongoing support after launch?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <div class="faq-answer-inner">
                <p>Absolutely! We offer flexible maintenance plans including bug fixes, feature updates, performance
                  monitoring, and 24/7 technical support to keep your product running smoothly.</p>
              </div>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <span>How much does a project cost?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <div class="faq-answer-inner">
                <p>Every project is unique. We provide free consultations and detailed quotes based on your
                  requirements. Our pricing is transparent with no hidden fees — reach out to get a custom estimate.</p>
              </div>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <span>Can you work with our existing team?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <div class="faq-answer-inner">
                <p>Yes! We frequently integrate with in-house teams. Whether you need full project delivery or
                  additional developers to augment your team, we adapt to your workflow seamlessly.</p>
              </div>
            </div>
          </div>
          <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
              <span>What is your development process?</span>
              <span class="faq-icon">+</span>
            </button>
            <div class="faq-answer">
              <div class="faq-answer-inner">
                <p>We follow an agile methodology: Discovery → Design → Development → Testing → Launch → Support. You'll
                  have full visibility with regular updates, demos, and direct communication throughout.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="#" class="logo">Seeda<span>.</span></a>
          <p>Building the future of software, one pixel and one line of code at a time.</p>
          <div class="social-links">
            <a href="#" aria-label="Twitter">𝕏</a>
            <a href="#" aria-label="LinkedIn">in</a>
            <a href="#" aria-label="GitHub">⌨</a>
            <a href="#" aria-label="Dribbble">◉</a>
          </div>
        </div>
        <div class="footer-col">
          <h4>Company</h4>
          <a href="#about">About Us</a>
          <a href="#services">Services</a>
          <a href="#portfolio">Portfolio</a>
          <a href="#">Careers</a>
        </div>
        <div class="footer-col">
          <h4>Services</h4>
          <a href="#">Web Development</a>
          <a href="#">Mobile Apps</a>
          <a href="#">UI/UX Design</a>
          <a href="#">Cloud Solutions</a>
        </div>
        <div class="footer-col">
          <h4>Resources</h4>
          <a href="#">Blog</a>
          <a href="#">Case Studies</a>
          <a href="#">Documentation</a>
          <a href="#">Privacy Policy</a>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2026 Seeda. All rights reserved.</p>
        <p>Designed & Built with ❤️ by Seeda</p>
      </div>
    </div>
  </footer>

  <script>
    // ===== LANGUAGE SWITCHER =====
    let currentLang = 'en';

    function toggleLanguage() {
      currentLang = currentLang === 'en' ? 'it' : 'en';
      applyLanguage(currentLang);
    }

    function applyLanguage(lang) {
      // Update flag and text
      document.getElementById('langFlag').textContent = lang === 'en' ? '🇬🇧' : '🇮🇹';
      document.getElementById('langText').textContent = lang.toUpperCase();

      // Update all elements with data-en / data-it attributes
      document.querySelectorAll('[data-en][data-it]').forEach(el => {
        el.textContent = el.getAttribute('data-' + lang);
      });
    }

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
      const navbar = document.getElementById('navbar');
      navbar.classList.toggle('scrolled', window.scrollY > 50);
    });

    // Mobile menu toggle
    function toggleMenu() {
      document.getElementById('navLinks').classList.toggle('open');
    }

    // Close mobile menu on link click
    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', () => {
        document.getElementById('navLinks').classList.remove('open');
      });
    });

    // Scroll reveal
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    // Portfolio filter
    function filterPortfolio(category) {
      document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
      event.target.classList.add('active');

      document.querySelectorAll('.portfolio-card').forEach(card => {
        if (category === 'all' || card.dataset.category === category) {
          card.style.display = 'block';
          setTimeout(() => { card.style.opacity = '1'; card.style.transform = 'translateY(0)'; }, 50);
        } else {
          card.style.opacity = '0';
          card.style.transform = 'translateY(20px)';
          setTimeout(() => { card.style.display = 'none'; }, 300);
        }
      });
    }

    // FAQ accordion toggle with smooth height animation
    function toggleFaq(btn) {
      const item = btn.parentElement;
      const answer = item.querySelector('.faq-answer');
      const isActive = item.classList.contains('active');

      // Close all items with animation
      document.querySelectorAll('.faq-item.active').forEach(el => {
        if (el !== item) {
          const elAnswer = el.querySelector('.faq-answer');
          elAnswer.style.height = elAnswer.scrollHeight + 'px';
          requestAnimationFrame(() => {
            elAnswer.style.height = '0';
          });
          el.classList.remove('active');
        }
      });

      // Toggle clicked item
      if (!isActive) {
        item.classList.add('active');
        answer.style.height = answer.scrollHeight + 'px';
        answer.addEventListener('transitionend', function handler() {
          answer.style.height = 'auto';
          answer.removeEventListener('transitionend', handler);
        });
      } else {
        answer.style.height = answer.scrollHeight + 'px';
        requestAnimationFrame(() => {
          answer.style.height = '0';
        });
        item.classList.remove('active');
      }
    }

    // Pricing tab switcher
    function switchPricingTab(category) {
      // Update active tab button
      document.querySelectorAll('.pricing-tab').forEach(tab => tab.classList.remove('active'));
      event.currentTarget.classList.add('active');

      // Switch category panels with animation
      document.querySelectorAll('.pricing-category').forEach(cat => {
        if (cat.id === 'pricing-' + category) {
          cat.classList.add('active');
          // Re-trigger fade-in for cards
          cat.querySelectorAll('.pricing-card').forEach((card, i) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
              card.style.opacity = '1';
              card.style.transform = 'translateY(0)';
            }, 100 + i * 120);
          });
        } else {
          cat.classList.remove('active');
        }
      });
    }

    // Counter animation
    function animateCounters() {
      document.querySelectorAll('.stat-item h3').forEach(counter => {
        const target = counter.textContent;
        const numMatch = target.match(/(\d+)/);
        if (!numMatch) return;
        const num = parseInt(numMatch[1]);
        const suffix = target.replace(numMatch[1], '');
        let current = 0;
        const increment = Math.ceil(num / 60);
        const timer = setInterval(() => {
          current += increment;
          if (current >= num) {
            current = num;
            clearInterval(timer);
          }
          counter.textContent = current + suffix;
        }, 25);
      });
    }

    const statsObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          animateCounters();
          statsObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });

    const statsBar = document.querySelector('.stats-bar');
    if (statsBar) statsObserver.observe(statsBar);

    // Sidebar link scroll highlighting
    const catalogSections = document.querySelectorAll('.catalog-section');
    const sidebarLinks = document.querySelectorAll('.sidebar-link');

    const sidebarObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          sidebarLinks.forEach(link => link.classList.remove('active'));
          const activeLink = document.querySelector('.sidebar-link[href="#' + entry.target.id + '"]');
          if (activeLink) activeLink.classList.add('active');
        }
      });
    }, { threshold: 0.3, rootMargin: '-100px 0px -40% 0px' });

    catalogSections.forEach(sec => sidebarObserver.observe(sec));
  </script>

</body>

</html>