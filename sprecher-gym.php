<?php
/**
 * Plugin Name: Sprecher Gym
 * Version: 1.0
 */

if (! defined('ABSPATH')) {
    exit;
}

function sprecher_gym_enqueue_assets(): void
{
    $plugin_url  = plugin_dir_url(__FILE__);
    $plugin_path = plugin_dir_path(__FILE__);

    wp_register_script('sprecher-gym-tailwind-config', false, array(), '1.0.0', false);
    wp_enqueue_script('sprecher-gym-tailwind-config');
    wp_add_inline_script(
        'sprecher-gym-tailwind-config',
        "tailwind.config = { darkMode: 'class', corePlugins: { preflight: false }, theme: { extend: { colors: { cabin: { 900: '#0a0d12', 800: '#111827', 700: '#1f2937' } } } } };",
        'before'
    );

    wp_enqueue_script(
        'sprecher-gym-tailwind-cdn',
        'https://cdn.tailwindcss.com',
        array('sprecher-gym-tailwind-config'),
        null,
        false
    );

    wp_enqueue_style(
        'sprecher-gym-style',
        $plugin_url . 'css/style.css',
        array(),
        filemtime($plugin_path . 'css/style.css')
    );

    wp_enqueue_script(
        'sprecher-gym-script',
        $plugin_url . 'js/script.js',
        array(),
        filemtime($plugin_path . 'js/script.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'sprecher_gym_enqueue_assets');

function sprecher_gym_shortcode(): string
{
    ob_start();
    ?>
    <div id="sprecher-gym-app">
      <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
      <aside class="border-b lg:border-b-0 lg:border-r border-slate-800 bg-cabin-800/70 backdrop-blur">
        <div class="p-6">
          <h1 class="text-2xl font-bold tracking-tight">Sprecher-Gym</h1>
          <p class="text-sm text-slate-400 mt-1">Trainings-Tool für Voice Professionals</p>
        </div>
        <nav class="px-4 pb-6 space-y-2" id="navTabs">
          <button class="tab-btn w-full text-left px-4 py-3 rounded-lg bg-indigo-500/20 border border-indigo-500/50" data-target="generator">
            1. DEMO-Text-Generator
          </button>
          <button class="tab-btn w-full text-left px-4 py-3 rounded-lg hover:bg-slate-700/70 border border-transparent" data-target="teleprompter">
            2. Teleprompter &amp; Lese-Trainer
          </button>
          <button class="tab-btn w-full text-left px-4 py-3 rounded-lg hover:bg-slate-700/70 border border-transparent" data-target="artikulation">
            3. Artikulations-Datenbank
          </button>
          <button class="tab-btn w-full text-left px-4 py-3 rounded-lg hover:bg-slate-700/70 border border-transparent" data-target="business">
            4. Business-Basics
          </button>
        </nav>
      </aside>

      <main class="p-4 md:p-8">
        <header class="mb-8 bg-cabin-800/70 border border-slate-800 rounded-2xl p-4 md:p-6">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
              <h2 class="text-xl md:text-2xl font-semibold">Interaktiver Trainingsmodus</h2>
              <p class="text-slate-400 text-sm md:text-base">Schalte Premium frei, um erweiterte Sprecher-Features zu testen.</p>
            </div>

            <div class="flex items-center gap-3 bg-slate-900 border border-slate-700 rounded-full px-3 py-2 w-fit">
              <span id="freeLabel" class="text-sm font-semibold text-indigo-300">Free Version</span>
              <button
                id="planToggle"
                aria-label="Free oder Premium umschalten"
                class="relative inline-flex h-8 w-16 items-center rounded-full bg-indigo-500 transition"
              >
                <span id="toggleKnob" class="inline-block h-6 w-6 transform rounded-full bg-white transition translate-x-1"></span>
              </button>
              <span id="premiumLabel" class="text-sm font-semibold text-slate-500">Premium Version</span>
            </div>
          </div>
        </header>

        <section id="generator" class="tab-section space-y-4">
          <div class="bg-cabin-800/70 border border-slate-800 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold">DEMO-Text-Generator</h3>
              <span class="text-xs px-2 py-1 rounded-full bg-emerald-500/20 text-emerald-300">Basisfunktion aktiv</span>
            </div>
            <div class="grid md:grid-cols-3 gap-3 mb-4 premium-lockable opacity-60 pointer-events-none" data-pro="true">
              <label class="text-sm">
                <span class="block mb-1 text-slate-300">Emotion <span class="ml-1 text-[10px] px-1.5 py-0.5 rounded bg-amber-500 text-slate-900 font-bold">PRO</span></span>
                <select class="w-full rounded-lg bg-slate-900 border border-slate-700 p-2">
                  <option>Neutral</option>
                  <option>Energetisch</option>
                  <option>Vertrauenswürdig</option>
                  <option>Dramatisch</option>
                </select>
              </label>
              <label class="text-sm">
                <span class="block mb-1 text-slate-300">Länge <span class="ml-1 text-[10px] px-1.5 py-0.5 rounded bg-amber-500 text-slate-900 font-bold">PRO</span></span>
                <select class="w-full rounded-lg bg-slate-900 border border-slate-700 p-2">
                  <option>Kurz (1-2 Sätze)</option>
                  <option>Mittel (4-6 Sätze)</option>
                  <option>Lang (10+ Sätze)</option>
                </select>
              </label>
              <label class="text-sm">
                <span class="block mb-1 text-slate-300">Nische <span class="ml-1 text-[10px] px-1.5 py-0.5 rounded bg-amber-500 text-slate-900 font-bold">PRO</span></span>
                <select class="w-full rounded-lg bg-slate-900 border border-slate-700 p-2">
                  <option>Automotive</option>
                  <option>Food</option>
                  <option>Tech</option>
                  <option>Imagefilm</option>
                </select>
              </label>
            </div>

            <div class="flex flex-wrap gap-3 mb-4">
              <button id="generateTextBtn" class="px-4 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400 font-semibold">Zufälligen Text generieren</button>
              <button class="premium-lockable px-4 py-2 rounded-lg bg-slate-700 text-slate-300 border border-slate-600 opacity-60 pointer-events-none" data-pro="true">
                Als PDF exportieren <span class="ml-1 text-[10px] px-1.5 py-0.5 rounded bg-amber-500 text-slate-900 font-bold">PRO</span>
              </button>
            </div>

            <textarea id="generatedText" rows="5" class="w-full rounded-xl bg-slate-900 border border-slate-700 p-3 text-slate-100" placeholder="Dein generierter Demo-Text erscheint hier..."></textarea>
          </div>
        </section>

        <section id="teleprompter" class="tab-section hidden space-y-4">
          <div class="bg-cabin-800/70 border border-slate-800 rounded-2xl p-6 space-y-4">
            <h3 class="text-lg font-semibold">Teleprompter &amp; Lese-Trainer</h3>
            <textarea id="prompterInput" rows="5" class="w-full rounded-xl bg-slate-900 border border-slate-700 p-3" placeholder="Skript hier einfügen..."></textarea>
            <div class="flex flex-wrap items-center gap-3">
              <button id="startPrompter" class="px-4 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400">Prompter starten</button>
              <label class="text-sm premium-lockable opacity-60 pointer-events-none" data-pro="true">
                Scroll-Speed <span id="speedValue">4</span>
                <input id="speedControl" type="range" min="1" max="10" value="4" class="align-middle ml-2" />
                <span class="ml-1 text-[10px] px-1.5 py-0.5 rounded bg-amber-500 text-slate-900 font-bold">PRO</span>
              </label>
            </div>
            <div id="prompterView" class="h-48 overflow-y-auto rounded-xl bg-slate-900 border border-slate-700 p-4 leading-7 text-lg"></div>
          </div>
        </section>

        <section id="artikulation" class="tab-section hidden">
          <div class="bg-cabin-800/70 border border-slate-800 rounded-2xl p-6 space-y-5">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold">Artikulations-Datenbank</h3>
              <button id="startTempo" class="premium-lockable px-4 py-2 rounded-lg bg-slate-700 border border-slate-600 opacity-60 pointer-events-none" data-pro="true">
                Tempo-Challenge starten <span class="ml-1 text-[10px] px-1.5 py-0.5 rounded bg-amber-500 text-slate-900 font-bold">PRO</span>
              </button>
            </div>
            <p class="text-slate-300">Timer: <span id="tempoTimer" class="font-semibold">00:00</span></p>
            <div id="twisterList" class="grid md:grid-cols-2 gap-4"></div>
          </div>
        </section>

        <section id="business" class="tab-section hidden">
          <div class="bg-cabin-800/70 border border-slate-800 rounded-2xl p-6 space-y-5">
            <h3 class="text-lg font-semibold">Business-Basics</h3>
            <ul class="list-disc list-inside text-slate-300 space-y-2">
              <li><a href="#" class="hover:text-indigo-300">Artikel: Mikrofon-Basics für Einsteiger</a></li>
              <li><a href="#" class="hover:text-indigo-300">Artikel: Demo-Reel strukturieren</a></li>
              <li><a href="#" class="hover:text-indigo-300">Artikel: Kommunikation mit Auftraggebern</a></li>
            </ul>

            <div class="premium-lockable opacity-60 pointer-events-none" data-pro="true">
              <div class="rounded-xl border border-slate-700 bg-slate-900 p-4 space-y-3">
                <h4 class="font-semibold">Gagen-Kalkulator <span class="ml-1 text-[10px] px-1.5 py-0.5 rounded bg-amber-500 text-slate-900 font-bold">PRO</span></h4>
                <div class="grid md:grid-cols-3 gap-3">
                  <label class="text-sm">Länge in Sekunden
                    <input id="lengthInput" type="number" min="1" value="30" class="mt-1 w-full rounded-lg bg-slate-800 border border-slate-700 p-2" />
                  </label>
                  <label class="text-sm">Medium
                    <select id="mediumSelect" class="mt-1 w-full rounded-lg bg-slate-800 border border-slate-700 p-2">
                      <option value="radio">Radio</option>
                      <option value="podcast">Podcast Ad</option>
                      <option value="tv">TV</option>
                      <option value="online">Online Spot</option>
                    </select>
                  </label>
                  <div class="text-sm flex flex-col justify-end">
                    <button id="calcFee" class="px-4 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-400">Gage berechnen</button>
                  </div>
                </div>
                <p class="text-slate-200">Empfohlene Gage: <span id="feeOutput" class="font-bold">€ 0</span></p>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
    </div>
    <?php

    return (string) ob_get_clean();
}
add_shortcode('sprecher_gym', 'sprecher_gym_shortcode');
