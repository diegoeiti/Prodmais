<?php
// Futuramente, adicionar um sistema de login/senha aqui
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard de Produção Científica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <header class="text-center mb-4">
                    <h1 class="h3">Área Administrativa</h1>
                    <p class="text-muted">Atualização da Base de Dados Lattes</p>
                </header>

                <div class="card">
                    <div class="card-body">
                        <form action="api/upload_and_index.php" method="post" enctype="multipart/form-data" id="upload-form">
                            <div class="mb-3">
                                <label for="lattes_files" class="form-label">Selecione os arquivos (.xml ou .pdf)</label>
                                <input class="form-control" type="file" id="lattes_files" name="lattes_files[]" multiple required accept=".xml,.pdf">
                                <div class="form-text">Você pode selecionar múltiplos arquivos de uma vez.</div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Enviar e Atualizar Base de Dados</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="upload-status" class="mt-4"></div>

                <div class="text-center mt-4">
                    <a href="index.php">Voltar para a busca</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('upload-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const statusDiv = document.getElementById('upload-status');

            statusDiv.innerHTML = `<div class="alert alert-info">Enviando arquivos e iniciando a indexação... Isso pode levar alguns minutos. Por favor, aguarde.</div>`;

            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Erro do servidor: ${response.status} ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    let reportHtml = `
                    <div class="alert alert-success">
                        <strong>Processo Concluído!</strong><br>
                        <ul class="mb-0">
                            <li>Arquivos processados: ${data.processed_files}</li>
                            <li>Produções indexadas: ${data.indexed_productions}</li>
                        </ul>
                    </div>
                `;

                    if (data.files && data.files.length > 0) {
                        reportHtml += `<h5>Detalhes por Arquivo:</h5><ul class="list-group">`;
                        data.files.forEach(file => {
                            if (file.status === 'success') {
                                const productionsText = file.indexed === 1 ? 'produção indexada' : 'produções indexadas';
                                reportHtml += `<li class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">
                                ${file.name}
                                <span class="badge bg-primary rounded-pill">${file.indexed} ${productionsText}</span>
                            </li>`;
                            } else {
                                reportHtml += `<li class="list-group-item list-group-item-danger">
                                <strong>${file.name}</strong> - Erro: ${file.message}
                            </li>`;
                            }
                        });
                        reportHtml += `</ul>`;
                    }

                    statusDiv.innerHTML = reportHtml;
                })
                .catch(error => {
                    statusDiv.innerHTML = `<div class="alert alert-danger"><strong>Ocorreu um erro:</strong> ${error.message}</div>`;
                });
        });
    </script>
</body>

</html>