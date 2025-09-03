
# Prodmais - Análise de Produção Científica

## Exemplos de telas

### Tela de Login
![Login](img/login.png)
*Acesso institucional restrito, layout moderno e seguro, integração com LDAP ou administradores locais.*

### Área Administrativa
![Área Administrativa](img/area-administrativa.png)
*Upload de arquivos Lattes (XML/PDF), expurgo de logs, visualização dos acessos e controle de indexação.*

### Dashboard de Produção Científica
![Dashboard de Produção](img/dashboard-producao.png)
*Visualização agregada dos dados indexados, filtros avançados, gráficos e relatórios para análise institucional.*

Esta aplicação foi desenvolvida para consolidar, analisar e fornecer uma interface de visualização para a produção científica de programas de pós-graduação, utilizando dados da Plataforma Lattes, ORCID e OpenAlex.

A arquitetura é dividida em duas partes principais:
1.  **Script de Indexação (CLI):** Um processo de backend que lê, processa e indexa os dados no Elasticsearch.
2.  **Aplicação Web:** Uma interface de usuário rápida e responsiva para consultar e visualizar os dados indexados.

---


## Requisitos para rodar o sistema

- **PHP 8.2+** com as extensões: `php-xml`, `php-curl`, `php-sqlite3` habilitadas
- **Composer** (dependências PHP)
- **Elasticsearch 8.10+ ou superior** (recomendado >= 9.1.2)
- **Servidor web** (Apache, Nginx ou embutido do PHP)
- **Permissões de escrita** para os diretórios `data/` e `data/logs.sqlite`

---


## Instalação

1. Clone ou baixe o projeto:
    ```powershell
    git clone [URL_DO_REPOSITORIO]
    cd Prodmais
    ```

2. Instale as dependências PHP:
    ```powershell
    composer install
    ```

3. Configure o Elasticsearch:
    - Instale e inicie o Elasticsearch localmente (veja https://www.elastic.co/downloads/elasticsearch)
    - Certifique-se de que está rodando em `localhost:9200` ou ajuste o host em `config/config.php`.
    - Libere espaço em disco para evitar bloqueios de escrita.

4. Configure a aplicação:
    - Edite `config/config.php` para ajustar o host do Elasticsearch e o nome do índice.

5. Adicione os arquivos Lattes (XML ou PDF) em `data/lattes_xml/`.

---


## Comandos para rodar o sistema

**Servidor web embutido do PHP:**
```powershell
php -S localhost:8000 -t public
```

**Área administrativa:**
Abra no navegador: [http://localhost:8000/admin.php](http://localhost:8000/admin.php)

**Indexação dos currículos:**
```powershell
php bin/indexer.php
```

**Remover bloqueio de escrita do Elasticsearch (se necessário):**
```powershell
Invoke-WebRequest -Method PUT -Uri "http://localhost:9200/prodmais_cientifica/_settings" -ContentType "application/json" -Body '{"index.blocks.read_only_allow_delete": null}'
```

## Dicas de hospedagem

- O Elasticsearch exige recursos de memória e disco, não sendo suportado em hospedagens gratuitas tradicionais (Vercel, Netlify, Heroku Free, etc).
- Para produção institucional, utilize VPS, cloud universitária ou servidor próprio.
- Para testes, o servidor embutido do PHP e Elasticsearch local são suficientes.

## Segurança

- Nunca compartilhe senhas reais em texto plano.
- Use login institucional (LDAP) ou cadastre administradores locais em `public/login.php`.
- Recomenda-se uso de HTTPS/TLS em produção.

## Resumo do fluxo

1. Instale dependências e configure ambiente.
2. Inicie o Elasticsearch e o servidor web.
3. Faça login na área administrativa.
4. Faça upload dos arquivos Lattes.
5. Execute o script de indexação.
6. Consulte e analise os dados via dashboard.

---

Para dúvidas ou problemas, consulte a documentação oficial do Elasticsearch ou entre em contato com o suporte institucional.

---

## Instalação e Execução (Ambiente UMC / XAMPP)

Estas instruções são específicas para o ambiente da UMC, que utiliza XAMPP e pode não ter o `php.exe` no caminho padrão do sistema.

**1. Verifique a Instalação do XAMPP:**

Certifique-se de que o XAMPP está instalado. A principal dificuldade encontrada foi a ausência do `php.exe` no `PATH` do sistema ou até mesmo na pasta `C:\xampp\php`.

**2. Encontrando o Executável do PHP:**

Se o comando `php` não for reconhecido no terminal:
- Procure por `php.exe` na pasta de instalação do XAMPP (geralmente `C:\xampp\php`).
- Se `php.exe` não for encontrado, a instalação do XAMPP pode estar corrompida ou ser uma versão que não inclui o CLI (Command Line Interface) do PHP. Neste caso, a reinstalação do XAMPP é recomendada.

**3. Executando o Servidor Web Embutido do PHP:**

Para facilitar, você pode usar o servidor web que vem com o PHP, sem a necessidade de configurar o Apache.

Abra um terminal (CMD ou PowerShell) na raiz do projeto (`C:\app3\Prodmais`) e execute o seguinte comando, substituindo `C:\caminho\para\seu\php.exe` pelo caminho completo que você encontrou:

```bash
# Exemplo de comando
C:\xampp\php\php.exe -S localhost:8000 -t public
```

**4. Acesse a Aplicação:**

Com o servidor em execução, abra seu navegador e acesse `http://localhost:8000`.
Para a área administrativa, acesse `http://localhost:8000/admin.php`.

**5. Executando a Indexação (Importante):**

Para que os currículos apareçam na busca, você precisa executar o script de indexação. Use o mesmo caminho completo para o PHP:

```bash
C:\xampp\php\php.exe bin/indexer.php
```