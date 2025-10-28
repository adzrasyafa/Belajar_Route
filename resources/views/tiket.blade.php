<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tiket Wisata - Tema Traveling</title>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
        transition: all 1s ease;
    }

    body {
        height: 100vh;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        color: #fff;
    }

    /* 🌊 === TEMA LAUT === */
    body.laut {
        background: linear-gradient(to bottom, #00b4d8, #03045e 80%, #000814);
    }

    /* ⛰️ === TEMA GUNUNG === */
    body.gunung {
        background: linear-gradient(to top, #ff9e00 0%, #ffbf69 40%, #1a3c34 100%);
    }

    /* 💳 KARTU INFORMASI */
    .card {
        z-index: 3;
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.2);
        padding: 40px 70px;
        border-radius: 25px;
        text-align: center;
        box-shadow: 0 0 35px rgba(0, 150, 255, 0.4);
        backdrop-filter: blur(10px);
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    h2 {
        font-size: 2em;
        text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
        animation: waveText 4s ease-in-out infinite;
    }

    @keyframes waveText {
        0%, 100% { transform: rotate(0deg); letter-spacing: 1px; }
        50% { transform: rotate(1deg); letter-spacing: 4px; color: #b3ecff; }
    }

    p {
        font-size: 1.2em;
        margin-top: 10px;
    }

    b {
        color: #00c9ff;
        text-shadow: 0 0 10px rgba(0, 180, 255, 0.7);
    }

    /* 🫧 GELEMBUNG UNTUK LAUT */
    .bubble {
        position: absolute;
        bottom: -100px;
        background: radial-gradient(circle, rgba(255,255,255,0.8), rgba(255,255,255,0));
        border-radius: 50%;
        animation: rise 10s infinite ease-in;
        box-shadow: 0 0 15px rgba(255,255,255,0.3);
        z-index: 0;
    }

    @keyframes rise {
        0% { transform: translateY(0) scale(1); opacity: 1; }
        100% { transform: translateY(-120vh) scale(1.3); opacity: 0; }
    }

    /* 🌅 MATAHARI UNTUK GUNUNG */
    .sun {
        position: absolute;
        top: 10%;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 120px;
        background: radial-gradient(circle, #ffea00, #ff9e00);
        border-radius: 50%;
        box-shadow: 0 0 40px #ff9e00;
        animation: sunrise 8s ease-in-out infinite alternate;
    }

    @keyframes sunrise {
        0% { top: 20%; opacity: 0.8; }
        100% { top: 5%; opacity: 1; }
    }

    /* 🌲 POHON UNTUK GUNUNG */
    .tree {
        position: absolute;
        bottom: 0;
        width: 40px;
        height: 100px;
        background: #22543d;
        border-radius: 0 0 10px 10px;
        z-index: 1;
    }

    .tree::before {
        content: "";
        position: absolute;
        top: -60px;
        left: -30px;
        width: 100px;
        height: 80px;
        background: radial-gradient(circle at center, #2f855a, #22543d);
        clip-path: polygon(50% 0%, 100% 100%, 0% 100%);
    }

    /* 🐠🐚🦀🦞 EMOJI BERGERAK DARI BAWAH KE ATAS */
    .emoji {
        position: absolute;
        bottom: -50px;
        opacity: 0.9;
        animation: floatEmoji 15s linear infinite;
        z-index: 2;
    }

    @keyframes floatEmoji {
        0% { transform: translateY(0) rotate(0deg) scale(1); opacity: 1; }
        100% { transform: translateY(-120vh) rotate(360deg) scale(1.3); opacity: 0; }
    }

    /* 🌄 GUNUNG */
    .mountain {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 300px;
        background: linear-gradient(to top, #1a3c34, #2d6a4f);
        clip-path: polygon(0% 100%, 20% 40%, 50% 80%, 80% 35%, 100% 100%);
        z-index: 0;
    }

    /* 🔘 TOMBOL GANTI TEMA */
    .toggle-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        cursor: pointer;
        backdrop-filter: blur(10px);
        box-shadow: 0 0 10px rgba(255,255,255,0.3);
        transition: 0.3s;
        z-index: 5;
    }

    .toggle-btn:hover {
        background: rgba(255,255,255,0.4);
    }
</style>
</head>

<body class="laut">
    <!-- Tombol untuk Ganti Tema -->
    <button class="toggle-btn" onclick="toggleTheme()">Ganti Tema 🌄🌊</button>

    <!-- Kartu Informasi -->
    <div class="card">
        <h2>Informasi Tiket Wisata</h2>
        <p>Tempat Wisata: <b>{{ $tempat }}</b></p>
        <p>Harga Tiket: <b>Rp {{ number_format($harga, 0, ',', '.') }}</b></p>
    </div>

    <!-- Unsur Gunung -->
    <div class="sun"></div>
    <div class="mountain"></div>
    <div class="tree" style="left: 15%;"></div>
    <div class="tree" style="left: 35%;"></div>
    <div class="tree" style="left: 60%;"></div>
    <div class="tree" style="left: 80%;"></div>

    <script>
        const body = document.body;

        // Tambahkan gelembung laut
        for (let i = 0; i < 25; i++) {
            const bubble = document.createElement('div');
            bubble.classList.add('bubble');
            const size = Math.random() * 40 + 10 + 'px';
            bubble.style.width = size;
            bubble.style.height = size;
            bubble.style.left = Math.random() * 100 + '%';
            bubble.style.animationDuration = Math.random() * 6 + 6 + 's';
            bubble.style.animationDelay = Math.random() * 5 + 's';
            body.appendChild(bubble);
        }

        // Tambahkan emoji laut
        const lautEmoji = ['🐠','🦀','🐚','🦑','🐡','🐙','🦐','🐬','🦞','🐟','🐳','🐢'];
        for (let i = 0; i < 15; i++) {
            const emoji = document.createElement('div');
            emoji.classList.add('emoji');
            emoji.textContent = lautEmoji[Math.floor(Math.random() * lautEmoji.length)];
            emoji.style.left = Math.random() * 100 + '%';
            emoji.style.animationDelay = Math.random() * 10 + 's';
            emoji.style.animationDuration = (Math.random() * 10 + 10) + 's';
            emoji.style.fontSize = Math.random() * 2 + 1.5 + 'rem';
            body.appendChild(emoji);
        }

        // Fungsi ganti tema
        function toggleTheme() {
            if (body.classList.contains('laut')) {
                body.classList.remove('laut');
                body.classList.add('gunung');
                document.querySelector('.toggle-btn').textContent = "Ganti Tema 🌊";
            } else {
                body.classList.remove('gunung');
                body.classList.add('laut');
                document.querySelector('.toggle-btn').textContent = "Ganti Tema 🌄";
            }
        }
    </script>
</body>
</html>
