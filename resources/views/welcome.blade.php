<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>zynx</title>
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
                background: radial-gradient(900px circle at 15% 20%, rgba(118, 93, 255, 0.45), transparent 55%),
                    radial-gradient(800px circle at 85% 70%, rgba(0, 229, 255, 0.32), transparent 55%),
                    radial-gradient(700px circle at 50% 50%, rgba(255, 120, 180, 0.2), transparent 60%),
                    linear-gradient(120deg, #070910, #050715);
                background-size: 140% 140%;
                animation: bg-pan 18s ease-in-out infinite alternate;
                overflow: hidden;
            }

            body::before {
                content: "";
                position: fixed;
                inset: -40%;
                background: conic-gradient(
                    from 0deg at 50% 50%,
                    rgba(255, 255, 255, 0.08),
                    rgba(255, 255, 255, 0) 35%,
                    rgba(255, 255, 255, 0.06),
                    rgba(255, 255, 255, 0) 70%,
                    rgba(255, 255, 255, 0.08)
                );
                filter: blur(30px);
                opacity: 0.55;
                animation: spin 28s linear infinite;
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

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }
        </style>
    </head>
    <body>
        zynx
    </body>
</html>

