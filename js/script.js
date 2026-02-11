document.addEventListener('DOMContentLoaded', () => {
  const app = document.getElementById('sprecher-gym-app');

  if (!app) {
    return;
  }

  let isPremium = false;
  let autoScrollInterval = null;
  let tempoInterval = null;
  let tempoSeconds = 0;

  const planToggle = document.getElementById('planToggle');
  const toggleKnob = document.getElementById('toggleKnob');
  const freeLabel = document.getElementById('freeLabel');
  const premiumLabel = document.getElementById('premiumLabel');
  const premiumLockables = document.querySelectorAll('.premium-lockable');

  const tabButtons = document.querySelectorAll('.tab-btn');
  const tabSections = document.querySelectorAll('.tab-section');
  const generatedText = document.getElementById('generatedText');
  const randomTexts = [
    'Mit klarem Fokus und ruhiger Stimme gibst du jeder Botschaft den richtigen Klang.',
    'Heute trainieren wir präzise Aussprache, damit jedes Wort sicher und überzeugend ankommt.',
    'Stell dir vor, du begleitest den Zuhörer durch eine starke Geschichte voller Emotion.'
  ];

  const speedControl = document.getElementById('speedControl');
  const speedValue = document.getElementById('speedValue');
  const prompterInput = document.getElementById('prompterInput');
  const prompterView = document.getElementById('prompterView');

  const twisters = [
    'Fischers Fritze fischt frische Fische.',
    'Brautkleid bleibt Brautkleid und Blaukraut bleibt Blaukraut.',
    'Zehn zahme Ziegen zogen zehn Zentner Zucker zum Zoo.',
    'Wenn Fliegen hinter Fliegen fliegen, fliegen Fliegen Fliegen nach.'
  ];

  const twisterList = document.getElementById('twisterList');
  const tempoTimer = document.getElementById('tempoTimer');

  function renderTwisters() {
    twisterList.innerHTML = '';
    twisters.forEach((text) => {
      const card = document.createElement('div');
      card.className = 'rounded-xl border border-slate-700 bg-slate-900 p-4';
      card.innerHTML = `
        <div class="flex items-center justify-between gap-3">
          <p>${text}</p>
          <button data-pro="true" class="premium-lockable opacity-60 pointer-events-none whitespace-nowrap px-3 py-2 rounded-lg bg-slate-700 border border-slate-600 text-sm">Play Audio <span class="ml-1 text-[10px] px-1 py-0.5 rounded bg-amber-500 text-slate-900 font-bold">PRO</span></button>
        </div>
      `;
      twisterList.appendChild(card);
    });
  }

  function updatePremiumUI() {
    premiumLockables.forEach((el) => {
      if (isPremium) {
        el.classList.remove('opacity-60', 'pointer-events-none');
      } else {
        el.classList.add('opacity-60', 'pointer-events-none');
      }
    });

    document.querySelectorAll('[data-pro="true"]').forEach((el) => {
      if (isPremium) {
        el.classList.remove('opacity-60', 'pointer-events-none');
      } else {
        el.classList.add('opacity-60', 'pointer-events-none');
      }
    });

    toggleKnob.style.transform = isPremium ? 'translateX(2.1rem)' : 'translateX(0.25rem)';
    planToggle.classList.toggle('bg-indigo-500', !isPremium);
    planToggle.classList.toggle('bg-emerald-500', isPremium);
    freeLabel.classList.toggle('text-indigo-300', !isPremium);
    freeLabel.classList.toggle('text-slate-500', isPremium);
    premiumLabel.classList.toggle('text-emerald-300', isPremium);
    premiumLabel.classList.toggle('text-slate-500', !isPremium);

    if (!isPremium && autoScrollInterval) {
      clearInterval(autoScrollInterval);
      autoScrollInterval = null;
    }
  }

  planToggle.addEventListener('click', () => {
    isPremium = !isPremium;
    updatePremiumUI();
  });

  tabButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const target = button.dataset.target;
      tabSections.forEach((section) => section.classList.add('hidden'));
      tabButtons.forEach((btn) => {
        btn.classList.remove('bg-indigo-500/20', 'border-indigo-500/50');
        btn.classList.add('border-transparent');
      });
      document.getElementById(target).classList.remove('hidden');
      button.classList.add('bg-indigo-500/20', 'border-indigo-500/50');
      button.classList.remove('border-transparent');
    });
  });

  document.getElementById('generateTextBtn').addEventListener('click', () => {
    const randomText = randomTexts[Math.floor(Math.random() * randomTexts.length)];
    generatedText.value = randomText;
  });

  document.getElementById('startPrompter').addEventListener('click', () => {
    prompterView.textContent = prompterInput.value || 'Bitte zuerst Text einfügen, dann den Prompter starten.';
    prompterView.scrollTop = 0;

    if (autoScrollInterval) {
      clearInterval(autoScrollInterval);
      autoScrollInterval = null;
    }

    if (isPremium) {
      autoScrollInterval = setInterval(() => {
        prompterView.scrollTop += Number(speedControl.value) / 8;
      }, 100);
    }
  });

  speedControl.addEventListener('input', () => {
    speedValue.textContent = speedControl.value;
  });

  document.getElementById('startTempo').addEventListener('click', () => {
    if (!isPremium) return;
    clearInterval(tempoInterval);
    tempoSeconds = 0;
    tempoInterval = setInterval(() => {
      tempoSeconds += 1;
      const mins = String(Math.floor(tempoSeconds / 60)).padStart(2, '0');
      const secs = String(tempoSeconds % 60).padStart(2, '0');
      tempoTimer.textContent = `${mins}:${secs}`;
    }, 1000);
  });

  document.getElementById('calcFee').addEventListener('click', () => {
    if (!isPremium) return;
    const length = Number(document.getElementById('lengthInput').value) || 0;
    const medium = document.getElementById('mediumSelect').value;
    const factors = { radio: 4.5, podcast: 3.2, tv: 7.8, online: 5.1 };
    const fee = Math.round(length * (factors[medium] || 3));
    document.getElementById('feeOutput').textContent = `€ ${fee}`;
  });

  renderTwisters();
  updatePremiumUI();
});
