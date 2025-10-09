# Manual do Usuário - Sistema Prodmais UMC
## Implementação da Ferramenta Prodmais na Universidade de Mogi das Cruzes

### Projeto PIVIC 2024/2025
**Orientador:** Prof. Me. Leandro Miranda de Almeida  
**Coorientação:** Prof. Dr. Fabiano Bezerra Menegidio  
**Pesquisadores:** João Victor Alexandre Almeida, Matheus Lucindo  

---

## 1. Introdução

O Sistema Prodmais UMC é uma ferramenta digital desenvolvida especificamente para consolidar, analisar e gerenciar a produção científica dos **4 Programas de Pós-Graduação Stricto Sensu** da Universidade de Mogi das Cruzes:

- **Biotecnologia** (40001016036P2)
- **Engenharia Biomédica** (40001016037P6) 
- **Políticas Públicas** (40001016038P2)
- **Ciência e Tecnologia em Saúde** (40001016039P9)

### 1.1 Objetivos do Sistema

**Objetivo Geral:**
Implementar uma plataforma integrada para consolidação, análise e interoperabilidade de dados da produção científica dos programas de pós-graduação UMC, otimizando a gestão da informação acadêmica e subsidiando processos de avaliação institucional.

**Objetivos Específicos:**
- Integrar dados das bases Lattes, ORCID e OpenAlex
- Personalizar filtros por área de concentração, campus, idioma e período
- Implementar funcionalidades de exportação compatíveis com ORCID e BrCris
- Avaliar eficácia e usabilidade no contexto institucional
- Produzir documentação técnica e relatório de impacto

### 1.2 Conformidade LGPD

Este sistema foi desenvolvido em **total conformidade com a Lei Geral de Proteção de Dados Pessoais (LGPD)**, seguindo os princípios de:
- **Finalidade:** Uso exclusivo para gestão acadêmica
- **Adequação:** Tratamento compatível com finalidades informadas
- **Necessidade:** Limitação ao mínimo necessário
- **Segurança:** Medidas técnicas e administrativas adequadas

---

## 2. Acesso ao Sistema

### 2.1 Requisitos Técnicos

**Navegadores Suportados:**
- Chrome 90+ (recomendado)
- Firefox 88+
- Safari 14+
- Edge 90+

**Conexão:**
- Internet banda larga
- JavaScript habilitado
- Cookies aceitos

### 2.2 Endereços de Acesso

**Ambiente de Produção:** `https://prodmais.umc.br`  
**Ambiente de Demonstração:** `http://localhost:8080`

### 2.3 Autenticação

**Para Usuários UMC:**
- Login com credenciais institucionais (@umc.br)
- Autenticação via Active Directory UMC
- Acesso baseado em perfil (Docente, Coordenador, Administrador)

**Para Demonstração:**
- Acesso público às funcionalidades básicas
- Dados anonimizados e exemplificativos

---

## 3. Interface Principal

### 3.1 Dashboard Principal

A tela inicial apresenta:

**Estatísticas Gerais:**
- Total de produções por programa
- Distribuição por tipo de produção
- Evolução temporal das publicações
- Indicadores de colaboração interinstitucional

**Gráficos Interativos:**
- Produção por ano (2010-2024)
- Distribuição por tipo (Artigos, Livros, Capítulos, etc.)
- Mapa de colaborações
- Rankings por programa

### 3.2 Filtros Avançados

**Filtro por Programa:**
- Biotecnologia
- Engenharia Biomédica
- Políticas Públicas
- Ciência e Tecnologia em Saúde

**Filtro por Tipo de Produção:**
- Artigo Publicado
- Livro
- Capítulo de Livro
- Trabalho em Evento
- Orientação (Mestrado/Doutorado)
- Produção Técnica
- Patente

**Filtros Temporais:**
- Ano específico
- Período (de/até)
- Últimos 5 anos
- Avaliação CAPES (quadriênio)

**Filtros por Idioma:**
- Português
- Inglês
- Espanhol
- Outros

**Filtro por Pesquisador:**
- Busca por nome
- Busca por ID Lattes
- Filtro por vinculação

### 3.3 Sistema de Busca

**Busca Simples:**
- Campo único para busca em todos os campos
- Busca por título, autor, palavras-chave
- Resultados relevantes ordenados por pertinência

**Busca Avançada:**
- Combinação de múltiplos critérios
- Operadores booleanos (AND, OR, NOT)
- Busca em campos específicos

---

## 4. Funcionalidades por Perfil

### 4.1 Perfil: Usuário Público

**Permissões:**
- Visualizar estatísticas agregadas
- Buscar produções (dados anonimizados)
- Exportar relatórios públicos
- Acessar gráficos e dashboards

**Limitações:**
- Não acessa dados pessoais de pesquisadores
- Visualiza apenas dados já públicos
- Não pode modificar dados

### 4.2 Perfil: Docente UMC

**Permissões:**
- Visualizar suas próprias produções
- Editar dados de perfil acadêmico
- Corrigir informações de publicações
- Gerar relatórios individuais
- Exercer direitos LGPD

**Funcionalidades Específicas:**
- Dashboard personalizado com suas métricas
- Histórico completo de orientações
- Indicadores de colaboração
- Comparativo com pares da área

### 4.3 Perfil: Coordenador de Programa

**Permissões:**
- Visualizar dados de seu programa
- Gerar relatórios para CAPES
- Analisar indicadores do programa
- Exportar dados para Sucupira

**Funcionalidades Específicas:**
- Dashboard do programa
- Relatórios de autoavaliação
- Análise de tendências
- Métricas de desempenho

### 4.4 Perfil: Administrador do Sistema

**Permissões:**
- Acesso completo ao sistema
- Gerenciar usuários e permissões
- Configurar integrações
- Monitorar logs de auditoria

**Funcionalidades Específicas:**
- Painel administrativo completo
- Upload de dados em lote
- Configuração de filtros
- Gerenciamento de backups

---

## 5. Área Administrativa

### 5.1 Upload de Dados

**Aba: Pesquisador Individual**

*Funcionalidade:* Upload de currículo Lattes XML individual

*Passos:*
1. Selecionar programa de pós-graduação UMC
2. Fazer upload do arquivo XML do Lattes
3. Aguardar processamento automático
4. Verificar dados indexados

*Formatos Aceitos:* .xml (Currículo Lattes)
*Tamanho Máximo:* 10MB por arquivo

**Aba: Upload em Lote**

*Funcionalidade:* Upload múltiplo de currículos

*Passos:*
1. Selecionar múltiplos arquivos XML
2. Confirmar programa de vinculação
3. Iniciar processamento em lote
4. Acompanhar progresso

*Formatos Aceitos:* .xml, .zip (múltiplos XMLs)
*Tamanho Máximo:* 100MB por lote

### 5.2 Logs do Sistema

**Monitoramento:**
- Logs de acesso por usuário
- Histórico de uploads
- Operações de CRUD
- Erros e exceções

**Níveis de Log:**
- **INFO:** Operações normais
- **WARNING:** Situações de atenção
- **ERROR:** Erros críticos

### 5.3 Gerenciamento de Usuários

**Cadastro de Novos Usuários:**
- Vinculação ao Active Directory UMC
- Definição de perfil de acesso
- Associação a programa específico

**Controle de Permissões:**
- Baseado em grupos (RBAC)
- Granularidade por funcionalidade
- Auditoria de alterações

---

## 6. Integrações Externas

### 6.1 Plataforma Lattes (CNPq)

**Tipo de Integração:** Upload manual de XML

**Processo:**
1. Docente acessa Plataforma Lattes
2. Gera currículo em formato XML
3. Faz upload no Prodmais UMC
4. Sistema processa e indexa automaticamente

**Dados Extraídos:**
- Dados pessoais (conforme LGPD)
- Formação acadêmica
- Produções bibliográficas
- Orientações concluídas
- Participação em eventos

### 6.2 ORCID

**Tipo de Integração:** API REST (futuro)

**Funcionalidades Planejadas:**
- Importação automática de publicações
- Sincronização de dados de perfil
- Exportação para ORCID
- Validação de duplicatas

### 6.3 OpenAlex

**Tipo de Integração:** API REST (futuro)

**Funcionalidades Planejadas:**
- Enriquecimento de metadados
- Métricas de citação
- Identificação de colaborações
- Análise de impacto

### 6.4 Sistema BrCris

**Tipo de Integração:** Exportação de dados

**Funcionalidades:**
- Exportação em formato CERIF-XML
- Compliance com padrões nacionais
- Sincronização com repositório nacional

---

## 7. Relatórios e Exportações

### 7.1 Relatórios Predefinidos

**Relatório de Produção por Programa:**
- Produção bibliográfica por ano
- Distribuição por tipo de produção
- Comparativo entre programas
- Evolução temporal

**Relatório de Orientações:**
- Orientações concluídas por programa
- Tempo médio de titulação
- Taxa de evasão
- Produção discente

**Relatório CAPES:**
- Formatação específica para Sucupira
- Dados do quadriênio atual
- Métricas de desempenho
- Indicadores qualitativos

### 7.2 Formatos de Exportação

**Formatos Suportados:**
- **PDF:** Relatórios formatados para impressão
- **Excel:** Dados tabulares para análise
- **CSV:** Dados brutos para processamento
- **JSON:** Dados estruturados para APIs
- **RIS/BibTeX:** Compatível com gestores bibliográficos

### 7.3 Exportação Personalizada

**Configurações:**
- Seleção de campos específicos
- Filtros personalizados
- Período de análise
- Formato de saída

---

## 8. Conformidade e Privacidade

### 8.1 Direitos dos Titulares (LGPD)

**Exercício de Direitos:**
- **Confirmação:** Verificar se dados pessoais são tratados
- **Acesso:** Obter cópia dos dados pessoais
- **Correção:** Corrigir dados incompletos ou incorretos
- **Anonimização:** Solicitar anonimização de dados
- **Portabilidade:** Receber dados em formato estruturado
- **Eliminação:** Solicitar exclusão de dados pessoais

**Como Exercer:**
1. Acesso ao portal de privacidade: `https://prodmais.umc.br/privacidade`
2. Autenticação com credenciais UMC
3. Seleção do direito a exercer
4. Preenchimento do formulário específico
5. Acompanhamento do status da solicitação

**Prazo de Resposta:** 15 dias úteis (conforme LGPD)

### 8.2 Política de Privacidade

**Dados Coletados:**
- Dados de identificação (nome, CPF, e-mail institucional)
- Dados acadêmicos (titulação, vinculação, área de atuação)
- Dados de produção científica (publicações, orientações)
- Dados de navegação (logs de acesso, apenas para segurança)

**Base Legal:**
- Art. 7º, VI - Execução de contrato (vinculação institucional)
- Art. 7º, IV - Pesquisa por órgão de pesquisa (atividade acadêmica)
- Art. 7º, §4º - Dados manifestamente públicos (Lattes)

**Retenção de Dados:**
- Durante vínculo institucional ativo
- 5 anos após encerramento do vínculo
- Anonimização automática após período de retenção

### 8.3 Segurança da Informação

**Medidas Técnicas:**
- Criptografia AES-256 para dados em repouso
- TLS 1.3 para dados em trânsito
- Autenticação multifator
- Controle de acesso baseado em perfis
- Monitoramento 24/7

**Medidas Organizacionais:**
- Política de Segurança da Informação UMC
- Treinamento obrigatório em LGPD
- Procedimentos de resposta a incidentes
- Auditoria externa anual

---

## 9. Troubleshooting

### 9.1 Problemas Comuns

**Problema:** Sistema não carrega dados
*Solução:*
1. Verificar conexão com internet
2. Limpar cache do navegador
3. Tentar acesso em navegador alternativo
4. Entrar em contato com suporte técnico

**Problema:** Erro no upload de XML
*Solução:*
1. Verificar se arquivo é XML válido do Lattes
2. Confirmar tamanho do arquivo (máx. 10MB)
3. Verificar se não há caracteres especiais no nome
4. Tentar novamente após alguns minutos

**Problema:** Dados não encontrados na busca
*Solução:*
1. Verificar filtros aplicados
2. Simplificar termos de busca
3. Usar busca por ID Lattes
4. Verificar se dados foram indexados

### 9.2 Contatos de Suporte

**Suporte Técnico:**
- **E-mail:** suporte.prodmais@umc.br
- **Telefone:** (11) 4798-7000
- **Horário:** Segunda a sexta, 8h às 18h

**Questões sobre LGPD:**
- **E-mail:** lgpd@umc.br
- **DPO:** Prof. Dr. [Nome do Encarregado]

**Suporte Acadêmico:**
- **Orientador:** Prof. Me. Leandro Miranda de Almeida
- **Coorientador:** Prof. Dr. Fabiano Bezerra Menegidio

---

## 10. Atualizações e Manutenção

### 10.1 Cronograma de Atualizações

**Atualizações de Segurança:**
- Aplicadas automaticamente
- Testes em ambiente de homologação
- Notificação prévia para usuários

**Atualizações de Funcionalidade:**
- Trimestrais (março, junho, setembro, dezembro)
- Baseadas em feedback dos usuários
- Documentação atualizada

### 10.2 Backup e Recuperação

**Política de Backup:**
- Backup automático diário
- Retenção de 30 dias para backups diários
- Backup semanal com retenção de 12 meses
- Backup anual com retenção de 7 anos

**Procedimento de Recuperação:**
- Tempo de recuperação: 4 horas
- Ponto de recuperação: 24 horas
- Teste de recuperação: trimestral

---

## 11. Roadmap e Desenvolvimentos Futuros

### 11.1 Versão 2.0 (Previsão: 2º Semestre 2025)

**Novas Funcionalidades:**
- Integração automática com ORCID
- Conectividade com OpenAlex
- Dashboard com IA para análise preditiva
- Aplicativo móvel

**Melhorias:**
- Interface mais intuitiva
- Performance otimizada
- Relatórios mais robustos
- APIs para terceiros

### 11.2 Versão 3.0 (Previsão: 2026)

**Funcionalidades Avançadas:**
- Machine Learning para análise de colaborações
- Integração com repositórios institucionais
- Blockchain para certificação de dados
- Módulo de gestão de projetos de pesquisa

---

## 12. Bibliografia e Referências

### 12.1 Marco Legal

- BRASIL. Lei nº 13.709, de 14 de agosto de 2018. Lei Geral de Proteção de Dados Pessoais (LGPD). Brasília, DF: Presidência da República, 2018.

- BRASIL. Lei nº 12.527, de 18 de novembro de 2011. Lei de Acesso à Informação. Brasília, DF: Presidência da República, 2011.

### 12.2 Referências Acadêmicas

- OLIVEIRA, A. P.; STECANELA, N. **A digitalização da pós-graduação brasileira: análise da Plataforma Sucupira**. Revista Brasileira de Pós-Graduação, v. 20, n. 44, p. 145-167, 2023.

- SEGURADO, R.; FERREIRA, V. **Interoperabilidade em sistemas acadêmicos: desafios e oportunidades**. Informação & Sociedade, v. 29, n. 3, p. 78-95, 2019.

- SILVA, M. A.; PARREIRAS, F. S.; MAIA, G.; BRANDÃO, W. C. **Enriquecimento semântico de dados curriculares: uma abordagem baseada em linked open data**. Transinformação, v. 30, n. 2, p. 201-215, 2018.

### 12.3 Normas Técnicas

- ASSOCIAÇÃO BRASILEIRA DE NORMAS TÉCNICAS. NBR ISO/IEC 27001: Tecnologia da informação — Técnicas de segurança — Sistemas de gestão de segurança da informação — Requisitos. Rio de Janeiro, 2013.

---

## Anexos

### Anexo A - Glossário de Termos Técnicos
### Anexo B - Templates de Relatórios
### Anexo C - Exemplos de Integrações
### Anexo D - FAQ Detalhado
### Anexo E - Changelog do Sistema

---

**Controle do Documento:**
- **Versão:** 1.0
- **Data:** Março 2025
- **Responsável:** Equipe PIVIC UMC
- **Aprovação:** Comitê de Pós-Graduação UMC
- **Próxima Revisão:** Setembro 2025

*Este manual é parte integrante do Projeto PIVIC "Implementação da Ferramenta Prodmais na Universidade de Mogi das Cruzes: Integração, Análise e Governança de Dados da Produção Científica em Programas de Pós-Graduação"*