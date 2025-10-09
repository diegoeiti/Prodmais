# Changelog - Sistema Prodmais

Todas as mudanças notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/),
e este projeto adere ao [Versionamento Semântico](https://semver.org/lang/pt-BR/spec/v2.0.0.html).

## [2.0.0] - 2024-12-19

### 🚀 Adicionado

#### Sistema de Parsing Avançado
- **Parser completo de Currículos Lattes** - Suporte para todos os tipos de produção
- **Extração de artigos** com dados completos (título, autores, revista, DOI, etc.)
- **Extração de livros e capítulos** com editoras e ISBNs
- **Extração de trabalhos em eventos** com dados do evento
- **Extração de orientações** (mestrado, doutorado, IC, TCC)
- **Extração de patentes** com dados de registro
- **Extração de produção técnica** (softwares, produtos, processos)

#### Integrações API Externas
- **Integração OpenAlex** - Enriquecimento automático com dados bibliométricos
- **Integração ORCID** - Busca e sincronização de perfis de pesquisadores
- **Rate limiting inteligente** para respeitar limites das APIs
- **Cache de resultados** para otimizar performance
- **Retry automático** com backoff exponencial

#### Sistema de Busca Avançado
- **Elasticsearch 8.10+** com mapeamentos otimizados
- **Busca textual inteligente** com relevância por boost
- **Filtros múltiplos** (tipo, ano, área, instituição)
- **Agregações estatísticas** em tempo real
- **Paginação eficiente** com controle de tamanho
- **Ordenação customizável** por relevância, ano, título

#### Interface Web Moderna
- **Design responsivo** com Bootstrap 5.3.3
- **Navegação por abas** (Busca, Pesquisadores, Estatísticas)
- **Gráficos interativos** com Chart.js
- **Modais de detalhes** para visualização completa
- **Busca em tempo real** com debounce
- **Exportação integrada** diretamente da interface

#### Sistema de Exportação Completo
- **Formato BibTeX** com campos padronizados
- **Formato RIS** compatível com gestores de referência
- **Formato CSV** para análises em planilhas
- **Formato JSON** para integração com outros sistemas
- **Formato XML** estruturado
- **Filtros aplicados** mantidos na exportação
- **Escape de caracteres** especiais

#### Conformidade LGPD
- **Sistema de anonimização** com múltiplos níveis
- **Hash consistente** para manter relações
- **Logs de auditoria** para rastreabilidade
- **Relatórios de privacidade** automatizados
- **Opções de exclusão** de dados pessoais
- **Configuração flexível** de níveis de privacidade

#### APIs RESTful
- **`/api/search.php`** - Busca avançada com filtros
- **`/api/upload_and_index.php`** - Upload e indexação de XMLs
- **`/api/researchers.php`** - Gestão de pesquisadores
- **`/api/export.php`** - Exportação em múltiplos formatos
- **`/api/filter_values.php`** - Valores únicos para filtros
- **Documentação OpenAPI** completa
- **Rate limiting** configurável
- **Tratamento de erros** padronizado

#### Ferramentas de Administração
- **`bin/indexer.php`** - Indexação em lote otimizada
- **`bin/install.php`** - Instalação automática
- **`bin/migrate.php`** - Migração entre versões
- **`bin/tasks.php`** - Tarefas de manutenção automatizadas
- **`bin/backup.php`** - Sistema de backup
- **Scripts shell** para Linux/Windows

#### Infraestrutura e Deploy
- **Docker Compose** para ambiente completo
- **Dockerfile** otimizado para produção
- **Configuração Nginx/Apache** incluída
- **Scripts de instalação** para múltiplas plataformas
- **Backup automático** configurável
- **Monitoramento de saúde** do sistema

#### Documentação Completa
- **README.md** detalhado com exemplos
- **Guia de instalação** passo a passo
- **Documentação de API** com exemplos
- **Troubleshooting** para problemas comuns
- **Checklist de qualidade** para deploy
- **Arquitetura do sistema** documentada

### 🔧 Melhorias

#### Performance
- **Indexação otimizada** com processamento em lotes
- **Queries Elasticsearch** otimizadas com filtros eficientes
- **Cache multinível** (aplicação, Elasticsearch, navegador)
- **Lazy loading** de recursos pesados
- **Compressão** de recursos estáticos

#### Segurança
- **Validação rigorosa** de entrada
- **Sanitização** de dados
- **Proteção CSRF** implementada
- **Headers de segurança** configurados
- **Logs seguros** sem exposição de dados sensíveis

#### Usabilidade
- **Interface intuitiva** com feedback visual
- **Mensagens de erro** claras e acionáveis
- **Progresso de upload** em tempo real
- **Navegação consistente** entre seções
- **Suporte mobile** completo

### 🐛 Corrigido

#### Parsing de XML
- **Encoding UTF-8** forçado para caracteres especiais
- **Namespaces XML** tratados corretamente
- **Validação robusta** de estrutura XML
- **Recuperação de erros** em XMLs malformados

#### Elasticsearch
- **Mapeamentos corretos** para todos os tipos de campo
- **Tratamento de conexão** com retry automático
- **Índices otimizados** para performance
- **Queries complexas** com múltiplos filtros

#### APIs Externas
- **Rate limiting** respeitado
- **Timeouts configuráveis** para robustez
- **Tratamento de erros** HTTP completo
- **Fallback gracioso** quando APIs indisponíveis

### 🔄 Alterado

#### Estrutura de Dados
- **Schema Elasticsearch** redesenhado para flexibilidade
- **Campos padronizados** seguindo padrões bibliográficos
- **Relacionamentos** entre entidades otimizados
- **Indexação hierárquica** para busca eficiente

#### Configuração
- **Arquivo config.php** centralizado
- **Variáveis de ambiente** suportadas
- **Configuração por ambiente** (dev/prod)
- **Validação de configuração** na inicialização

#### Arquitetura
- **Separação de responsabilidades** clara
- **Services pattern** implementado
- **Injeção de dependências** básica
- **Tratamento de exceções** centralizado

### 📚 Dependências

#### Novas Dependências
- **elasticsearch/elasticsearch ^8.10** - Cliente oficial Elasticsearch
- **guzzlehttp/guzzle ^7.8** - Cliente HTTP robusto
- **smalot/pdfparser ^2.7** - Parser de arquivos PDF
- **Bootstrap 5.3.3** - Framework CSS responsivo
- **Chart.js 4.4.0** - Biblioteca de gráficos
- **Bootstrap Icons 1.11.0** - Ícones vetoriais

#### Dependências de Desenvolvimento
- **PHPUnit** para testes automatizados
- **PHP_CodeSniffer** para padrões de código
- **PHPStan** para análise estática

### 🔧 Requisitos Técnicos

#### Servidor
- **PHP 8.2+** com extensões curl, json, xml, mbstring, sqlite3, zip
- **Elasticsearch 8.10+** com configuração otimizada
- **Apache 2.4+ ou Nginx 1.18+** com mod_rewrite
- **Composer 2.0+** para gestão de dependências

#### Ambiente
- **Mínimo 2GB RAM** para Elasticsearch
- **500MB espaço livre** para dados e cache
- **Acesso à internet** para APIs externas (opcional)
- **SSL/TLS** recomendado para produção

### 📊 Métricas

#### Performance
- **Indexação:** ~1000 documentos/minuto
- **Busca:** <500ms tempo médio de resposta
- **Upload:** Suporte a arquivos até 10MB
- **Exportação:** Até 1000 registros por vez

#### Capacidade
- **Documentos:** Testado com 100k+ documentos
- **Usuários:** Suporte a múltiplos usuários simultâneos
- **Armazenamento:** Compressão automática de dados
- **Cache:** Invalidação inteligente

### 🎯 Roadmap Futuro

#### Versão 2.1 (Q1 2025)
- [ ] Autenticação LDAP/SAML
- [ ] Dashboard administrativo avançado
- [ ] Métricas de uso detalhadas
- [ ] API GraphQL
- [ ] Testes automatizados completos

#### Versão 2.2 (Q2 2025)
- [ ] Machine Learning para classificação automática
- [ ] Análise de redes de colaboração
- [ ] Dashboards personalizáveis
- [ ] Integração com Scopus/Web of Science
- [ ] App mobile

### 👥 Contribuições

Este projeto é mantido pela **UNIFESP** e aceita contribuições da comunidade.

#### Como Contribuir
1. Fork o repositório
2. Crie uma branch para sua feature
3. Implemente seguindo os padrões estabelecidos
4. Execute os testes
5. Submeta um Pull Request

#### Padrões
- **PSR-12** para código PHP
- **Conventional Commits** para mensagens
- **SemVer** para versionamento
- **Documentação** obrigatória para novas features

### 📄 Licença

Este projeto está licenciado sob a **Licença MIT** - veja o arquivo LICENSE para detalhes.

### 🙏 Agradecimentos

- **Equipe UNIFESP** pelo suporte e feedback
- **Comunidade Elasticsearch** pela documentação
- **Projeto OpenAlex** pela API aberta
- **ORCID** pelos padrões de identificação
- **Contribuidores** que testaram e reportaram issues

---

**Para versões anteriores e detalhes técnicos completos, consulte a documentação técnica e o histórico de commits no repositório.**