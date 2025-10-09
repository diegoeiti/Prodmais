# Checklist de Qualidade - Sistema Prodmais

## ✅ Checklist de Instalação

### Pré-requisitos
- [ ] PHP 8.2+ instalado e configurado
- [ ] Extensões PHP necessárias (curl, json, xml, mbstring, sqlite3, zip)
- [ ] Composer instalado
- [ ] Elasticsearch 8.10+ instalado e rodando
- [ ] Servidor web (Apache/Nginx) configurado

### Instalação Automática
- [ ] Executar `php bin/install.php` ou `./install.sh`
- [ ] Verificar criação de diretórios em `/data`
- [ ] Confirmar arquivo `config/config.php` criado
- [ ] Testar conectividade com Elasticsearch
- [ ] Verificar permissões de escrita

### Configuração
- [ ] Editar `config/config.php` com configurações específicas
- [ ] Configurar URLs do Elasticsearch
- [ ] Definir salt de anonimização único
- [ ] Configurar emails de contato
- [ ] Ajustar configurações de integração (OpenAlex, ORCID)

## ✅ Checklist de Funcionalidades

### Parser de Currículos Lattes
- [ ] Upload de arquivos XML funcional
- [ ] Parsing de dados de pesquisadores
- [ ] Extração de artigos publicados
- [ ] Extração de livros e capítulos
- [ ] Extração de trabalhos em eventos
- [ ] Extração de orientações
- [ ] Extração de patentes
- [ ] Extração de produções técnicas

### Indexação Elasticsearch
- [ ] Criação automática de índices
- [ ] Mapeamento de campos correto
- [ ] Indexação de documentos
- [ ] Busca textual funcionando
- [ ] Filtros por tipo de produção
- [ ] Filtros por ano
- [ ] Filtros por área do conhecimento
- [ ] Agregações estatísticas

### Interface Web
- [ ] Design responsivo
- [ ] Navegação por abas
- [ ] Formulário de busca avançada
- [ ] Exibição de resultados paginados
- [ ] Gráficos estatísticos
- [ ] Modais de detalhes
- [ ] Sistema de exportação

### Integrações API
- [ ] Integração OpenAlex funcionando
- [ ] Enriquecimento de dados bibliométricos
- [ ] Integração ORCID funcionando
- [ ] Busca de perfis de pesquisadores
- [ ] Rate limiting implementado
- [ ] Tratamento de erros

### Sistema de Exportação
- [ ] Exportação em BibTeX
- [ ] Exportação em RIS
- [ ] Exportação em CSV
- [ ] Exportação em JSON
- [ ] Exportação em XML
- [ ] Formatação correta dos dados
- [ ] Tratamento de caracteres especiais

### Conformidade LGPD
- [ ] Sistema de anonimização
- [ ] Níveis de privacidade configuráveis
- [ ] Logs de acesso
- [ ] Opções de exclusão de dados
- [ ] Relatórios de auditoria
- [ ] Hash consistente para anonimização

## ✅ Checklist de APIs

### API de Busca (`/api/search.php`)
- [ ] Busca por texto livre
- [ ] Filtros múltiplos
- [ ] Paginação
- [ ] Ordenação
- [ ] Agregações
- [ ] Tratamento de erros
- [ ] Rate limiting

### API de Upload (`/api/upload_and_index.php`)
- [ ] Upload de arquivos XML
- [ ] Validação de formato
- [ ] Parsing automático
- [ ] Indexação no Elasticsearch
- [ ] Feedback de progresso
- [ ] Tratamento de erros

### API de Pesquisadores (`/api/researchers.php`)
- [ ] Listagem de pesquisadores
- [ ] Detalhes do pesquisador
- [ ] Integração ORCID
- [ ] Filtros de busca
- [ ] Paginação

### API de Filtros (`/api/filter_values.php`)
- [ ] Valores únicos por campo
- [ ] Cache de resultados
- [ ] Atualização dinâmica

### API de Exportação (`/api/export.php`)
- [ ] Múltiplos formatos
- [ ] Filtros aplicados
- [ ] Limitação de registros
- [ ] Headers HTTP corretos

## ✅ Checklist de Segurança

### Validação de Entrada
- [ ] Sanitização de parâmetros GET/POST
- [ ] Validação de arquivos upload
- [ ] Escape de dados para HTML
- [ ] Prevenção de SQL Injection
- [ ] Prevenção de XSS

### Autenticação e Autorização
- [ ] Sistema de login admin
- [ ] Controle de sessões
- [ ] Timeout de sessão
- [ ] Proteção CSRF
- [ ] Rate limiting

### Proteção de Dados
- [ ] HTTPS recomendado
- [ ] Cookies seguros
- [ ] Headers de segurança
- [ ] Logs seguros
- [ ] Backup criptografado

## ✅ Checklist de Performance

### Elasticsearch
- [ ] Índices otimizados
- [ ] Mapeamentos eficientes
- [ ] Queries otimizadas
- [ ] Cache habilitado
- [ ] Monitoramento de performance

### Frontend
- [ ] Recursos minificados
- [ ] Cache de navegador
- [ ] Lazy loading
- [ ] Compressão gzip
- [ ] CDN para recursos estáticos

### Backend
- [ ] Cache de aplicação
- [ ] Pool de conexões
- [ ] Rate limiting
- [ ] Logs estruturados
- [ ] Monitoramento de recursos

## ✅ Checklist de Manutenção

### Backups
- [ ] Backup automático configurado
- [ ] Retenção de backups
- [ ] Teste de restauração
- [ ] Backup de configurações
- [ ] Backup de dados Elasticsearch

### Monitoramento
- [ ] Logs de aplicação
- [ ] Logs de erro
- [ ] Métricas de performance
- [ ] Alertas configurados
- [ ] Dashboard de monitoramento

### Atualizações
- [ ] Processo de atualização documentado
- [ ] Testes automatizados
- [ ] Rollback procedure
- [ ] Changelog mantido
- [ ] Versionamento semântico

## ✅ Checklist de Documentação

### Documentação Técnica
- [ ] README.md completo
- [ ] Guia de instalação
- [ ] Guia de configuração
- [ ] Documentação da API
- [ ] Troubleshooting guide

### Documentação do Usuário
- [ ] Manual do usuário
- [ ] Tutorial de uso
- [ ] FAQ
- [ ] Exemplos práticos
- [ ] Vídeos demonstrativos

### Documentação do Desenvolvedor
- [ ] Arquitetura do sistema
- [ ] Padrões de código
- [ ] Guia de contribuição
- [ ] Roadmap
- [ ] Changelog

## ✅ Checklist de Testes

### Testes Funcionais
- [ ] Upload e parsing de XMLs
- [ ] Busca e filtros
- [ ] Exportação de dados
- [ ] Integrações API
- [ ] Interface web

### Testes de Integração
- [ ] Elasticsearch connectivity
- [ ] API externa (OpenAlex/ORCID)
- [ ] Sistema de arquivos
- [ ] Base de dados SQLite

### Testes de Performance
- [ ] Carga de dados
- [ ] Queries complexas
- [ ] Múltiplos usuários
- [ ] Uso de memória
- [ ] Tempo de resposta

### Testes de Segurança
- [ ] Injeção de dados
- [ ] Bypass de autenticação
- [ ] Exposição de dados
- [ ] Vulnerabilidades conhecidas

## ✅ Checklist de Deploy

### Ambiente de Produção
- [ ] Servidor configurado
- [ ] SSL certificado
- [ ] Firewall configurado
- [ ] Monitoramento ativo
- [ ] Backup automático

### Configuração Final
- [ ] Variáveis de ambiente
- [ ] Configurações de produção
- [ ] Logs de produção
- [ ] Cache habilitado
- [ ] Debug desabilitado

### Verificações Pós-Deploy
- [ ] Sistema acessível
- [ ] Todas as funcionalidades testadas
- [ ] Logs sem erros críticos
- [ ] Performance aceitável
- [ ] Backup funcionando

## 📊 Métricas de Qualidade

### Cobertura de Código
- [ ] Parsers: 90%+
- [ ] APIs: 85%+
- [ ] Integrações: 80%+
- [ ] Frontend: 70%+

### Performance Targets
- [ ] Tempo de indexação: < 5s por arquivo
- [ ] Tempo de busca: < 500ms
- [ ] Tempo de carregamento: < 2s
- [ ] Disponibilidade: 99.5%+

### Qualidade de Código
- [ ] PSR-12 compliance
- [ ] Documentação inline
- [ ] Tratamento de exceções
- [ ] Logs estruturados
- [ ] Código revisado

---

## ✅ Assinatura de Qualidade

**Data:** _______________

**Responsável Técnico:** _______________

**Versão Testada:** 2.0.0

**Status:** [ ] Aprovado [ ] Aprovado com ressalvas [ ] Reprovado

**Observações:**
_________________________________________________________________
_________________________________________________________________
_________________________________________________________________