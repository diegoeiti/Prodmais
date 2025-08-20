# Prodmais - Análise de Produção Científica

Esta aplicação foi desenvolvida para consolidar, analisar e fornecer uma interface de visualização para a produção científica de programas de pós-graduação, utilizando dados da Plataforma Lattes, ORCID e OpenAlex.

A arquitetura é dividida em duas partes principais:
1.  **Script de Indexação (CLI):** Um processo de backend que lê, processa e indexa os dados no Elasticsearch.
2.  **Aplicação Web:** Uma interface de usuário rápida e responsiva para consultar e visualizar os dados indexados.

---

## Pré-requisitos

- **PHP 8.2+** com as extensões `php-xml` e `php-curl`.
- **Composer** (gerenciador de dependências para PHP). Se não estiver instalado globalmente, o projeto pode tentar usar uma cópia local (`composer.phar`).
- **Elasticsearch 8.10+** em execução e acessível pela aplicação.

---

## Instalação e Configuração

**1. Clone ou baixe o projeto:**

```bash
# git clone [URL_DO_REPOSITORIO]
# cd Prodmais
```

**2. Instale as dependências PHP:**

Execute o Composer na raiz do projeto. Isso irá baixar o cliente Elasticsearch e configurar o autoloader.

```bash
composer install
```

**3. Configure a Aplicação:**

Copie ou renomeie o arquivo `config/config.php` e ajuste as configurações conforme necessário.

- **`elasticsearch.hosts`**: Endereço do seu servidor Elasticsearch.
- **`app.index_name`**: Nome que será usado para o índice no Elasticsearch.

**4. Adicione os Dados do Lattes:**

Coloque os arquivos XML dos currículos Lattes que você deseja processar dentro do diretório `data/lattes_xml/`.

---

## Execução

**1. Execute o Script de Indexação:**

Este é o passo mais importante. Execute o script `indexer.php` a partir da linha de comando. Ele irá ler os arquivos XML, processá-los e enviar os dados para o Elasticsearch. Este processo pode levar algum tempo, dependendo do volume de dados.

```bash
php bin/indexer.php
```

Você deve executar este script periodicamente para manter os dados atualizados.

**2. Configure o Servidor Web:**

Configure seu servidor web (Apache, Nginx, etc.) para que a raiz do documento (`DocumentRoot`) aponte para o diretório `public/` do projeto.

Exemplo de configuração para Apache (Virtual Host):

```apache
<VirtualHost *:80>
    ServerName prodmais.local
    DocumentRoot "/caminho/para/o/projeto/Prodmais/public"
    <Directory "/caminho/para/o/projeto/Prodmais/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**3. Acesse a Aplicação:**

Após configurar o servidor, acesse a URL configurada (ex: `http://prodmais.local`) no seu navegador para ver o dashboard.