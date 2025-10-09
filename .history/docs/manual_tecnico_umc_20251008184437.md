# Manual Técnico - Sistema Prodmais UMC

## Universidade de Mogi das Cruzes
### Versão 1.0 - 2025

---

## Sumário

1. [Introdução](#introdução)
2. [Arquitetura do Sistema](#arquitetura-do-sistema)
3. [Instalação e Configuração](#instalação-e-configuração)
4. [Componentes UMC Específicos](#componentes-umc-específicos)
5. [APIs e Endpoints](#apis-e-endpoints)
6. [Sistema de Validação](#sistema-de-validação)
7. [Conformidade LGPD](#conformidade-lgpd)
8. [Integração BrCris](#integração-brcris)
9. [Relatórios CAPES](#relatórios-capes)
10. [Monitoramento e Logs](#monitoramento-e-logs)
11. [Backup e Recuperação](#backup-e-recuperação)
12. [Solução de Problemas](#solução-de-problemas)

---

## Introdução

O Sistema Prodmais UMC é uma implementação customizada para a Universidade de Mogi das Cruzes, desenvolvida especificamente para atender aos programas de pós-graduação:

- **Biotecnologia** (Código CAPES: 40001016036P2)
- **Engenharia Biomédica** (Código CAPES: 40001016037P6)
- **Políticas Públicas** (Código CAPES: 40001016038P2)
- **Ciência e Tecnologia em Saúde** (Código CAPES: 40001016039P9)

### Objetivos

- Centralizar dados de produção científica
- Garantir conformidade com LGPD
- Facilitar avaliações CAPES
- Promover colaboração interinstitucional
- Integrar com plataformas nacionais (BrCris)

---

## Arquitetura do Sistema

### Stack Tecnológico

- **Backend**: PHP 8.2+
- **Busca**: Elasticsearch 8.10+
- **Frontend**: HTML5, CSS3, JavaScript ES6+
- **Dados**: JSON, SQLite (logs)
- **Integração**: REST APIs

### Estrutura de Diretórios

```
Prodmais/
├── config/
│   ├── config.php              # Configuração principal
│   ├── umc_config.php          # Configurações UMC específicas
│   ├── DPIA.md                 # Relatório de Avaliação de Impacto
│   ├── privacy_policy.md       # Política de Privacidade
│   └── terms_of_use.md         # Termos de Uso
├── src/
│   ├── ElasticsearchService.php
│   ├── UmcProgramService.php   # Gerenciamento de programas UMC
│   ├── BrCrisIntegration.php   # Integração BrCris
│   ├── LgpdComplianceService.php # Conformidade LGPD
│   ├── CapesReportGenerator.php # Relatórios CAPES
│   ├── UmcValidationSystem.php # Sistema de validação
│   └── LogService.php
├── public/
│   ├── api/
│   │   ├── umc_filters.php     # Filtros UMC específicos
│   │   ├── umc_dashboard.php   # Dashboard institucional
│   │   └── validation.php      # API de validação
│   └── ...
└── data/
    ├── logs/                   # Logs do sistema
    └── uploads/                # Arquivos enviados
```

---

## Instalação e Configuração

### Pré-requisitos

- PHP 8.2 ou superior
- Elasticsearch 8.10 ou superior
- Composer
- Servidor web (Apache/Nginx)

### Instalação

1. **Clonar o repositório**:
```bash
git clone [repositório] /caminho/para/prodmais
cd /caminho/para/prodmais
```

2. **Instalar dependências**:
```bash
composer install
```

3. **Configurar Elasticsearch**:
```bash
# Instalar e iniciar Elasticsearch
# Criar índices necessários
php bin/indexer.php --create-indices
```

4. **Configurar permissões**:
```bash
chmod 755 data/
chmod 755 public/
chown -R www-data:www-data data/
```

### Configuração UMC

Editar `config/umc_config.php`:

```php
<?php
return [
    'institution' => [
        'name' => 'Universidade de Mogi das Cruzes',
        'code' => '40001016',
        'contact_email' => 'posgraduacao@umc.br'
    ],
    'postgraduate_programs' => [
        'biotecnologia' => [
            'name' => 'Biotecnologia',
            'capes_code' => '40001016036P2',
            'coordinator' => 'coord.biotec@umc.br'
        ],
        // ... outros programas
    ]
];
```

---

## Componentes UMC Específicos

### UmcProgramService

Gerencia os programas de pós-graduação da UMC:

```php
$programService = new UmcProgramService($config);

// Obter dados de um programa
$program = $programService->getProgramData('biotecnologia');

// Calcular métricas CAPES
$metrics = $programService->calculateCapesMetrics('biotecnologia', 2020, 2024);

// Verificar conformidade LGPD
$compliance = $programService->checkLgpdCompliance('biotecnologia');
```

### BrCrisIntegration

Integração com a plataforma brasileira BrCris:

```php
$brcris = new BrCrisIntegration($config);

// Mapear dados para Dublin Core
$dcMetadata = $brcris->mapToDublinCore($productionData);

// Sincronizar com BrCris
$result = $brcris->syncWithBrCris($program, $startDate, $endDate);
```

### LgpdComplianceService

Serviços de conformidade LGPD:

```php
$lgpd = new LgpdComplianceService($config);

// Gerar relatório DPIA
$dpia = $lgpd->generateDpiaReport();

// Registrar consentimento
$lgpd->recordConsent($userId, $purposes, $lawfulBasis);

// Processar direito de portabilidade
$data = $lgpd->exportUserData($userId);
```

---

## APIs e Endpoints

### API de Filtros UMC (`/api/umc_filters.php`)

#### Filtros por Programa
```
GET /api/umc_filters.php?action=programs
```

Retorna lista de programas de pós-graduação.

#### Linhas de Pesquisa
```
GET /api/umc_filters.php?action=research_lines&program=biotecnologia
```

#### Bases de Indexação
```
GET /api/umc_filters.php?action=indexation_bases
```

### API de Dashboard (`/api/umc_dashboard.php`)

#### Dashboard do Coordenador
```
GET /api/umc_dashboard.php?action=coordinator&program=biotecnologia
```

#### Resumo de Produção
```
GET /api/umc_dashboard.php?action=production_summary&program=biotecnologia&year=2024
```

#### Métricas de Docentes
```
GET /api/umc_dashboard.php?action=faculty_metrics&program=biotecnologia
```

### API de Validação (`/api/validation.php`)

#### Executar Validação
```
POST /api/validation.php?action=run
```

#### Status da Validação
```
GET /api/validation.php?action=status
```

#### Relatórios de Validação
```
GET /api/validation.php?action=reports
```

---

## Sistema de Validação

### Tipos de Validação

1. **Validação Técnica**:
   - Integridade de dados
   - Saúde do Elasticsearch
   - Endpoints da API
   - Conexões de banco

2. **Validação Funcional**:
   - Upload de dados
   - Funcionalidade de busca
   - Operações de filtro
   - Exportação

3. **Validação Institucional**:
   - Precisão dos dados do programa
   - Indicadores CAPES
   - Métricas institucionais
   - Geração de relatórios

### Executando Validações

```php
$validation = new UmcValidationSystem($config);

// Validação completa
$result = $validation->runFullValidation();

// Verificar score geral
$score = $result['overall_score'];

// Obter recomendações
$recommendations = $result['recommendations'];
```

### Interpretação de Resultados

- **Score 90-100%**: Sistema em excelente estado
- **Score 80-89%**: Sistema funcional com melhorias recomendadas
- **Score 70-79%**: Sistema necessita atenção
- **Score < 70%**: Sistema necessita intervenção urgente

---

## Conformidade LGPD

### Princípios Implementados

1. **Finalidade**: Dados coletados apenas para fins acadêmicos
2. **Adequação**: Tratamento compatível com finalidades
3. **Necessidade**: Limitação ao mínimo necessário
4. **Livre Acesso**: Transparência sobre o tratamento
5. **Qualidade**: Dados exatos, claros e atualizados
6. **Transparência**: Informações claras aos titulares
7. **Segurança**: Medidas técnicas e administrativas
8. **Prevenção**: Adoção de medidas preventivas
9. **Não Discriminação**: Tratamento sem fins discriminatórios
10. **Responsabilização**: Demonstração da eficácia das medidas

### Base Legal

- **Art. 7º, VI**: Execução de contrato (vínculo institucional)
- **Art. 7º, IV**: Pesquisa por órgão de pesquisa

### Direitos dos Titulares

Implementados no `LgpdComplianceService`:

- Confirmação de tratamento
- Acesso aos dados
- Correção de dados incompletos
- Anonimização ou eliminação
- Portabilidade dos dados
- Informação sobre compartilhamento
- Informação sobre possibilidade de não fornecer consentimento
- Revogação do consentimento

---

## Integração BrCris

### Visão Geral

O BrCris (Brazilian Current Research Information System) é a plataforma nacional de informações de pesquisa do Brasil, baseada no modelo CERIF.

### Mapeamento Dublin Core

| Campo UMC | Dublin Core | Descrição |
|-----------|-------------|-----------|
| title | dc:title | Título da produção |
| authors | dc:creator | Autores |
| publication_date | dc:date | Data de publicação |
| abstract | dc:description | Resumo |
| keywords | dc:subject | Palavras-chave |
| doi | dc:identifier | DOI |
| journal | dc:source | Periódico |
| language | dc:language | Idioma |

### Sincronização

```php
$brcris = new BrCrisIntegration($config);

// Sincronizar programa específico
$result = $brcris->syncWithBrCris('biotecnologia', '2024-01-01', '2024-12-31');

// Verificar status
if ($result['success']) {
    echo "Sincronizados: {$result['synced_records']} registros";
}
```

---

## Relatórios CAPES

### Tipos de Relatórios

1. **Autoavaliação**: Relatório anual do programa
2. **Relatório Quadrienal**: Avaliação para período de 4 anos

### Indicadores CAPES

- **Produção Intelectual**: Artigos, livros, capítulos
- **Formação de Recursos Humanos**: Dissertações, teses
- **Corpo Docente**: Qualificação e produção
- **Proposta do Programa**: Objetivos e estrutura
- **Inserção Social**: Impacto e relevância

### Geração de Relatórios

```php
$generator = new CapesReportGenerator($config);

// Relatório de autoavaliação
$report = $generator->generateAutoavaliacaoReport('biotecnologia');

// Relatório quadrienal
$quadrienal = $generator->generateQuadrienalReport('biotecnologia', 2021, 2024);

// Dashboard para coordenador
$dashboard = $generator->generateCoordinatorDashboard('biotecnologia');
```

---

## Monitoramento e Logs

### Estrutura de Logs

```
data/logs/
├── application.log         # Logs gerais da aplicação
├── elasticsearch.log       # Logs do Elasticsearch
├── lgpd_compliance.log     # Logs de conformidade LGPD
├── validation_report_*.json # Relatórios de validação
└── user_feedback.json      # Feedback dos usuários
```

### Níveis de Log

- **DEBUG**: Informações detalhadas para desenvolvimento
- **INFO**: Informações gerais de operação
- **WARNING**: Situações que podem causar problemas
- **ERROR**: Erros que impedem a operação
- **CRITICAL**: Erros críticos que afetam o sistema

### Monitoramento em Tempo Real

```php
// Via API
GET /api/validation.php?action=monitor

// Retorna:
{
  "server_health": {...},
  "elasticsearch_status": {...},
  "disk_usage": {...},
  "memory_usage": {...}
}
```

---

## Backup e Recuperação

### Estratégia de Backup

1. **Dados Elasticsearch**: Snapshots diários
2. **Arquivos do Sistema**: Backup incremental
3. **Logs**: Rotação e arquivamento
4. **Configurações**: Versionamento no Git

### Procedimentos

#### Backup do Elasticsearch
```bash
# Criar snapshot
curl -X PUT "localhost:9200/_snapshot/backup/snapshot_$(date +%Y%m%d)" \
  -H 'Content-Type: application/json' \
  -d '{"indices": "prodmais_*"}'
```

#### Backup de Arquivos
```bash
# Backup incremental
rsync -av --backup --backup-dir=/backup/incremental/$(date +%Y%m%d) \
  /caminho/para/prodmais/ /backup/full/
```

#### Recuperação
```bash
# Restaurar snapshot
curl -X POST "localhost:9200/_snapshot/backup/snapshot_20240315/_restore"

# Restaurar arquivos
rsync -av /backup/full/ /caminho/para/prodmais/
```

---

## Solução de Problemas

### Problemas Comuns

#### 1. Elasticsearch Inacessível

**Sintomas**: Erro de conexão com Elasticsearch

**Soluções**:
```bash
# Verificar status
systemctl status elasticsearch

# Reiniciar serviço
systemctl restart elasticsearch

# Verificar logs
tail -f /var/log/elasticsearch/elasticsearch.log
```

#### 2. Upload de Arquivo Falha

**Sintomas**: Erro ao fazer upload de XML Lattes

**Soluções**:
- Verificar tamanho do arquivo (max_file_size)
- Validar formato XML
- Verificar permissões do diretório data/uploads/

#### 3. Relatórios CAPES Incompletos

**Sintomas**: Dados faltando nos relatórios

**Soluções**:
- Verificar índices no Elasticsearch
- Validar mapeamento de dados
- Conferir filtros por programa

#### 4. Erro de Conformidade LGPD

**Sintomas**: Falha na validação LGPD

**Soluções**:
- Verificar configurações de privacidade
- Validar base legal configurada
- Conferir logs de auditoria

### Logs de Debug

Habilitar debug no `config.php`:
```php
'debug' => true,
'log_level' => 'DEBUG'
```

### Contato Técnico

Para suporte técnico especializado:
- **Email**: suporte.prodmais@umc.br
- **Telefone**: (11) 4798-7000
- **Horário**: Segunda a Sexta, 8h às 18h

---

## Apêndices

### A. Códigos de Erro Comuns

| Código | Descrição | Solução |
|--------|-----------|---------|
| ES001 | Elasticsearch inacessível | Verificar serviço |
| UP001 | Erro no upload | Verificar arquivo |
| LG001 | Violação LGPD | Revisar configuração |
| CP001 | Erro relatório CAPES | Validar dados |

### B. Configurações de Performance

```php
// config.php - Otimizações
'elasticsearch' => [
    'timeout' => 30,
    'retries' => 3,
    'max_connections' => 10
],
'cache' => [
    'enabled' => true,
    'ttl' => 3600
]
```

### C. Checklist de Implantação

- [ ] PHP 8.2+ instalado
- [ ] Elasticsearch 8.10+ configurado
- [ ] Dependências Composer instaladas
- [ ] Permissões de arquivo configuradas
- [ ] Índices Elasticsearch criados
- [ ] Configuração UMC ajustada
- [ ] Validação completa executada
- [ ] Backup configurado
- [ ] Monitoramento ativo

---

**Documento gerado em**: {{ data_atual }}
**Versão**: 1.0
**Responsável técnico**: Equipe Prodmais UMC