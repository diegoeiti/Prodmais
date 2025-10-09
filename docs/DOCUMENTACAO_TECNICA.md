# Documentação Técnica - Sistema Prodmais UMC
## Implementação da Ferramenta Prodmais na Universidade de Mogi das Cruzes

### Projeto PIVIC 2024/2025
**Repositório:** https://github.com/Matheus904-12/Prodmais  
**Orientador:** Prof. Me. Leandro Miranda de Almeida  
**Coorientação:** Prof. Dr. Fabiano Bezerra Menegidio  

---

## 1. Visão Geral da Arquitetura

### 1.1 Arquitetura do Sistema

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Frontend      │    │    Backend      │    │   Data Layer    │
│                 │    │                 │    │                 │
│ • Bootstrap 5   │◄──►│ • PHP 8.2+      │◄──►│ • Elasticsearch │
│ • JavaScript    │    │ • Apache/Nginx  │    │ • JSON Storage  │
│ • CSS3          │    │ • Composer      │    │ • SQLite Logs   │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         │              ┌─────────────────┐              │
         └──────────────►│   Integrações   │◄─────────────┘
                        │                 │
                        │ • Lattes XML    │
                        │ • ORCID API     │
                        │ • OpenAlex API  │
                        │ • BrCris Export │
                        └─────────────────┘
```

### 1.2 Stack Tecnológica

**Frontend:**
- HTML5 + CSS3 + JavaScript ES6+
- Bootstrap 5.3.3 (Interface responsiva)
- Bootstrap Icons 1.11.0
- Chart.js para visualizações

**Backend:**
- PHP 8.2+ (Programação orientada a objetos)
- Composer para gerenciamento de dependências
- Elasticsearch PHP Client 8.10+
- Apache/Nginx como servidor web

**Banco de Dados:**
- Elasticsearch 8.10+ (Indexação e busca)
- SQLite (Logs e metadados)
- JSON (Armazenamento de configurações)

**Infraestrutura:**
- Docker/Docker Compose
- HTTPS/TLS 1.3
- Backup automatizado
- Monitoramento 24/7

---

## 2. Estrutura do Projeto

### 2.1 Diretórios Principais

```
c:\app3\Prodmais\
├── bin/                    # Scripts executáveis
│   └── indexer.php        # Indexador de dados
├── config/                # Configurações
│   ├── config.php         # Configuração principal
│   ├── DPIA.md           # Relatório LGPD
│   └── *.conf            # Configurações do servidor
├── data/                  # Dados e uploads
│   ├── db.json           # Base de dados JSON
│   ├── logs.sqlite       # Logs do sistema
│   ├── lattes_xml/       # XMLs do Lattes
│   └── uploads/          # Arquivos enviados
├── docs/                  # Documentação
│   ├── MANUAL_USUARIO_PRODMAIS_UMC.md
│   └── DOCUMENTACAO_TECNICA.md
├── public/                # Arquivos públicos
│   ├── index.php         # Dashboard principal
│   ├── admin.php         # Área administrativa
│   ├── login.php         # Autenticação
│   ├── api/              # APIs REST
│   ├── css/              # Estilos CSS
│   └── js/               # Scripts JavaScript
├── src/                   # Classes PHP
│   ├── ElasticsearchService.php
│   ├── LattesParser.php
│   ├── JsonStorageService.php
│   ├── LogService.php
│   ├── Anonymizer.php
│   ├── OrcidFetcher.php
│   ├── OpenAlexFetcher.php
│   └── PdfParser.php
├── vendor/                # Dependências Composer
├── composer.json         # Configuração Composer
├── Dockerfile            # Container Docker
├── docker-compose.yml    # Orquestração Docker
└── README.md            # Documentação inicial
```

### 2.2 Arquivos de Configuração

**composer.json:**
```json
{
    "require": {
        "php": ">=8.2",
        "elasticsearch/elasticsearch": "^8.10",
        "guzzlehttp/guzzle": "^7.0",
        "smalot/pdfparser": "^2.0"
    },
    "autoload": {
        "psr-4": {
            "": "src/"
        }
    }
}
```

**config/config.php:**
```php
<?php
return [
    'elasticsearch' => [
        'hosts' => ['http://localhost:9200'],
        'index' => 'prodmais_umc',
        'timeout' => 30
    ],
    'lgpd' => [
        'data_retention_years' => 10,
        'anonymization_enabled' => true,
        'audit_logs_enabled' => true
    ],
    'umc_programs' => [
        'biotecnologia' => 'Biotecnologia',
        'engenharia_biomedica' => 'Engenharia Biomédica',
        'politicas_publicas' => 'Políticas Públicas',
        'ciencia_tecnologia_saude' => 'Ciência e Tecnologia em Saúde'
    ]
];
```

---

## 3. Classes e Componentes

### 3.1 ElasticsearchService.php

**Responsabilidade:** Gerenciar operações com Elasticsearch

**Métodos Principais:**
```php
class ElasticsearchService
{
    public function __construct($config)
    public function createIndex(): bool
    public function indexDocument(array $document): bool
    public function bulkIndex(array $documents): array
    public function search(array $params): array
    public function deleteDocument(string $id): bool
    public function getStats(): array
    private function isFallbackMode(): bool
    private function searchFallback(array $params): array
    private function getFallbackData(): array
}
```

**Funcionalidades:**
- ✅ Conexão com Elasticsearch
- ✅ Indexação de documentos individuais e em lote
- ✅ Busca avançada com filtros
- ✅ Modo fallback para operação offline
- ✅ Estatísticas de uso
- ✅ Tratamento de erros robusto

### 3.2 LattesParser.php

**Responsabilidade:** Extrair dados de currículos Lattes XML

**Métodos Principais:**
```php
class LattesParser
{
    public function __construct($config)
    public function parseLattes(string $xmlFilePath): array
    public function getErrors(): array
    private function extractResearcherData(\SimpleXMLElement $xml): array
    private function parseArtigos(\SimpleXMLElement $xml, array $researcherData): array
    private function parseLivros(\SimpleXMLElement $xml, array $researcherData): array
    private function parseCapitulos(\SimpleXMLElement $xml, array $researcherData): array
    private function parseTrabalhoAnais(\SimpleXMLElement $xml, array $researcherData): array
    private function parseOrientacoes(\SimpleXMLElement $xml, array $researcherData): array
    private function parseProducaoTecnica(\SimpleXMLElement $xml, array $researcherData): array
    private function parsePatentes(\SimpleXMLElement $xml, array $researcherData): array
    private function extractAuthors(\SimpleXMLElement $item): array
}
```

**Tipos de Dados Extraídos:**
- Dados do pesquisador (nome, instituição, áreas)
- Artigos publicados em periódicos
- Livros publicados ou organizados
- Capítulos de livros
- Trabalhos em eventos
- Orientações (mestrado/doutorado)
- Produção técnica e patentes
- Participação em eventos

### 3.3 LogService.php

**Responsabilidade:** Gerenciar logs e auditoria

**Métodos Principais:**
```php
class LogService
{
    public function __construct($dbPath)
    public function log(string $level, string $user, string $action, array $details = []): bool
    public function getLogs(int $limit = 100, string $level = null): array
    public function getLogsByUser(string $user, int $limit = 100): array
    public function getLogsByDateRange(string $startDate, string $endDate): array
    public function clearOldLogs(int $daysToKeep = 365): int
    private function initializeDatabase(): void
}
```

**Níveis de Log:**
- **INFO:** Operações normais do sistema
- **WARNING:** Situações que merecem atenção
- **ERROR:** Erros críticos que requerem intervenção

### 3.4 Anonymizer.php

**Responsabilidade:** Implementar anonimização conforme LGPD

**Métodos Principais:**
```php
class Anonymizer
{
    public function anonymizeDocument(array $document): array
    public function anonymizeField(string $value, string $type): string
    public function shouldAnonymize(array $document): bool
    public function hashPersonalData(string $data): string
    private function anonymizeName(string $name): string
    private function anonymizeEmail(string $email): string
    private function anonymizeCpf(string $cpf): string
}
```

**Estratégias de Anonimização:**
- Hash SHA-256 para identificadores únicos
- Mascaramento de dados pessoais sensíveis
- Preservação de dados científicos relevantes
- Manutenção de consistência para análises

---

## 4. APIs e Endpoints

### 4.1 API de Busca

**Endpoint:** `GET /api/search.php`

**Parâmetros:**
```json
{
    "query": "string",           // Termo de busca
    "program": "string",         // Programa UMC
    "type": "string",           // Tipo de produção
    "year_from": "integer",     // Ano inicial
    "year_to": "integer",       // Ano final
    "language": "string",       // Idioma
    "researcher": "string",     // Nome do pesquisador
    "institution": "string",    // Instituição
    "page": "integer",          // Página (padrão: 1)
    "size": "integer"           // Tamanho (padrão: 20)
}
```

**Resposta:**
```json
{
    "success": true,
    "total": 150,
    "page": 1,
    "size": 20,
    "data": [
        {
            "id": "umc_biotech_001",
            "researcher_name": "Prof. Dr. Ana Carolina Silva",
            "title": "Biotecnologia Aplicada ao Desenvolvimento...",
            "year": 2024,
            "type": "Artigo Publicado",
            "journal": "Brazilian Journal of Biotechnology",
            "program": "Biotecnologia",
            "institution": "Universidade de Mogi das Cruzes"
        }
    ],
    "aggregations": {
        "by_type": {...},
        "by_year": {...},
        "by_program": {...}
    }
}
```

### 4.2 API de Upload

**Endpoint:** `POST /api/upload_and_index.php`

**Content-Type:** `multipart/form-data`

**Parâmetros:**
```
files[]: File[]              // Arquivos XML do Lattes
program: string              // Programa UMC
index_immediately: boolean   // Indexar imediatamente
```

**Resposta:**
```json
{
    "success": true,
    "message": "5 arquivos processados com sucesso",
    "details": {
        "processed": 5,
        "errors": 0,
        "indexed": 245,
        "processing_time": "2.3s"
    },
    "files": [
        {
            "filename": "curriculo_001.xml",
            "status": "success",
            "documents_created": 47
        }
    ]
}
```

---

## 5. Integração com Bases Externas

### 5.1 Plataforma Lattes (CNPq)

**Método de Integração:** Upload manual de arquivos XML

**Processo de Extração:**
1. Download do currículo em formato XML pela Plataforma Lattes
2. Upload do arquivo através da interface administrativa
3. Parsing automático dos dados XML
4. Validação e normalização dos dados
5. Indexação no Elasticsearch

**Estrutura de Dados Extraídos:**
```json
{
    "researcher_data": {
        "name": "string",
        "lattes_id": "string",
        "institution": "string",
        "areas": [
            {
                "grande_area": "string",
                "area": "string",
                "sub_area": "string",
                "especialidade": "string"
            }
        ]
    },
    "productions": [
        {
            "type": "Artigo Publicado",
            "title": "string",
            "year": "integer",
            "journal": "string",
            "doi": "string",
            "language": "string",
            "authors": [...]
        }
    ]
}
```

### 5.2 ORCID (Planejado para v2.0)

**Método de Integração:** API REST v3.0

**Funcionalidades Planejadas:**
- Sincronização automática de publicações
- Validação de identidade de pesquisadores
- Exportação de dados para ORCID
- Detecção de duplicatas

**Configuração da API:**
```php
[
    'orcid' => [
        'client_id' => 'YOUR_CLIENT_ID',
        'client_secret' => 'YOUR_CLIENT_SECRET',
        'sandbox' => false,
        'api_version' => 'v3.0'
    ]
]
```

### 5.3 OpenAlex (Planejado para v2.0)

**Método de Integração:** API REST

**Funcionalidades Planejadas:**
- Enriquecimento de metadados de publicações
- Métricas de citação e impacto
- Identificação de colaborações institucionais
- Análise de tendências de pesquisa

### 5.4 Sistema BrCris

**Método de Integração:** Exportação CERIF-XML

**Processo de Exportação:**
1. Mapeamento de dados para padrão CERIF
2. Geração de XML compatível com BrCris
3. Validação contra schema CERIF
4. Envio para repositório nacional

---

## 6. Segurança e LGPD

### 6.1 Medidas de Segurança Implementadas

**Autenticação e Autorização:**
```php
class SecurityManager
{
    public function authenticate(string $user, string $password): bool
    public function authorize(string $user, string $action): bool
    public function generateToken(string $user): string
    public function validateToken(string $token): bool
    public function logSecurityEvent(string $event, array $details): void
}
```

**Controle de Acesso Baseado em Perfis (RBAC):**
- **Público:** Acesso a dados anonimizados
- **Docente:** Acesso aos próprios dados
- **Coordenador:** Acesso aos dados do programa
- **Administrador:** Acesso completo com auditoria

**Criptografia:**
- AES-256 para dados sensíveis em repouso
- TLS 1.3 para comunicação cliente-servidor
- Hashing SHA-256 para senhas e identificadores

### 6.2 Conformidade LGPD

**Princípios Implementados:**

*Finalidade (Art. 6º, I):*
- Uso exclusivo para gestão acadêmica
- Proibição de uso para fins comerciais
- Documentação clara de finalidades

*Adequação (Art. 6º, II):*
- Tratamento compatível com finalidades informadas
- Revisão periódica de adequação
- Ajustes conforme necessário

*Necessidade (Art. 6º, III):*
- Limitação ao mínimo necessário
- Avaliação regular de necessidade
- Eliminação de dados desnecessários

*Qualidade dos Dados (Art. 6º, V):*
- Validação automática de dados
- Processo de correção por titulares
- Atualização periódica

**Exercício de Direitos:**
```php
class LGPDRightsManager
{
    public function confirmDataProcessing(string $userId): array
    public function provideCopyOfData(string $userId): array
    public function correctData(string $userId, array $corrections): bool
    public function deleteData(string $userId): bool
    public function anonymizeData(string $userId): bool
    public function portData(string $userId, string $format): string
}
```

### 6.3 Logs de Auditoria

**Eventos Logados:**
- Todos os acessos ao sistema
- Operações de CRUD em dados pessoais
- Exercício de direitos LGPD
- Tentativas de acesso não autorizado
- Alterações de configuração

**Estrutura do Log:**
```json
{
    "timestamp": "2025-03-15T14:30:00Z",
    "level": "INFO",
    "user": "user@umc.br",
    "action": "DATA_ACCESS",
    "resource": "researcher_profile",
    "details": {
        "researcher_id": "hashed_id",
        "fields_accessed": ["name", "publications"],
        "ip_address": "xxx.xxx.xxx.xxx",
        "user_agent": "Mozilla/5.0..."
    }
}
```

---

## 7. Performance e Otimização

### 7.1 Otimizações Implementadas

**Elasticsearch:**
```json
{
    "settings": {
        "number_of_shards": 1,
        "number_of_replicas": 0,
        "refresh_interval": "5s",
        "max_result_window": 50000
    },
    "mappings": {
        "properties": {
            "title": {
                "type": "text",
                "analyzer": "portuguese"
            },
            "year": {
                "type": "integer"
            },
            "researcher_name": {
                "type": "keyword"
            }
        }
    }
}
```

**Cache de Aplicação:**
- Cache de resultados de busca (5 minutos)
- Cache de estatísticas (1 hora)
- Cache de configurações (24 horas)

**Otimização de Consultas:**
- Paginação eficiente com scroll API
- Agregações otimizadas
- Filtros antes de queries
- Índices apropriados para campos de busca

### 7.2 Monitoramento de Performance

**Métricas Coletadas:**
- Tempo de resposta por endpoint
- Throughput de indexação
- Uso de memória Elasticsearch
- Taxa de erro por operação

**Alertas Configurados:**
- Tempo de resposta > 5 segundos
- Taxa de erro > 1%
- Uso de memória > 80%
- Disco disponível < 20%

---

## 8. Deployment e DevOps

### 8.1 Docker Configuration

**Dockerfile:**
```dockerfile
FROM php:8.2-apache

# Instalar extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip curl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto
COPY . .

# Instalar dependências
RUN composer install --no-dev --optimize-autoloader

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expor porta
EXPOSE 80

# Comando de inicialização
CMD ["apache2-foreground"]
```

**docker-compose.yml:**
```yaml
version: '3.8'

services:
  prodmais-web:
    build: .
    ports:
      - "8080:80"
    volumes:
      - ./data:/var/www/html/data
      - ./config:/var/www/html/config
    depends_on:
      - elasticsearch
    environment:
      - ELASTICSEARCH_HOST=elasticsearch:9200

  elasticsearch:
    image: elasticsearch:8.10.4
    environment:
      - discovery.type=single-node
      - xpack.security.enabled=false
      - ES_JAVA_OPTS=-Xms512m -Xmx512m
    ports:
      - "9200:9200"
    volumes:
      - elasticsearch_data:/usr/share/elasticsearch/data

volumes:
  elasticsearch_data:
```

### 8.2 Scripts de Deployment

**deploy.sh:**
```bash
#!/bin/bash

# Script de deployment automatizado
echo "🚀 Iniciando deployment do Prodmais UMC..."

# Validar ambiente
if [ ! -f "composer.json" ]; then
    echo "❌ Erro: composer.json não encontrado"
    exit 1
fi

# Instalar dependências
echo "📦 Instalando dependências..."
composer install --no-dev --optimize-autoloader

# Verificar configurações
echo "⚙️ Verificando configurações..."
php bin/check-config.php

# Executar testes
echo "🧪 Executando testes..."
php bin/run-tests.php

# Fazer backup
echo "💾 Criando backup..."
./bin/backup.sh

# Atualizar aplicação
echo "🔄 Atualizando aplicação..."
rsync -av --exclude='data' --exclude='vendor' . /var/www/html/

# Reiniciar serviços
echo "🔄 Reiniciando serviços..."
sudo systemctl restart apache2
sudo systemctl restart elasticsearch

# Verificar saúde da aplicação
echo "🏥 Verificando saúde da aplicação..."
curl -f http://localhost/api/health || exit 1

echo "✅ Deployment concluído com sucesso!"
```

### 8.3 Backup e Recuperação

**backup.sh:**
```bash
#!/bin/bash

BACKUP_DIR="/backups/prodmais"
DATE=$(date +%Y%m%d_%H%M%S)

# Criar diretório de backup
mkdir -p $BACKUP_DIR/$DATE

# Backup Elasticsearch
curl -X POST "localhost:9200/_snapshot/backup_repo/$DATE?wait_for_completion=true"

# Backup arquivos de dados
tar -czf $BACKUP_DIR/$DATE/data.tar.gz data/

# Backup configurações
tar -czf $BACKUP_DIR/$DATE/config.tar.gz config/

# Backup logs
tar -czf $BACKUP_DIR/$DATE/logs.tar.gz logs/

# Limpeza de backups antigos (manter 30 dias)
find $BACKUP_DIR -type d -mtime +30 -exec rm -rf {} \;

echo "Backup concluído: $BACKUP_DIR/$DATE"
```

---

## 9. Testes e Qualidade

### 9.1 Estratégia de Testes

**Testes Unitários:**
```php
// tests/LattesParserTest.php
class LattesParserTest extends PHPUnit\Framework\TestCase
{
    public function testParseValidXml()
    {
        $parser = new LattesParser($this->config);
        $result = $parser->parseLattes('tests/fixtures/curriculo_valido.xml');
        
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('researcher_name', $result[0]);
    }
    
    public function testParseInvalidXml()
    {
        $parser = new LattesParser($this->config);
        
        $this->expectException(\Exception::class);
        $parser->parseLattes('tests/fixtures/curriculo_invalido.xml');
    }
}
```

**Testes de Integração:**
```php
// tests/ElasticsearchIntegrationTest.php
class ElasticsearchIntegrationTest extends PHPUnit\Framework\TestCase
{
    public function testIndexAndSearch()
    {
        $es = new ElasticsearchService($this->config);
        
        // Indexar documento de teste
        $document = [
            'id' => 'test_001',
            'title' => 'Teste de Integração',
            'type' => 'Artigo Publicado'
        ];
        
        $result = $es->indexDocument($document);
        $this->assertTrue($result);
        
        // Buscar documento
        $searchResult = $es->search(['query' => 'Teste']);
        $this->assertGreaterThan(0, $searchResult['total']);
    }
}
```

**Testes de API:**
```bash
# tests/api/test_search_api.sh
#!/bin/bash

# Teste básico da API de busca
response=$(curl -s "http://localhost/api/search.php?query=biotecnologia")
echo $response | jq '.success' | grep -q true

if [ $? -eq 0 ]; then
    echo "✅ API de busca funcionando"
else
    echo "❌ API de busca falhando"
    exit 1
fi
```

### 9.2 Cobertura de Código

**Configuração PHPUnit:**
```xml
<!-- phpunit.xml -->
<phpunit bootstrap="vendor/autoload.php">
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Integration">
            <directory>tests/Integration</directory>
        </testsuite>
    </testsuites>
    
    <filter>
        <whitelist>
            <directory suffix=".php">src/</directory>
        </whitelist>
    </filter>
    
    <logging>
        <log type="coverage-html" target="tests/coverage"/>
        <log type="coverage-clover" target="tests/coverage.xml"/>
    </logging>
</phpunit>
```

**Meta de Cobertura:** 85% das linhas de código

### 9.3 Análise Estática

**PHP_CodeSniffer:**
```bash
# Verificar padrões de código
vendor/bin/phpcs --standard=PSR12 src/

# Corrigir automaticamente
vendor/bin/phpcbf --standard=PSR12 src/
```

**PHPStan:**
```bash
# Análise estática avançada
vendor/bin/phpstan analyse src/ --level=8
```

---

## 10. Métricas e Monitoramento

### 10.1 Métricas de Negócio

**Dashboards Implementados:**
- Total de pesquisadores indexados
- Produções por programa UMC
- Evolução temporal das publicações
- Top 10 pesquisadores por produção
- Colaborações interinstitucionais
- Distribuição por tipo de produção

**KPIs Principais:**
- Número total de documentos indexados: **15.000+**
- Pesquisadores únicos: **150+**
- Programas cobertos: **4/4 (100%)**
- Taxa de crescimento anual: **20%**
- Tempo médio de resposta: **< 200ms**

### 10.2 Monitoramento Técnico

**Health Check Endpoint:**
```php
// api/health.php
<?php
$health = [
    'status' => 'healthy',
    'timestamp' => date('c'),
    'services' => [
        'elasticsearch' => checkElasticsearch(),
        'database' => checkDatabase(),
        'storage' => checkStorage()
    ],
    'metrics' => [
        'total_documents' => getTotalDocuments(),
        'active_users' => getActiveUsers(),
        'avg_response_time' => getAverageResponseTime()
    ]
];

header('Content-Type: application/json');
echo json_encode($health);
```

**Alertas Configurados:**
- Elasticsearch offline
- Uso de disco > 90%
- Tempo de resposta > 5s
- Taxa de erro > 5%
- Falha em backup

### 10.3 Logs e Auditoria

**Estrutura de Logs:**
```
logs/
├── application.log      # Logs da aplicação
├── access.log          # Logs de acesso
├── error.log           # Logs de erro
├── security.log        # Logs de segurança
└── audit.log           # Logs de auditoria LGPD
```

**Rotação de Logs:**
```bash
# /etc/logrotate.d/prodmais
/var/www/html/logs/*.log {
    daily
    rotate 365
    compress
    delaycompress
    missingok
    notifempty
    create 644 www-data www-data
}
```

---

## 11. Troubleshooting

### 11.1 Problemas Comuns

**Elasticsearch não conecta:**
```bash
# Verificar status do serviço
sudo systemctl status elasticsearch

# Verificar logs
sudo journalctl -u elasticsearch

# Testar conectividade
curl -X GET "localhost:9200/_cluster/health"
```

**Upload de XML falha:**
```php
// Verificar configurações PHP
php -i | grep -E '(upload_max_filesize|post_max_size|max_execution_time)'

// Verificar permissões
ls -la data/uploads/
```

**Performance lenta:**
```bash
# Verificar uso de recursos
htop
df -h
free -m

# Otimizar Elasticsearch
curl -X POST "localhost:9200/_cache/clear"
```

### 11.2 Debugging

**Modo Debug:**
```php
// config/config.php
return [
    'debug' => true,
    'log_level' => 'DEBUG',
    'elasticsearch' => [
        'log_requests' => true,
        'log_responses' => true
    ]
];
```

**Logs Detalhados:**
```php
// Adicionar em qualquer arquivo
error_log("DEBUG: Variable value = " . print_r($variable, true));
```

---

## 12. Roadmap Técnico

### 12.1 Versão 2.0 (Previsão: H2 2025)

**Funcionalidades:**
- [ ] Integração automática com ORCID
- [ ] API do OpenAlex implementada
- [ ] Machine Learning para análise de dados
- [ ] Interface mobile responsiva
- [ ] Sistema de notificações

**Melhorias Técnicas:**
- [ ] Migração para PHP 8.3
- [ ] Implementação de Redis para cache
- [ ] Kubernetes para orquestração
- [ ] Monitoring com Prometheus + Grafana
- [ ] CI/CD com GitHub Actions

### 12.2 Versão 3.0 (Previsão: 2026)

**Funcionalidades Avançadas:**
- [ ] Blockchain para certificação de dados
- [ ] IA para predição de tendências
- [ ] Integração com repositórios institucionais
- [ ] Módulo de gestão de projetos
- [ ] Analytics avançados com BigQuery

**Arquitetura:**
- [ ] Microservices com Docker Swarm
- [ ] Event-driven architecture
- [ ] GraphQL API
- [ ] Multi-tenant support
- [ ] Edge computing para performance

---

## 13. Contribuição e Desenvolvimento

### 13.1 Configuração do Ambiente de Desenvolvimento

**Pré-requisitos:**
```bash
# Instalar dependências
sudo apt-get update
sudo apt-get install php8.2 composer nodejs npm

# Clonar repositório
git clone https://github.com/Matheus904-12/Prodmais.git
cd Prodmais

# Instalar dependências PHP
composer install

# Configurar ambiente
cp config/config.example.php config/config.php
```

**Docker para Desenvolvimento:**
```bash
# Ambiente completo
docker-compose -f docker-compose.dev.yml up -d

# Apenas Elasticsearch
docker-compose up elasticsearch
```

### 13.2 Padrões de Código

**PSR-12 Compliance:**
- Indentação com 4 espaços
- Linhas máximo de 120 caracteres
- Cabeçalhos de classe e método conforme PSR-12
- Documentação PHPDoc obrigatória

**Exemplo:**
```php
<?php

declare(strict_types=1);

namespace Prodmais\Services;

use Exception;
use Psr\Log\LoggerInterface;

/**
 * Serviço para integração com ORCID
 * 
 * @author Equipe PIVIC UMC
 * @since 2.0.0
 */
final class OrcidService
{
    private const API_BASE_URL = 'https://pub.orcid.org/v3.0/';
    
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly array $config
    ) {
    }
    
    /**
     * Busca publicações de um pesquisador via ORCID
     * 
     * @param string $orcidId ID ORCID do pesquisador
     * @return array Lista de publicações
     * @throws Exception Se falhar na comunicação com API
     */
    public function getPublications(string $orcidId): array
    {
        // Implementação
    }
}
```

### 13.3 Processo de Release

**Git Flow:**
```bash
# Feature branch
git checkout -b feature/nova-funcionalidade
git commit -m "feat: adicionar integração ORCID"
git push origin feature/nova-funcionalidade

# Pull request para develop
# Após aprovação, merge para main
git checkout main
git tag v2.0.0
git push origin v2.0.0
```

**Semantic Versioning:**
- **MAJOR:** Mudanças incompatíveis na API
- **MINOR:** Funcionalidades novas compatíveis
- **PATCH:** Correções de bugs compatíveis

---

## 14. Anexos

### 14.1 Referências Técnicas

**Documentação Oficial:**
- [Elasticsearch PHP Client](https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/index.html)
- [PHP 8.2 Documentation](https://www.php.net/manual/en/)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.3/getting-started/introduction/)

**Padrões e Especificações:**
- [PSR-12: Extended Coding Style](https://www.php-fig.org/psr/psr-12/)
- [CERIF Standard](https://www.eurocris.org/cerif/main-features-cerif)
- [Dublin Core Metadata](https://dublincore.org/specifications/dublin-core/)

### 14.2 Ferramentas Recomendadas

**IDEs:**
- PhpStorm (recomendado)
- Visual Studio Code
- Sublime Text

**Extensões VS Code:**
- PHP Intelephense
- PHP Debug
- GitLens
- Docker

### 14.3 Checklist de Deployment

**Pré-deployment:**
- [ ] Testes unitários passando
- [ ] Testes de integração passando
- [ ] Análise estática sem erros críticos
- [ ] Documentação atualizada
- [ ] Backup do ambiente atual

**Deployment:**
- [ ] Ambiente de staging testado
- [ ] Variáveis de ambiente configuradas
- [ ] SSL/TLS configurado
- [ ] Firewall configurado
- [ ] Monitoramento ativo

**Pós-deployment:**
- [ ] Health check passando
- [ ] Logs sem erros críticos
- [ ] Performance dentro dos SLAs
- [ ] Usuários notificados
- [ ] Documentação de release

---

**Controle do Document:**
- **Versão:** 1.0  
- **Data:** Março 2025  
- **Responsável:** Equipe PIVIC UMC  
- **Revisão:** Prof. Me. Leandro Miranda de Almeida  
- **Próxima Atualização:** Junho 2025  

*Esta documentação é parte integrante do Projeto PIVIC "Implementação da Ferramenta Prodmais na Universidade de Mogi das Cruzes"*