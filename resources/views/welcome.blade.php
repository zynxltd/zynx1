<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>zynx1</title>
        <style>
            html,
            body {
                height: 100%;
            }

            body {
                margin: 0;
                display: grid;
                place-items: center;
                font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji",
                    "Segoe UI Emoji";
                letter-spacing: 0.08em;
                text-transform: lowercase;
                font-size: 48px;
                color: rgba(255, 255, 255, 0.92);
                background: radial-gradient(1400px circle at 10% 20%, rgba(118, 93, 255, 0.35), transparent 60%),
                    radial-gradient(1200px circle at 90% 80%, rgba(0, 229, 255, 0.25), transparent 62%),
                    radial-gradient(900px circle at 45% 55%, rgba(255, 120, 180, 0.16), transparent 65%),
                    linear-gradient(120deg, #070910, #050715);
                background-size: 240% 240%;
                animation: bg-pan 28s ease-in-out infinite alternate;
                overflow: hidden;
            }

            .brand {
                position: relative;
                z-index: 1;
                display: inline-flex;
                align-items: baseline;
                white-space: nowrap;
            }

            .brand-word {
                display: inline-block;
                font-weight: 500;
                letter-spacing: 0.09em;
                background-image: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(210, 225, 255, 0.72));
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
                text-shadow: 0 0 18px rgba(120, 160, 255, 0.18), 0 0 34px rgba(255, 255, 255, 0.08);
            }

            .brand-one {
                display: inline-block;
                font-weight: 800;
                background-image: linear-gradient(180deg, rgba(245, 245, 245, 0.95), rgba(160, 160, 160, 0.95));
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
                text-shadow: 0 0 12px rgba(255, 255, 255, 0.12);
            }

            body::before {
                content: "";
                position: fixed;
                inset: -40%;
                background: radial-gradient(1200px 700px at 30% 40%, rgba(120, 160, 255, 0.16), rgba(0, 0, 0, 0) 60%),
                    radial-gradient(1100px 700px at 70% 60%, rgba(0, 255, 214, 0.10), rgba(0, 0, 0, 0) 62%),
                    linear-gradient(115deg, rgba(150, 90, 255, 0.00), rgba(150, 90, 255, 0.16), rgba(0, 229, 255, 0.10), rgba(0, 0, 0, 0)),
                    linear-gradient(25deg, rgba(255, 120, 180, 0), rgba(255, 120, 180, 0.10), rgba(255, 255, 255, 0));
                background-size: 180% 180%;
                mix-blend-mode: screen;
                filter: blur(44px) saturate(1.25);
                opacity: 0.58;
                transform: translate3d(0, 0, 0) rotate(-10deg);
                animation: aurora 18s ease-in-out infinite alternate;
                pointer-events: none;
            }

            body::after {
                content: "";
                position: fixed;
                inset: -30%;
                background: radial-gradient(closest-side at 50% 50%, rgba(0, 0, 0, 0) 55%, rgba(0, 0, 0, 0.35) 100%),
                    radial-gradient(2px 2px at 12% 18%, rgba(255, 255, 255, 0.14), rgba(255, 255, 255, 0)),
                    radial-gradient(1.5px 1.5px at 68% 28%, rgba(255, 255, 255, 0.12), rgba(255, 255, 255, 0)),
                    radial-gradient(2.2px 2.2px at 82% 72%, rgba(255, 255, 255, 0.10), rgba(255, 255, 255, 0)),
                    radial-gradient(1.4px 1.4px at 28% 78%, rgba(255, 255, 255, 0.10), rgba(255, 255, 255, 0)),
                    repeating-linear-gradient(0deg, rgba(255, 255, 255, 0.015) 0 1px, rgba(255, 255, 255, 0) 1px 3px),
                    repeating-linear-gradient(90deg, rgba(255, 255, 255, 0.012) 0 1px, rgba(255, 255, 255, 0) 1px 4px);
                mix-blend-mode: overlay;
                opacity: 0.26;
                filter: blur(0.35px);
                transform: translate3d(0, 0, 0);
                animation: grain 9s steps(8, end) infinite;
                pointer-events: none;
            }

            @keyframes bg-pan {
                0% {
                    background-position: 0% 0%;
                }
                100% {
                    background-position: 100% 100%;
                }
            }

            @keyframes drift {
                0% {
                    transform: translate3d(-2%, -1%, 0) scale(1.02);
                    opacity: 0.28;
                }
                50% {
                    transform: translate3d(2%, 1.5%, 0) scale(1.04);
                    opacity: 0.42;
                }
                100% {
                    transform: translate3d(-1.5%, 2%, 0) scale(1.03);
                    opacity: 0.34;
                }
            }

            @keyframes aurora {
                0% {
                    background-position: 10% 20%;
                    transform: translate3d(-2%, -1%, 0) rotate(-12deg) scale(1.05);
                    opacity: 0.52;
                }
                50% {
                    background-position: 55% 35%;
                    transform: translate3d(2.5%, 1.5%, 0) rotate(-6deg) scale(1.08);
                    opacity: 0.64;
                }
                100% {
                    background-position: 95% 80%;
                    transform: translate3d(-1.5%, 2.5%, 0) rotate(-10deg) scale(1.06);
                    opacity: 0.56;
                }
            }

            @keyframes grain {
                0% {
                    transform: translate3d(0, 0, 0);
                }
                15% {
                    transform: translate3d(-1%, 0.5%, 0);
                }
                30% {
                    transform: translate3d(1.2%, -0.7%, 0);
                }
                45% {
                    transform: translate3d(-0.6%, -1.1%, 0);
                }
                60% {
                    transform: translate3d(0.9%, 1.1%, 0);
                }
                75% {
                    transform: translate3d(-1.1%, 0.9%, 0);
                }
                100% {
                    transform: translate3d(0.6%, -0.6%, 0);
                }
            }

            @media (prefers-reduced-motion: reduce) {
                body,
                body::before,
                body::after {
                    animation: none !important;
                }
            }
        </style>
    </head>
    <body>
        <div class="brand"><span class="brand-word">zynx</span><span class="brand-one">1</span></div>
    </body>
</html>

