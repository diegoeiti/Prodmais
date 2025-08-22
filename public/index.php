<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prodmais - Dashboard de Produção Científica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="data:,">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Prodmais - UMC</a>
            <a href="admin.php" class="btn btn-sm btn-outline-light">Área Administrativa</a>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <h1 class="mb-4">Dashboard de Produção Científica</h1>

        <!-- Filtros -->
        <div class="row g-3 mb-4 p-3 border rounded bg-light">
            <div class="col-md-4">
                <label for="filter-program" class="form-label">Programa de Pós-Graduação</label>
                <select id="filter-program" class="form-select">
                    <option value="" selected>Todos</option>
                    <option value="Biotecnologia">Biotecnologia</option>
                    <option value="Engenharia Biomédica">Engenharia Biomédica</option>
                    <option value="Políticas Públicas">Políticas Públicas</option>
                    <option value="Ciência e Tecnologia em Saúde">Ciência e Tecnologia em Saúde</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="filter-type" class="form-label">Tipo de Produção</label>
                <select id="filter-type" class="form-select">
                    <option value="" selected>Todos</option>
                    <option value="Artigo Publicado">Artigo Publicado</option>
                    <!-- Adicionar outros tipos conforme o parser for evoluindo -->
                </select>
            </div>
            <div class="col-md-2">
                <label for="filter-year" class="form-label">Ano</label>
                <input type="number" id="filter-year" class="form-control" placeholder="Ex: 2023">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button id="btn-filter" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </div>

        <!-- Resultados -->
        <div class="row">
            <div class="col-12">
                <div id="loading" class="text-center" style="display: none;">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Carregando...</span>
                    </div>
                </div>
                <div id="results-summary" class="mb-2"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Pesquisador</th>
                                <th>Ano</th>
                                <th>Tipo</th>
                                <th>DOI</th>
                            </tr>
                        </thead>
                        <tbody id="results-table-body"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
