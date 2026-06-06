<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        @php
            $title = 'Software, AI, Data & Automation';
            $description = 'Custom software, apps and websites for growing businesses. Data, AI and automation built around how you work.';
        @endphp
        @include('partials.seo')
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&family=JetBrains+Mono:wght@400;500&display=swap"
            rel="stylesheet"
        />
        <style>
            :root {
                --bg: #050508;
                --bg-elevated: #0c0c12;
                --surface: rgba(14, 14, 22, 0.85);
                --text: #f2f2f7;
                --muted: #8b8b9e;
                --line: rgba(255, 255, 255, 0.07);
                --accent: #6d8fff;
                --accent-2: #34d399;
                --accent-3: #c084fc;
                --glow: rgba(109, 143, 255, 0.4);
                --radius: 16px;
                --max: 1200px;
            }

            * { box-sizing: border-box; }
            html { scroll-behavior: smooth; }

            body {
                margin: 0;
                font-family: "DM Sans", ui-sans-serif, system-ui, sans-serif;
                color: var(--text);
                background: var(--bg);
                line-height: 1.6;
            }

            /* ambient */
            .ambient {
                position: fixed;
                inset: 0;
                pointer-events: none;
                z-index: 0;
                overflow: hidden;
            }

            .ambient-orb {
                position: absolute;
                border-radius: 50%;
                filter: blur(80px);
                animation: orb-float 20s ease-in-out infinite alternate;
            }

            .ambient-orb.a { width: 600px; height: 600px; top: -15%; left: 20%; background: rgba(109, 143, 255, 0.18); }
            .ambient-orb.b { width: 500px; height: 500px; top: 30%; right: -10%; background: rgba(52, 211, 153, 0.1); animation-delay: -8s; }
            .ambient-orb.c { width: 400px; height: 400px; bottom: 10%; left: -5%; background: rgba(192, 132, 252, 0.08); animation-delay: -14s; }

            .ambient-grid {
                position: absolute;
                inset: 0;
                background-image:
                    linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
                background-size: 64px 64px;
                mask-image: radial-gradient(ellipse 70% 60% at 50% 30%, black, transparent);
            }

            @keyframes orb-float {
                0% { transform: translate(0, 0) scale(1); }
                100% { transform: translate(30px, -20px) scale(1.08); }
            }

            a { color: inherit; text-decoration: none; }

            .container {
                width: min(var(--max), calc(100% - 2rem));
                margin-inline: auto;
            }

            /* header */
            .site-header {
                position: fixed;
                inset: 0 0 auto;
                z-index: 100;
                backdrop-filter: blur(24px) saturate(1.5);
                background: rgba(5, 5, 8, 0.7);
                border-bottom: 1px solid var(--line);
            }

            .site-header-inner {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                padding: 0.85rem 0;
            }

            .brand {
                display: inline-flex;
                align-items: baseline;
                font-size: 1.3rem;
                letter-spacing: 0.03em;
                text-transform: lowercase;
                font-weight: 700;
            }

            .brand-word {
                background: linear-gradient(135deg, #fff 20%, #93a8ff);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            .brand-one {
                font-weight: 800;
                background: linear-gradient(180deg, #d1d5db, #6b7280);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            .nav {
                display: flex;
                gap: 1.75rem;
                font-size: 0.9rem;
                color: var(--muted);
            }

            .nav a:hover { color: var(--text); }

            .button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.75rem 1.35rem;
                border-radius: 10px;
                font-weight: 600;
                font-size: 0.9rem;
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .button:hover { transform: translateY(-2px); }

            .button-primary {
                background: linear-gradient(135deg, #5b7cfa, #4f6ef7);
                color: #fff;
                box-shadow: 0 0 30px var(--glow), 0 6px 20px rgba(0,0,0,0.5);
            }

            .button-ghost {
                background: rgba(255,255,255,0.04);
                border: 1px solid var(--line);
                color: var(--text);
            }

            .button-ghost:hover {
                background: rgba(255,255,255,0.08);
                border-color: rgba(255,255,255,0.14);
            }

            /* hero */
            .hero {
                position: relative;
                z-index: 1;
                min-height: 100vh;
                display: flex;
                align-items: center;
                padding: 6.5rem 0 4rem;
            }

            .hero-grid {
                display: grid;
                grid-template-columns: 1fr 1.05fr;
                gap: 3rem;
                align-items: center;
            }

            .hero-copy {
                position: relative;
            }

            .hero-copy::before {
                content: "";
                position: absolute;
                top: -40%;
                left: -20%;
                width: 400px;
                height: 400px;
                background: radial-gradient(circle, rgba(109,143,255,0.12), transparent 70%);
                pointer-events: none;
            }

            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 1.25rem;
                padding: 0.4rem 0.85rem 0.4rem 0.5rem;
                border-radius: 999px;
                background: rgba(109,143,255,0.1);
                border: 1px solid rgba(109,143,255,0.22);
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--accent);
            }

            .eyebrow-dot {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: var(--accent-2);
                box-shadow: 0 0 10px var(--accent-2);
                animation: blink 2s ease-in-out infinite;
            }

            @keyframes blink {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.4; }
            }

            .hero h1 {
                margin: 0 0 1.25rem;
                font-size: clamp(2.4rem, 5.5vw, 3.6rem);
                line-height: 1.08;
                letter-spacing: -0.04em;
                font-weight: 700;
            }

            .hero h1 .grad {
                background: linear-gradient(135deg, #fff 0%, var(--accent) 45%, var(--accent-2) 100%);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }

            .hero-lead {
                margin: 0 0 1.75rem;
                font-size: 1.05rem;
                color: var(--muted);
                max-width: 48ch;
            }

            .hero-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 0.75rem;
                margin-bottom: 2rem;
            }

            .hero-pills {
                display: flex;
                flex-wrap: wrap;
                gap: 0.6rem;
            }

            .pill {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                padding: 0.5rem 0.85rem;
                border-radius: 10px;
                background: rgba(255,255,255,0.04);
                border: 1px solid var(--line);
                font-size: 0.8rem;
                color: var(--muted);
            }

            .pill strong {
                color: var(--text);
                font-weight: 600;
            }

            .pill-dot {
                width: 6px;
                height: 6px;
                border-radius: 50%;
            }

            .pill-dot.blue { background: var(--accent); }
            .pill-dot.green { background: var(--accent-2); }
            .pill-dot.purple { background: var(--accent-3); }

            /* code editor */
            .editor-wrap {
                position: relative;
            }

            .editor-wrap::before {
                content: "";
                position: absolute;
                inset: -20%;
                background: radial-gradient(circle, rgba(109,143,255,0.15), transparent 65%);
                pointer-events: none;
            }

            .editor {
                position: relative;
                border-radius: 14px;
                background: rgba(10, 10, 16, 0.92);
                border: 1px solid rgba(255,255,255,0.1);
                box-shadow:
                    0 0 0 1px rgba(109,143,255,0.08),
                    0 30px 80px rgba(0,0,0,0.6),
                    0 0 60px rgba(109,143,255,0.08);
                overflow: hidden;
                transform: perspective(1200px) rotateY(-4deg) rotateX(2deg);
                transition: transform 0.4s ease;
            }

            .editor:hover {
                transform: perspective(1200px) rotateY(-2deg) rotateX(1deg);
            }

            .editor-bar {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1rem;
                background: rgba(255,255,255,0.03);
                border-bottom: 1px solid var(--line);
            }

            .editor-dots {
                display: flex;
                gap: 6px;
            }

            .editor-dots span {
                width: 11px;
                height: 11px;
                border-radius: 50%;
            }

            .editor-dots span:nth-child(1) { background: #ff5f57; }
            .editor-dots span:nth-child(2) { background: #febc2e; }
            .editor-dots span:nth-child(3) { background: #28c840; }

            .editor-tab {
                margin-left: 0.5rem;
                padding: 0.25rem 0.75rem;
                border-radius: 6px;
                background: rgba(109,143,255,0.12);
                font-family: "JetBrains Mono", monospace;
                font-size: 0.7rem;
                color: var(--accent);
            }

            .editor-body {
                display: grid;
                grid-template-columns: 2.5rem 1fr;
                max-height: 380px;
                overflow: hidden;
            }

            .line-nums {
                padding: 1.25rem 0;
                text-align: right;
                font-family: "JetBrains Mono", monospace;
                font-size: 0.72rem;
                line-height: 1.8;
                color: rgba(139,139,158,0.35);
                user-select: none;
                border-right: 1px solid var(--line);
            }

            .line-nums span { display: block; padding-right: 0.75rem; }

            .code-pane {
                padding: 1.25rem 1rem;
                overflow: hidden;
                position: relative;
            }

            .code-pane pre {
                margin: 0;
                font-family: "JetBrains Mono", monospace;
                font-size: 0.72rem;
                line-height: 1.8;
                white-space: pre;
                animation: code-scroll 25s linear infinite;
            }

            .code-pane::after {
                content: "";
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 80px;
                background: linear-gradient(transparent, rgba(10,10,16,0.95));
                pointer-events: none;
            }

            @keyframes code-scroll {
                0% { transform: translateY(0); }
                100% { transform: translateY(-45%); }
            }

            .kw { color: #c084fc; }
            .fn { color: #6d8fff; }
            .str { color: #34d399; }
            .cm { color: #55556a; }
            .ty { color: #fbbf24; }
            .num { color: #fb923c; }
            .cursor {
                display: inline-block;
                width: 8px;
                height: 1.1em;
                background: var(--accent);
                vertical-align: text-bottom;
                animation: cursor-blink 1s step-end infinite;
            }

            @keyframes cursor-blink {
                0%, 100% { opacity: 1; }
                50% { opacity: 0; }
            }

            .editor-badge {
                position: absolute;
                bottom: -14px;
                right: 24px;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.55rem 1rem;
                border-radius: 10px;
                background: rgba(14,14,22,0.95);
                border: 1px solid rgba(52,211,153,0.3);
                font-family: "JetBrains Mono", monospace;
                font-size: 0.72rem;
                color: var(--accent-2);
                box-shadow: 0 8px 30px rgba(0,0,0,0.5);
                z-index: 2;
            }

            .editor-badge::before {
                content: "";
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: var(--accent-2);
                box-shadow: 0 0 8px var(--accent-2);
            }

            .editor-float {
                position: absolute;
                top: -18px;
                left: -18px;
                padding: 0.5rem 0.85rem;
                border-radius: 10px;
                background: rgba(14,14,22,0.9);
                border: 1px solid rgba(109,143,255,0.25);
                font-family: "JetBrains Mono", monospace;
                font-size: 0.68rem;
                color: var(--accent);
                box-shadow: 0 8px 24px rgba(0,0,0,0.4);
                z-index: 2;
                animation: float-badge 5s ease-in-out infinite;
            }

            @keyframes float-badge {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-6px); }
            }

            /* sections */
            section { position: relative; z-index: 1; padding: 5rem 0; }

            .section-head { margin-bottom: 2.5rem; }

            .section-label {
                display: inline-block;
                margin-bottom: 0.65rem;
                font-family: "JetBrains Mono", monospace;
                font-size: 0.72rem;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                color: var(--accent);
            }

            .section-head h2 {
                margin: 0 0 0.75rem;
                font-size: clamp(1.75rem, 4vw, 2.4rem);
                letter-spacing: -0.03em;
                font-weight: 700;
            }

            .section-head p { margin: 0; max-width: 58ch; color: var(--muted); }

            .bento {
                display: grid;
                grid-template-columns: repeat(6, 1fr);
                gap: 1rem;
            }

            .bento .card { grid-column: span 2; }
            .bento .card:nth-child(1),
            .bento .card:nth-child(2) { grid-column: span 3; }

            .card {
                position: relative;
                padding: 1.5rem;
                border-radius: var(--radius);
                background: var(--surface);
                border: 1px solid var(--line);
                backdrop-filter: blur(16px);
                transition: transform 0.3s, border-color 0.3s, box-shadow 0.3s;
            }

            .card:hover {
                transform: translateY(-3px);
                border-color: rgba(109,143,255,0.2);
                box-shadow: 0 16px 48px rgba(0,0,0,0.4), 0 0 30px rgba(109,143,255,0.05);
            }

            .card-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2.4rem;
                height: 2.4rem;
                margin-bottom: 0.9rem;
                border-radius: 8px;
                background: rgba(109,143,255,0.1);
                color: var(--accent);
            }

            .card h3 { margin: 0 0 0.45rem; font-size: 1rem; font-weight: 600; }
            .card p { margin: 0; color: var(--muted); font-size: 0.9rem; }

            .services-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }

            .service-card { padding: 2rem 1.5rem; }

            .service-card .num {
                font-family: "JetBrains Mono", monospace;
                font-size: 0.7rem;
                color: var(--accent-2);
                margin-bottom: 1rem;
            }

            .service-card .label {
                display: block;
                margin-bottom: 0.5rem;
                font-size: 1.2rem;
                font-weight: 700;
            }

            .service-card p { color: var(--muted); font-size: 0.92rem; }
            .service-card:nth-child(1) .num { color: var(--accent); }
            .service-card:nth-child(2) .num { color: var(--accent-3); }

            .process-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1rem;
            }

            .step-ring {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 3rem;
                height: 3rem;
                margin-bottom: 1rem;
                border-radius: 50%;
                border: 2px solid rgba(109,143,255,0.3);
                font-family: "JetBrains Mono", monospace;
                font-size: 0.82rem;
                font-weight: 600;
                color: var(--accent);
                box-shadow: 0 0 20px rgba(109,143,255,0.12);
            }

            .step-card { text-align: center; }
            .step-card h3 { margin: 0 0 0.35rem; font-size: 1rem; }
            .step-card p { margin: 0; font-size: 0.85rem; color: var(--muted); }

            .cta-wrap {
                position: relative;
                padding: 3rem;
                border-radius: calc(var(--radius) + 2px);
                background: linear-gradient(135deg, rgba(109,143,255,0.1), rgba(52,211,153,0.05));
                border: 1px solid rgba(109,143,255,0.18);
                overflow: hidden;
            }

            .cta-wrap::before {
                content: "";
                position: absolute;
                top: -60%;
                right: -10%;
                width: 350px;
                height: 350px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(109,143,255,0.18), transparent 70%);
            }

            .cta-wrap h2 {
                position: relative;
                margin: 0 0 0.65rem;
                font-size: clamp(1.6rem, 4vw, 2.2rem);
                letter-spacing: -0.03em;
            }

            .cta-wrap p { position: relative; margin: 0; color: var(--muted); max-width: 50ch; }
            .cta-actions { position: relative; display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1.5rem; }

            .site-footer {
                position: relative;
                z-index: 1;
                padding: 2rem 0 3rem;
                border-top: 1px solid var(--line);
                color: var(--muted);
                font-size: 0.88rem;
            }

            @media (max-width: 960px) {
                .nav { display: none; }
                .hero-grid { grid-template-columns: 1fr; }
                .editor { transform: none; }
                .editor:hover { transform: none; }
                .bento, .services-grid, .process-grid { grid-template-columns: 1fr; }
                .bento .card, .bento .card:nth-child(1), .bento .card:nth-child(2) { grid-column: span 1; }
                .hero { min-height: auto; padding-top: 5.5rem; }
            }

            @media (prefers-reduced-motion: reduce) {
                .code-pane pre, .ambient-orb, .editor-float, .eyebrow-dot { animation: none; }
                .card:hover, .button:hover, .editor:hover { transform: none; }
            }
        </style>
    </head>
    <body>
        <div class="ambient" aria-hidden="true">
            <div class="ambient-orb a"></div>
            <div class="ambient-orb b"></div>
            <div class="ambient-orb c"></div>
            <div class="ambient-grid"></div>
        </div>

        <header class="site-header">
            <div class="container site-header-inner">
                <a href="/" class="brand"><span class="brand-word">zynx</span><span class="brand-one">1</span></a>
                <nav class="nav" aria-label="Primary">
                    <a href="#why">Why Zynx</a>
                    <a href="#services">Services</a>
                    <a href="#process">How we work</a>
                    <a href="{{ route('contact') }}">Contact</a>
                </nav>
                <a class="button button-primary" href="{{ route('book') }}">Book a consultation</a>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="container hero-grid">
                    <div class="hero-copy">
                        <span class="eyebrow"><span class="eyebrow-dot"></span> Software, AI, Data & Automation</span>
                        <h1>Software that helps your business run <span class="grad">smarter</span></h1>
                        <p class="hero-lead">
                            We build custom software, apps and websites for growing businesses — replacing spreadsheets,
                            unlocking data with AI, and automating the work that slows you down.
                        </p>
                        <div class="hero-actions">
                            <a class="button button-primary" href="{{ route('book') }}">Book a consultation</a>
                            <a class="button button-ghost" href="#services">Explore services</a>
                        </div>
                        <div class="hero-pills">
                            <span class="pill"><span class="pill-dot blue"></span> <strong>Custom</strong> software & apps</span>
                            <span class="pill"><span class="pill-dot purple"></span> <strong>Data + AI</strong> insight</span>
                            <span class="pill"><span class="pill-dot green"></span> <strong>Automate</strong> workflows</span>
                        </div>
                    </div>

                    <div class="editor-wrap">
                        <span class="editor-float">~/zynx/platform</span>
                        <div class="editor">
                            <div class="editor-bar">
                                <div class="editor-dots"><span></span><span></span><span></span></div>
                                <span class="editor-tab">BusinessEngine.php</span>
                            </div>
                            <div class="editor-body">
                                <div class="line-nums" aria-hidden="true">
                                    <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                                    <span>6</span><span>7</span><span>8</span><span>9</span><span>10</span>
                                    <span>11</span><span>12</span><span>13</span><span>14</span><span>15</span>
                                    <span>16</span><span>17</span><span>18</span><span>19</span><span>20</span>
                                </div>
                                <div class="code-pane">
                                    <pre><span class="cm">// zynx1 — built around your business</span>
<span class="kw">namespace</span> <span class="ty">Zynx\Platform</span>;

<span class="kw">class</span> <span class="ty">BusinessEngine</span>
{
    <span class="kw">public function</span> <span class="fn">discover</span>(<span class="ty">Client</span> $client): <span class="ty">Requirements</span>
    {
        <span class="kw">return</span> $client
            -><span class="fn">mapProcesses</span>()
            -><span class="fn">identifyBottlenecks</span>()
            -><span class="fn">defineOutcomes</span>();
    }

    <span class="kw">public function</span> <span class="fn">build</span>(<span class="ty">Requirements</span> $req): <span class="ty">Solution</span>
    {
        <span class="kw">return</span> <span class="ty">Solution</span>::<span class="fn">create</span>([
            <span class="str">'software'</span> => $req-><span class="fn">customApps</span>(),
            <span class="str">'data'</span>     => $req-><span class="fn">dashboards</span>(),
            <span class="str">'ai'</span>       => $req-><span class="fn">practicalAI</span>(),
            <span class="str">'automate'</span> => $req-><span class="fn">workflows</span>(),
        ]);
    }

    <span class="kw">public function</span> <span class="fn">deploy</span>(<span class="ty">Solution</span> $sol): <span class="ty">Result</span>
    {
        <span class="kw">return</span> $sol
            -><span class="fn">integrate</span>(<span class="str">'existing-systems'</span>)
            -><span class="fn">monitor</span>()
            -><span class="fn">improve</span>(continuous: <span class="kw">true</span>);<span class="cursor"></span>
    }
}

$engine = <span class="kw">new</span> <span class="ty">BusinessEngine</span>();
$result = $engine-><span class="fn">deploy</span>(
    $engine-><span class="fn">build</span>($engine-><span class="fn">discover</span>($client))
);

<span class="fn">logger</span>(<span class="str">'time_saved'</span>, <span class="num">847</span>);  <span class="cm">// hrs/quarter</span>
<span class="fn">logger</span>(<span class="str">'dashboards'</span>, <span class="num">12</span>);   <span class="cm">// live</span>
<span class="fn">logger</span>(<span class="str">'workflows'</span>, <span class="num">34</span>);    <span class="cm">// active</span></pre>
                                </div>
                            </div>
                        </div>
                        <div class="editor-badge">deployed — all systems go</div>
                    </div>
                </div>
            </section>

            <section id="why">
                <div class="container">
                    <div class="section-head">
                        <span class="section-label">// why_zynx</span>
                        <h2>Why businesses choose Zynx</h2>
                        <p>User-centred design, software engineering, data expertise and practical AI — without enterprise overhead.</p>
                    </div>
                    <div class="bento">
                        <article class="card">
                            <div class="card-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M7 21V7l5-4 5 4v14"/></svg></div>
                            <h3>Enterprise experience without enterprise overhead</h3>
                            <p>Proven digital expertise without the complexity and cost of large consultancy engagements.</p>
                        </article>
                        <article class="card">
                            <div class="card-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c1.5-4 6-6 8-6s6.5 2 8 6"/></svg></div>
                            <h3>User-centred by design</h3>
                            <p>Every solution starts with understanding your users, processes and goals.</p>
                        </article>
                        <article class="card">
                            <div class="card-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4m0 12v4M4.9 4.9l2.8 2.8m8.6 8.6 2.8 2.8M2 12h4m12 0h4"/></svg></div>
                            <h3>Practical AI</h3>
                            <p>AI where it delivers measurable business value, not unnecessary complexity.</p>
                        </article>
                        <article class="card">
                            <div class="card-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg></div>
                            <h3>Built around your business</h3>
                            <p>Solutions tailored to your workflows, customers and growth plans.</p>
                        </article>
                        <article class="card">
                            <div class="card-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                            <h3>Partnership first</h3>
                            <p>Solutions that continue creating value long after launch.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section id="services">
                <div class="container">
                    <div class="section-head">
                        <span class="section-label">// services</span>
                        <h2>What we do</h2>
                        <p>Reduce manual work, improve visibility and create better experiences through software, data and automation.</p>
                    </div>
                    <div class="services-grid">
                        <article class="card service-card">
                            <span class="num">01 / design_build</span>
                            <span class="label">Design & Build</span>
                            <p>Custom software, apps and digital platforms — from prototypes to production-ready solutions.</p>
                        </article>
                        <article class="card service-card">
                            <span class="num">02 / data_ai</span>
                            <span class="label">Data & AI</span>
                            <p>Dashboards, trends and AI applied where it creates genuine value for your team.</p>
                        </article>
                        <article class="card service-card">
                            <span class="num">03 / automation</span>
                            <span class="label">Automation & Integration</span>
                            <p>Connect systems, eliminate repetitive tasks and automate workflows.</p>
                        </article>
                    </div>
                </div>
            </section>

            <section id="process">
                <div class="container">
                    <div class="section-head">
                        <span class="section-label">// process</span>
                        <h2>How we work</h2>
                    </div>
                    <div class="process-grid">
                        <article class="card step-card"><span class="step-ring">01</span><h3>Discover</h3><p>Understand your business, users, systems and challenges.</p></article>
                        <article class="card step-card"><span class="step-ring">02</span><h3>Design</h3><p>Prototype and validate before committing time and budget.</p></article>
                        <article class="card step-card"><span class="step-ring">03</span><h3>Build</h3><p>Develop scalable, secure software with modern tech.</p></article>
                        <article class="card step-card"><span class="step-ring">04</span><h3>Improve</h3><p>Measure, learn and continuously refine.</p></article>
                    </div>
                </div>
            </section>

            <section>
                <div class="container">
                    <div class="cta-wrap">
                        <h2>Ready to spend less time managing systems and more time growing?</h2>
                        <p>Let's explore where software, automation or AI could make the biggest impact.</p>
                        <div class="cta-actions">
                            <a class="button button-primary" href="{{ route('book') }}">Book a consultation</a>
                            <a class="button button-ghost" href="{{ route('contact') }}">Contact us</a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="container" style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
                <span><span class="brand"><span class="brand-word">zynx</span><span class="brand-one">1</span></span> — Software, AI, Data & Automation</span>
                <span>
                    <a href="{{ route('contact') }}">Contact</a>
                    &middot;
                    <a href="{{ route('book') }}">Book consultation</a>
                </span>
            </div>
        </footer>
    </body>
</html>
