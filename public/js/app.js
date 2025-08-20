document.addEventListener('DOMContentLoaded', () => {
    const filterBtn = document.getElementById('btn-filter');
    
    const fetchResults = async () => {
        const program = document.getElementById('filter-program').value;
        const type = document.getElementById('filter-type').value;
        const year = document.getElementById('filter-year').value;

        const loadingIndicator = document.getElementById('loading');
        const tableBody = document.getElementById('results-table-body');
        const resultsSummary = document.getElementById('results-summary');

        // Monta a URL da API com os parâmetros de filtro
        const queryParams = new URLSearchParams({ program, type, year }).toString();
        const apiUrl = `api/search.php?${queryParams}`;

        // Limpa resultados anteriores e mostra o loading
        tableBody.innerHTML = '';
        resultsSummary.innerHTML = '';
        loadingIndicator.style.display = 'block';

        try {
            const response = await fetch(apiUrl);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();

            // Esconde o loading
            loadingIndicator.style.display = 'none';

            if (data.hits && data.hits.hits.length > 0) {
                resultsSummary.textContent = `Exibindo ${data.hits.hits.length} de ${data.hits.total.value} resultados.`;
                data.hits.hits.forEach(hit => {
                    const doc = hit._source;
                    const row = `<tr>
                        <td>${doc.title}</td>
                        <td>${doc.researcher_name}</td>
                        <td>${doc.year}</td>
                        <td>${doc.type}</td>
                        <td>${doc.doi ? `<a href="https://doi.org/${doc.doi}" target="_blank">${doc.doi}</a>` : 'N/A'}</td>
                    </tr>`;
                    tableBody.innerHTML += row;
                });
            } else {
                resultsSummary.textContent = 'Nenhum resultado encontrado.';
            }

        } catch (error) {
            loadingIndicator.style.display = 'none';
            resultsSummary.innerHTML = `<div class="alert alert-danger">Erro ao buscar dados: ${error.message}</div>`;
            console.error('Fetch error:', error);
        }
    };

    filterBtn.addEventListener('click', fetchResults);

    // Carrega os resultados iniciais sem filtros
    fetchResults();
});
