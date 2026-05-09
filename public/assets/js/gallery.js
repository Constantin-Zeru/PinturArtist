document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('gallerySearch');
    const jobFilter = document.getElementById('galleryJobFilter');
    const phaseFilter = document.getElementById('galleryPhaseFilter');
    const typeFilter = document.getElementById('galleryTypeFilter');
    const resetButton = document.getElementById('galleryReset');
    const counter = document.getElementById('galleryCounter');
    const items = Array.from(document.querySelectorAll('.gallery-item'));

    const modalTitle = document.getElementById('galleryModalTitle');
    const modalComment = document.getElementById('galleryModalComment');
    const modalBody = document.getElementById('galleryModalBody');

    function applyFilters() {
        const search = (searchInput?.value || '').trim().toLowerCase();
        const job = jobFilter?.value || '';
        const phase = phaseFilter?.value || '';
        const type = typeFilter?.value || '';

        let visibleCount = 0;

        items.forEach((item) => {
            const itemSearch = item.dataset.search || '';
            const itemJob = item.dataset.job || '';
            const itemPhase = item.dataset.phase || '';
            const itemType = item.dataset.type || '';

            const matchesSearch = !search || itemSearch.includes(search);
            const matchesJob = !job || itemJob === job;
            const matchesPhase = !phase || itemPhase === phase;
            const matchesType = !type || itemType === type;

            const show = matchesSearch && matchesJob && matchesPhase && matchesType;

            item.style.display = show ? '' : 'none';

            if (show) visibleCount++;
        });

        if (counter) {
            counter.textContent = `Mostrando ${visibleCount} elementos`;
        }
    }

    document.querySelectorAll('.gallery-open').forEach((button) => {
        button.addEventListener('click', function () {
            const url = this.dataset.url;
            const type = this.dataset.type;
            const title = this.dataset.title || 'Vista previa';
            const comment = this.dataset.comment || '';

            if (modalTitle) modalTitle.textContent = title;
            if (modalComment) modalComment.textContent = comment;

            if (modalBody) {
                if (type === 'video') {
                    modalBody.innerHTML = `
                        <video controls class="w-100 rounded" style="max-height: 70vh;">
                            <source src="${url}">
                            Tu navegador no soporta vídeo.
                        </video>
                    `;
                } else {
                    modalBody.innerHTML = `
                        <img src="${url}" alt="Vista previa" class="img-fluid rounded" style="max-height: 70vh;">
                    `;
                }
            }
        });
    });

    searchInput?.addEventListener('input', applyFilters);
    jobFilter?.addEventListener('change', applyFilters);
    phaseFilter?.addEventListener('change', applyFilters);
    typeFilter?.addEventListener('change', applyFilters);

    resetButton?.addEventListener('click', function () {
        if (searchInput) searchInput.value = '';
        if (jobFilter) jobFilter.value = '';
        if (phaseFilter) phaseFilter.value = '';
        if (typeFilter) typeFilter.value = '';
        applyFilters();
    });

    applyFilters();
});