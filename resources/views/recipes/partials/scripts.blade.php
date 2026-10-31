<script>
// ========== 1. INGREDIENTS SCALER ==========
const basePortions = {{ $recipe->servings }};
let currentPortion = {{ $recipe->servings }};
const recipeId = {{ $recipe->id }};

const ingredientsData = JSON.parse(document.getElementById('recipe-ingredients-data')?.textContent || '[]');
const cookingStepsData = JSON.parse(document.getElementById('recipe-steps-data')?.textContent || '[]');

function renderIngredients() {
    const container = document.getElementById('ingredientsContainer');
    if (!container) return;
    container.innerHTML = '';

    ingredientsData.forEach((item) => {
        const scaled = (item.amount / basePortions) * currentPortion;
        const formatted = Number.isInteger(scaled) ? scaled : scaled.toFixed(1);
        const row = document.createElement('label');
        row.className = 'py-2.5 flex items-center justify-between cursor-pointer group select-none';
        row.innerHTML = `
            <div class="flex items-center gap-2 min-w-0 pr-2">
                <input type="checkbox" onchange="toggleIngredientStrike(this)" class="w-5 h-5 rounded accent-primary shrink-0"/>
                <span class="text-sm text-on-surface group-hover:text-primary transition-colors truncate">${item.name}</span>
            </div>
            <span class="text-xs font-bold text-primary whitespace-nowrap pl-2">${formatted} ${item.unit}</span>
        `;
        container.appendChild(row);
    });
}

function changePortion(delta) {
    const n = currentPortion + delta;
    if (n >= 1 && n <= 30) {
        currentPortion = n;
        document.getElementById('currentPortionDisplay').textContent = currentPortion;
        renderIngredients();
    }
}

function toggleIngredientStrike(cb) {
    const span = cb.parentElement.querySelector('span');
    span.classList.toggle('line-through', cb.checked);
    span.classList.toggle('text-secondary', cb.checked);
    span.classList.toggle('opacity-60', cb.checked);
}

function copyIngredientsList() {
    let text = `Bahan ${'{{ $recipe->title }}'} (${currentPortion} Porsi):\n`;
    ingredientsData.forEach(item => {
        const scaled = (item.amount / basePortions) * currentPortion;
        const formatted = Number.isInteger(scaled) ? scaled : scaled.toFixed(1);
        text += `- ${item.name}: ${formatted} ${item.unit}\n`;
    });
    navigator.clipboard?.writeText(text);
    showToast('Daftar bahan berhasil disalin!');
}

// ========== 2. BOOKMARK (AJAX) ==========
function toggleBookmark() {
    // 1. JIKA BELUM LOGIN (GUEST)
    @guest
        const modal = document.getElementById('loginPromptModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        return; // Hentikan proses, jangan jalankan fetch
    @endguest

    // 2. JIKA SUDAH LOGIN (AUTH)
    @auth
        const btn = document.getElementById('bookmarkBtn');
        const icon = document.getElementById('bookmarkIcon');
        const count = document.getElementById('bookmarkCount');
        const isBookmarked = btn.dataset.bookmarked === 'true';

        fetch(`/bookmark/${recipeId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            const nowBookmarked = data.status === 'added';
            btn.dataset.bookmarked = nowBookmarked ? 'true' : 'false';
            icon.textContent = nowBookmarked ? 'bookmark' : 'bookmark_border';
            icon.style.fontVariationSettings = `'FILL' ${nowBookmarked ? 1 : 0}`;
            let n = parseInt(count.textContent.replace(/[^\d]/g, '')) || 0;
            count.textContent = nowBookmarked ? n + 1 : Math.max(0, n - 1);
            showToast(data.message);
        })
        .catch(() => showToast('Gagal. Coba lagi.'));
    @endauth
}

function copyRecipeLink() {
    navigator.clipboard?.writeText(window.location.href);
    showToast('Tautan resep disalin!');
}

function scrollToInstructions() {
    document.getElementById('instructionTimeline')?.scrollIntoView({ behavior: 'smooth' });
}

// ========== 3. TOAST ==========
function showToast(msg) {
    const toast = document.getElementById('toastNotification');
    const el = document.getElementById('toastMessage');
    if (!toast || !el) return;
    el.textContent = msg;
    toast.classList.remove('translate-y-24', 'opacity-0');
    toast.classList.add('translate-y-0', 'opacity-100');
    setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-24', 'opacity-0');
    }, 2800);
}

// ========== 4. STEP TIMERS ==========
const stepTimers = {};

function formatTime(s) {
    return `${String(Math.floor(s / 60)).padStart(2, '0')}:${String(s % 60).padStart(2, '0')}`;
}

function toggleStepTimer(id, defaultSec) {
    if (!stepTimers[id]) stepTimers[id] = { remaining: defaultSec, interval: null, running: false };
    const t = stepTimers[id];
    const btn = document.getElementById(`timerBtn_${id}`);
    const disp = document.getElementById(`stepTimerDisplay_${id}`);

    if (t.running) {
        clearInterval(t.interval);
        t.running = false;
        btn.innerHTML = `<span class="material-symbols-outlined text-[16px]">play_arrow</span><span>Lanjutkan</span>`;
    } else {
        t.running = true;
        btn.innerHTML = `<span class="material-symbols-outlined text-[16px]">pause</span><span>Jeda</span>`;
        t.interval = setInterval(() => {
            if (t.remaining > 0) {
                t.remaining--;
                disp.textContent = formatTime(t.remaining);
            } else {
                clearInterval(t.interval);
                t.running = false;
                btn.innerHTML = `<span class="material-symbols-outlined text-[16px]">done</span><span>Selesai!</span>`;
                showToast(`Timer langkah ${id} selesai!`);
            }
        }, 1000);
    }
}

function resetStepTimer(id, defaultSec) {
    if (stepTimers[id]) {
        clearInterval(stepTimers[id].interval);
        stepTimers[id].remaining = defaultSec;
        stepTimers[id].running = false;
    }
    const btn = document.getElementById(`timerBtn_${id}`);
    const disp = document.getElementById(`stepTimerDisplay_${id}`);
    if (btn) btn.innerHTML = `<span class="material-symbols-outlined text-[16px]">play_arrow</span><span>Mulai Timer</span>`;
    if (disp) disp.textContent = formatTime(defaultSec);
}

// ========== 5. COOKING MODAL ==========
let currentStepIdx = 0;
let modalTimerRemaining = 0;
let modalTimerInterval = null;
let modalTimerRunning = false;

function openCookingModal() {
    document.getElementById('cookingModalOverlay').classList.remove('hidden');
    document.getElementById('cookingModalOverlay').classList.add('flex');
    currentStepIdx = 0;
    loadModalStep(0);
}
function closeCookingModal() {
    document.getElementById('cookingModalOverlay').classList.add('hidden');
    document.getElementById('cookingModalOverlay').classList.remove('flex');
    if (modalTimerInterval) clearInterval(modalTimerInterval);
    modalTimerRunning = false;
}

function loadModalStep(idx) {
    const d = cookingStepsData[idx];
    if (!d) return;
    document.getElementById('modalStepIndicatorText').textContent = `Langkah ${d.step} dari ${cookingStepsData.length}`;
    document.getElementById('modalProgressBar').style.width = `${(d.step / cookingStepsData.length) * 100}%`;
    document.getElementById('modalMobileCounter').textContent = `${d.step} / ${cookingStepsData.length}`;
    document.getElementById('modalCurrentStepHeader').textContent = `Langkah ${d.step}`;
    document.getElementById('modalInstructionTitle').textContent = d.title;
    document.getElementById('modalInstructionDetail').textContent = d.detail;

    const prev = document.getElementById('modalPrevBtn');
    const next = document.getElementById('modalNextBtn');
    prev.classList.toggle('opacity-50', idx === 0);

    if (idx === cookingStepsData.length - 1) {
        next.innerHTML = `<span>Selesai! 🎉</span><span class="material-symbols-outlined text-[20px]">celebration</span>`;
    } else {
        next.innerHTML = `<span>Tandai Selesai &amp; Lanjut</span><span class="material-symbols-outlined text-[20px]">arrow_forward</span>`;
    }

    const timerBox = document.getElementById('modalTimerBox');
    if (d.timerSeconds > 0) {
        timerBox.style.display = 'flex';
        document.getElementById('modalTimerLabel').textContent = d.timerLabel;
        if (modalTimerInterval) clearInterval(modalTimerInterval);
        modalTimerRunning = false;
        modalTimerRemaining = d.timerSeconds;
        document.getElementById('modalTimerCount').textContent = formatTime(modalTimerRemaining);
        document.getElementById('modalTimerControlBtn').innerHTML = `<span class="material-symbols-outlined text-[18px]">play_arrow</span><span>Mulai Timer</span>`;
    } else {
        timerBox.style.display = 'none';
    }
}

function nextCookingStep() {
    if (currentStepIdx < cookingStepsData.length - 1) {
        currentStepIdx++;
        loadModalStep(currentStepIdx);
    } else {
        closeCookingModal();
        showToast('Selamat! Resep selesai dimasak!');
    }
}
function prevCookingStep() {
    if (currentStepIdx > 0) {
        currentStepIdx--;
        loadModalStep(currentStepIdx);
    }
}
function toggleModalTimer() {
    const btn = document.getElementById('modalTimerControlBtn');
    const disp = document.getElementById('modalTimerCount');
    if (modalTimerRunning) {
        clearInterval(modalTimerInterval);
        modalTimerRunning = false;
        btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">play_arrow</span><span>Lanjutkan</span>`;
    } else {
        modalTimerRunning = true;
        btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">pause</span><span>Jeda</span>`;
        modalTimerInterval = setInterval(() => {
            if (modalTimerRemaining > 0) {
                modalTimerRemaining--;
                disp.textContent = formatTime(modalTimerRemaining);
            } else {
                clearInterval(modalTimerInterval);
                modalTimerRunning = false;
                btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">done</span><span>Selesai!</span>`;
                showToast('Timer selesai!');
            }
        }, 1000);
    }
}
function resetModalTimer() {
    const d = cookingStepsData[currentStepIdx];
    if (!d || !d.timerSeconds) return;
    if (modalTimerInterval) clearInterval(modalTimerInterval);
    modalTimerRunning = false;
    modalTimerRemaining = d.timerSeconds;
    document.getElementById('modalTimerCount').textContent = formatTime(modalTimerRemaining);
    document.getElementById('modalTimerControlBtn').innerHTML = `<span class="material-symbols-outlined text-[18px]">play_arrow</span><span>Mulai Timer</span>`;
}

// ========== 6. RATING ==========
let userRating = {{ $userRating->rating ?? 5 }};
const ratingLabels = ['', '1 Bintang', '2 Bintang', '3 Bintang', '4 Bintang', '5 Bintang (Sempurna)'];

function setRating(val) {
    userRating = val;
    document.querySelectorAll('#starRatingSelector .star-btn').forEach((btn, idx) => {
        const star = btn.querySelector('span');
        if (idx < val) {
            star.classList.add('text-on-tertiary-container');
            star.classList.remove('text-outline');
            star.style.fontVariationSettings = "'FILL' 1";
        } else {
            star.classList.remove('text-on-tertiary-container');
            star.classList.add('text-outline');
            star.style.fontVariationSettings = "'FILL' 0";
        }
    });
    document.getElementById('selectedRatingText').textContent = ratingLabels[val];
    const input = document.getElementById('ratingInput');
    if (input) input.value = val;
}

// ========== 7. INIT ==========
document.addEventListener('DOMContentLoaded', () => {
    renderIngredients();
    setRating(userRating);
});
renderIngredients();
setRating(userRating);
</script>