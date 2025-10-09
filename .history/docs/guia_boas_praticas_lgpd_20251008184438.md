# Guia de Boas Práticas LGPD - Sistema Prodmais UMC

## Universidade de Mogi das Cruzes
### Conformidade com a Lei Geral de Proteção de Dados
### Versão 1.0 - 2025

---

## Sumário

1. [Introdução à LGPD no Contexto Acadêmico](#introdução-à-lgpd-no-contexto-acadêmico)
2. [Princípios Fundamentais da LGPD](#princípios-fundamentais-da-lgpd)
3. [Bases Legais para Tratamento](#bases-legais-para-tratamento)
4. [Direitos dos Titulares](#direitos-dos-titulares)
5. [Boas Práticas Operacionais](#boas-práticas-operacionais)
6. [Governança de Dados](#governança-de-dados)
7. [Segurança da Informação](#segurança-da-informação)
8. [Gestão de Incidentes](#gestão-de-incidentes)
9. [Documentação e Registros](#documentação-e-registros)
10. [Checklist de Conformidade](#checklist-de-conformidade)

---

## Introdução à LGPD no Contexto Acadêmico

### O que é a LGPD

A **Lei Geral de Proteção de Dados (Lei 13.709/2018)** estabelece regras para o tratamento de dados pessoais no Brasil, aplicando-se também ao ambiente acadêmico e de pesquisa.

### Aplicação na UMC

No contexto da **Universidade de Mogi das Cruzes**, a LGPD regula:

- ✅ **Dados de docentes, discentes e pesquisadores**
- ✅ **Informações de produção científica**
- ✅ **Dados de colaborações interinstitucionais**
- ✅ **Registros de orientações e bancas**
- ✅ **Informações de projetos de pesquisa**

### Benefícios da Conformidade

**Para a Instituição:**
- 🛡️ **Proteção contra multas** (até 2% do faturamento)
- 📈 **Melhoria da reputação** institucional
- 🤝 **Maior confiança** da comunidade acadêmica
- 🌐 **Facilitação de parcerias** internacionais

**Para os Pesquisadores:**
- 🔒 **Proteção dos dados pessoais**
- 📊 **Transparência** no uso dos dados
- ⚖️ **Exercício de direitos** garantidos
- 🎯 **Uso adequado** para fins acadêmicos

---

## Princípios Fundamentais da LGPD

### 1. Finalidade

**Definição:** Dados coletados para propósitos legítimos, específicos e informados ao titular.

**Na Prática UMC:**
- ✅ **Finalidade específica:** Gestão de programas de pós-graduação
- ✅ **Finalidade informada:** Comunicada no upload do Lattes
- ✅ **Finalidade legítima:** Avaliação CAPES e gestão acadêmica

**Exemplo Prático:**
```
❌ ERRADO: "Dados coletados para diversas finalidades institucionais"
✅ CORRETO: "Dados coletados para elaboração de relatórios CAPES 
              e gestão dos programas de pós-graduação"
```

### 2. Adequação

**Definição:** Tratamento compatível com as finalidades informadas.

**Na Prática UMC:**
- ✅ **Uso restrito** aos programas de pós-graduação
- ✅ **Proibição** de uso comercial
- ✅ **Vedação** de finalidades discriminatórias

### 3. Necessidade

**Definição:** Limitação ao mínimo necessário para atingir as finalidades.

**Na Prática UMC:**

**Dados Necessários:**
- Nome do pesquisador (identificação)
- Vínculo institucional (associação ao programa)
- Produção científica (avaliação CAPES)
- Orientações (formação de recursos humanos)

**Dados Desnecessários (Evitados):**
- ❌ Estado civil
- ❌ Religião
- ❌ Orientação política
- ❌ Dados bancários
- ❌ Endereço residencial

### 4. Livre Acesso

**Definição:** Garantia de informações claras sobre o tratamento.

**Na Prática UMC:**
- 📄 **Política de Privacidade** acessível
- 🔍 **Portal de transparência** com estatísticas
- 📞 **Canal direto** para dúvidas (lgpd@umc.br)
- 📊 **Dashboard** de exercício de direitos

### 5. Qualidade dos Dados

**Definição:** Dados exatos, claros, relevantes e atualizados.

**Na Prática UMC:**

**Validação Automática:**
```
✅ Verificação de duplicatas
✅ Validação de formatos (DOI, ISSN)
✅ Consistência de datas
✅ Verificação de vínculos institucionais
```

**Processo de Atualização:**
- 🔄 **Upload periódico** do Lattes
- 📝 **Correção manual** quando necessário
- 🤖 **Integração com BrCris** para validação
- 📈 **Indicadores de qualidade** dos dados

### 6. Transparência

**Definição:** Informações claras, precisas e facilmente acessíveis sobre o tratamento.

**Na Prática UMC:**

**Portal de Transparência UMC:**
```
📊 Estatísticas anonimizadas de uso
📈 Métricas de produção científica
📋 Relatórios de atividades de proteção de dados
🔍 Informações sobre exercício de direitos
```

### 7. Segurança

**Definição:** Medidas técnicas e administrativas para proteger os dados.

**Na Prática UMC:**
- 🔐 **Criptografia AES-256** para dados em repouso
- 🌐 **TLS 1.3** para dados em trânsito
- 👤 **Controle de acesso** baseado em perfis
- 📱 **Autenticação multifator** para administradores
- 🔍 **Monitoramento 24/7** de segurança

### 8. Prevenção

**Definição:** Adoção de medidas para prevenir danos aos titulares.

**Na Prática UMC:**

**Privacy by Design:**
- 🏗️ **Proteção integrada** desde o desenvolvimento
- 🔒 **Configurações padrão** de privacidade
- 📊 **Anonimização automática** de dados antigos
- 🚨 **Alertas preventivos** de risco

### 9. Não Discriminação

**Definição:** Impossibilidade de tratamento para fins discriminatórios.

**Na Prática UMC:**
- ⚖️ **Código de ética** específico
- 🔍 **Auditoria** de decisões algorítmicas
- 👥 **Comitê de ética** para casos controversos
- 📏 **Critérios objetivos** de avaliação

### 10. Responsabilização

**Definição:** Demonstração da eficácia das medidas de proteção.

**Na Prática UMC:**
- 📋 **Documentação completa** de processos
- 🔍 **Auditoria externa anual**
- 📊 **Métricas de compliance**
- 📝 **Relatórios de atividades**

---

## Bases Legais para Tratamento

### Bases Legais Aplicáveis na UMC

#### 1. Execução de Contrato (Art. 7º, V)

**Aplicação:**
- Dados de **docentes e discentes** vinculados à UMC
- Informações necessárias para **cumprimento de obrigações acadêmicas**
- Dados para **gestão dos programas** de pós-graduação

**Exemplo Prático:**
```
Situação: Upload do Lattes por docente do programa
Base Legal: Execução de contrato de trabalho
Justificativa: Necessário para avaliação de desempenho acadêmico
```

#### 2. Pesquisa por Órgão de Pesquisa (Art. 7º, IV)

**Aplicação:**
- **Análises estatísticas** de produção científica
- **Estudos de colaboração** interinstitucional
- **Métricas de impacto** da pesquisa

**Requisitos Especiais:**
- ✅ **Anonimização** sempre que possível
- ✅ **Finalidade exclusivamente acadêmica**
- ✅ **Garantias de segurança** adequadas

#### 3. Cumprimento de Obrigação Legal (Art. 7º, II)

**Aplicação:**
- **Relatórios CAPES** obrigatórios
- **Prestação de contas** a órgãos de fomento
- **Transparência** de dados públicos

### Consentimento: Quando é Necessário

**Consentimento NÃO é necessário** quando:
- ✅ Dados são necessários para **execução de contrato**
- ✅ Tratamento é para **cumprimento de obrigação legal**
- ✅ Finalidade é **pesquisa acadêmica** com anonimização

**Consentimento É necessário** quando:
- ❗ Dados são para **finalidades secundárias**
- ❗ Compartilhamento para **fins não acadêmicos**
- ❗ Tratamento de **dados sensíveis** sem outra base legal

---

## Direitos dos Titulares

### 1. Direito de Confirmação e Acesso

**O que é:** Obter confirmação sobre o tratamento e acessar os dados.

**Como exercer na UMC:**
1. **Acesse** o portal do sistema Prodmais
2. **Faça login** com suas credenciais UMC
3. **Clique** em "Meus Dados" no menu
4. **Visualize** todas as informações tratadas

**Interface do Sistema:**
```
📱 Meus Dados
├── 📄 Dados Pessoais
├── 📊 Produção Científica
├── 🎓 Orientações
├── 🔗 Colaborações
└── 📈 Histórico de Alterações
```

### 2. Direito de Correção

**O que é:** Corrigir dados incompletos, inexatos ou desatualizados.

**Como exercer:**
1. **Acesse** "Meus Dados" → "Correção"
2. **Indique** quais dados estão incorretos
3. **Anexe** documentação comprobatória
4. **Aguarde** processamento (até 15 dias)

**Exemplo de Correção:**
```
Campo: Nome do periódico
Valor atual: "Journal of Biotecnology"
Valor correto: "Journal of Biotechnology"
Evidência: DOI 10.1016/j.jbiotec.2024.01.001
```

### 3. Direito de Eliminação

**O que é:** Solicitar a exclusão de dados desnecessários ou tratados inadequadamente.

**Limitações no Contexto Acadêmico:**
- ❌ **Não é possível** eliminar dados necessários para obrigações legais
- ❌ **Não é possível** eliminar dados de produções científicas públicas
- ✅ **É possível** eliminar dados pessoais desnecessários

**Processo de Eliminação:**
1. **Solicite** através do canal LGPD
2. **Avaliação** da legitimidade (até 5 dias)
3. **Processamento** da eliminação (até 15 dias)
4. **Confirmação** por email

### 4. Direito de Portabilidade

**O que é:** Obter cópia dos dados em formato estruturado e legível.

**Formatos Disponíveis:**
- 📄 **PDF** - Para leitura e impressão
- 📊 **Excel** - Para análise
- 🌐 **XML** - Compatível com Lattes
- 💾 **JSON** - Para desenvolvedores

**Como solicitar:**
1. **Acesse** "Meus Dados" → "Exportar"
2. **Selecione** o formato desejado
3. **Confirme** sua identidade
4. **Baixe** o arquivo gerado

### 5. Direito de Oposição

**O que é:** Opor-se ao tratamento de dados em determinadas situações.

**Quando é possível:**
- ✅ Tratamento para **finalidades secundárias**
- ✅ **Marketing** ou comunicação promocional
- ✅ **Análises** não obrigatórias

**Quando NÃO é possível:**
- ❌ **Obrigações legais** (relatórios CAPES)
- ❌ **Execução de contrato** (vínculo UMC)
- ❌ **Interesse público**

---

## Boas Práticas Operacionais

### Para Docentes e Pesquisadores

#### Upload do Lattes

**Antes do Upload:**
```
✅ Atualize seu currículo Lattes
✅ Verifique a correção dos dados
✅ Remova informações desnecessárias
✅ Confirme a versão mais recente
```

**Durante o Upload:**
```
✅ Use apenas dados profissionais
✅ Evite informações pessoais excessivas
✅ Verifique o programa correto
✅ Confirme as finalidades do tratamento
```

**Após o Upload:**
```
✅ Valide os dados importados
✅ Corrija inconsistências identificadas
✅ Mantenha backup do arquivo XML
✅ Programe atualizações regulares
```

#### Gestão de Dados de Orientandos

**Coleta de Dados:**
- 📋 **Colete apenas** dados necessários para orientação
- 🎯 **Informe claramente** as finalidades
- 📝 **Documente** o consentimento quando necessário
- 🔒 **Proteja** dados sensíveis

**Compartilhamento:**
- ✅ **Compartilhe apenas** com autorização
- ✅ **Use canais seguros** da UMC
- ✅ **Limite** o acesso ao necessário
- ✅ **Documente** compartilhamentos

### Para Coordenadores de Programa

#### Relatórios CAPES

**Preparação:**
1. **Valide** a completude dos dados
2. **Verifique** a correção das informações
3. **Identifique** dados faltantes
4. **Solicite** atualizações necessárias

**Geração:**
1. **Use apenas** dados dos docentes vinculados
2. **Anonimize** quando possível
3. **Limite** aos dados estritamente necessários
4. **Documente** as escolhas feitas

**Compartilhamento:**
1. **Compartilhe apenas** com destinatários autorizados
2. **Use canais oficiais** da CAPES
3. **Mantenha** logs de acesso
4. **Proteja** durante transmissão

#### Dashboard e Métricas

**Uso Adequado:**
- 📊 **Foque** em métricas agregadas
- 📈 **Evite** identificação individual desnecessária
- 🎯 **Use** para fins de gestão acadêmica
- 🔒 **Restrinja** acesso conforme perfil

### Para Administradores do Sistema

#### Controle de Acesso

**Princípio do Menor Privilégio:**
```
👤 Docente → Acesso aos próprios dados + programa
👥 Coordenador → Acesso ao programa + relatórios
🔧 Administrador → Acesso técnico limitado
🛡️ DPO → Acesso para compliance LGPD
```

**Revisão de Acessos:**
- 🔄 **Revisão trimestral** de permissões
- 📝 **Documentação** de mudanças
- 🚨 **Alerta** para acessos anômalos
- 📊 **Relatório** de atividades

#### Backup e Recuperação

**Estratégia de Backup:**
- 💾 **Backup diário** incremental
- 🗄️ **Backup semanal** completo
- 🔐 **Criptografia** de backups
- 🔄 **Teste mensal** de recuperação

**Retenção de Dados:**
- 📅 **5 anos** para dados ativos
- 📅 **10 anos** para dados históricos
- 🔒 **Anonimização** após prazo
- 🗑️ **Eliminação segura** quando apropriada

---

## Governança de Dados

### Estrutura Organizacional

#### Comitê de Proteção de Dados UMC

**Composição:**
- 👨‍💼 **Pró-Reitor de Pós-Graduação** (Presidente)
- 🛡️ **Encarregado de Proteção de Dados** (DPO)
- 💻 **Coordenador de TI**
- ⚖️ **Assessoria Jurídica**
- 👥 **Representante dos Coordenadores**

**Responsabilidades:**
- 📋 **Definir** políticas de proteção de dados
- 🔍 **Avaliar** novos tratamentos
- 📊 **Monitorar** indicadores de compliance
- 🚨 **Responder** a incidentes significativos

#### Encarregado de Proteção de Dados (DPO)

**Funções Principais:**
- 👥 **Ponto de contato** com titulares e ANPD
- 📚 **Orientação** sobre compliance LGPD
- 🔍 **Auditoria** de processos
- 📝 **Documentação** de atividades

**Contato:**
- 📧 **Email:** lgpd@umc.br
- 📞 **Telefone:** (11) 4798-7000 ramal 1234
- 🏢 **Local:** Prédio da Reitoria, sala 205

### Políticas e Procedimentos

#### Política de Privacidade

**Conteúdo Mínimo:**
- 🎯 **Finalidades** do tratamento
- ⚖️ **Bases legais** utilizadas
- 📋 **Categorias** de dados tratados
- 👥 **Destinatários** de compartilhamento
- ⏰ **Prazo** de retenção
- 🛡️ **Direitos** dos titulares

#### Termos de Uso

**Elementos Essenciais:**
- 📝 **Regras** de utilização do sistema
- 🚫 **Proibições** e limitações
- 📊 **Responsabilidades** dos usuários
- ⚖️ **Jurisdição** aplicável

### Indicadores de Conformidade

#### KPIs de Proteção de Dados

**Indicadores Técnicos:**
- 🎯 **99.9%** de disponibilidade do sistema
- ⚡ **< 24h** para resposta a solicitações
- 🔒 **Zero** incidentes de segurança graves
- 📊 **100%** dos backups testados

**Indicadores de Processo:**
- 📚 **100%** da equipe treinada em LGPD
- 📝 **100%** dos processos documentados
- 🔍 **100%** das auditorias realizadas
- 📞 **< 48h** para resposta no canal LGPD

**Indicadores de Governança:**
- 👥 **4 reuniões/ano** do Comitê
- 📋 **1 DPIA/ano** atualizada
- 🔍 **1 auditoria externa/ano**
- 📊 **1 relatório anual** de atividades

---

## Segurança da Informação

### Medidas Técnicas

#### Criptografia

**Dados em Repouso:**
```
🔐 Algoritmo: AES-256
🔑 Gerenciamento: HSM dedicado
🔄 Rotação: Semestral
📊 Monitoramento: 24/7
```

**Dados em Trânsito:**
```
🌐 Protocolo: TLS 1.3
🔒 Certificado: EV SSL
📱 HSTS: Habilitado
🔧 HPKP: Implementado
```

#### Controle de Acesso

**Autenticação:**
- 👤 **SSO** integrado com Active Directory UMC
- 📱 **MFA** obrigatório para administradores
- 🔑 **Política** de senhas robustas
- ⏰ **Timeout** automático de sessão

**Autorização:**
- 🎭 **RBAC** (Role-Based Access Control)
- 📊 **Princípio** do menor privilégio
- 🔄 **Revisão** trimestral de acessos
- 📝 **Log** de todas as ações

#### Monitoramento e Auditoria

**SIEM (Security Information and Event Management):**
```
🔍 Coleta: Logs de todas as aplicações
📊 Análise: Machine Learning para anomalias
🚨 Alertas: Tempo real para incidentes
📋 Relatórios: Diários, semanais e mensais
```

**Logs de Auditoria:**
- 👤 **Quem:** Identificação do usuário
- 📅 **Quando:** Timestamp preciso
- 🎯 **O quê:** Ação realizada
- 💻 **Onde:** IP e localização
- 📋 **Como:** Detalhes técnicos

### Medidas Organizacionais

#### Políticas de Segurança

**Política de Senhas UMC:**
- 📏 **Mínimo 12 caracteres**
- 🔤 **Maiúsculas, minúsculas, números e símbolos**
- 🚫 **Não reutilização** das últimas 12 senhas
- ⏰ **Expiração** a cada 180 dias
- 🔒 **MFA** obrigatório para contas privilegiadas

**Política de Dispositivos:**
- 💻 **Criptografia** obrigatória em notebooks
- 📱 **MDM** para dispositivos móveis
- 🛡️ **Antivírus** atualizado obrigatório
- 🔄 **Patches** automáticos habilitados

#### Treinamento em Segurança

**Programa de Conscientização:**
- 📚 **Curso online** obrigatório (4h/ano)
- 🎯 **Simulações** de phishing trimestrais
- 📧 **Newsletter** mensal de segurança
- 👥 **Workshops** presenciais semestrais

**Tópicos Abordados:**
- 🔒 **Proteção de dados pessoais**
- 📧 **Segurança de email**
- 🌐 **Navegação segura**
- 📱 **Uso seguro de dispositivos móveis**
- 🎭 **Engenharia social**

---

## Gestão de Incidentes

### Classificação de Incidentes

#### Categoria 1 - Crítico

**Definição:** Violação com alto risco aos direitos dos titulares.

**Exemplos:**
- 🚨 **Vazamento** de dados pessoais para terceiros
- 🔓 **Acesso não autorizado** a dados sensíveis
- 🗄️ **Perda** de backup com dados pessoais

**Tempo de Resposta:** **4 horas**

#### Categoria 2 - Alto

**Definição:** Violação com risco moderado aos direitos dos titulares.

**Exemplos:**
- 📧 **Envio** de email para destinatário errado
- 🔍 **Exposição temporária** de dados em logs
- 💻 **Falha** de sistema com perda de dados

**Tempo de Resposta:** **24 horas**

#### Categoria 3 - Médio

**Definição:** Violação com baixo risco aos direitos dos titulares.

**Exemplos:**
- 📋 **Erro** na classificação de dados
- 📊 **Inconsistência** temporária em relatórios
- 🔄 **Falha** em processo de anonimização

**Tempo de Resposta:** **72 horas**

### Procedimento de Resposta

#### Fase 1 - Detecção e Comunicação Inicial

**Detecção (0-2 horas):**
- 🔍 **Identificação** do incidente
- 📋 **Classificação** inicial
- 👥 **Acionamento** da equipe de resposta
- 📧 **Comunicação** para o DPO

**Equipe de Resposta:**
- 🛡️ **DPO** (Coordenador)
- 💻 **Administrador** de sistemas
- ⚖️ **Assessoria** jurídica
- 👥 **Coordenador** do programa afetado

#### Fase 2 - Contenção e Avaliação

**Contenção (2-4 horas):**
- 🚫 **Isolamento** do sistema afetado
- 🔒 **Bloqueio** de acessos suspeitos
- 💾 **Preservação** de evidências
- 📊 **Avaliação** do escopo do incidente

**Documentação:**
- 📝 **Formulário** de incidente preenchido
- 📷 **Screenshots** das evidências
- 📋 **Lista** de dados afetados
- 👥 **Identificação** dos titulares impactados

#### Fase 3 - Investigação e Comunicação

**Investigação (4-24 horas):**
- 🔍 **Análise** das causas raiz
- 📊 **Quantificação** dos dados afetados
- 🎯 **Identificação** das medidas corretivas
- 📈 **Avaliação** dos riscos aos titulares

**Comunicação:**
- 📞 **ANPD** (se categoria 1, em até 24h)
- 📧 **Titulares** afetados (em até 72h)
- 👥 **Comunidade** acadêmica (se necessário)
- 📰 **Imprensa** (casos excepcionais)

#### Fase 4 - Correção e Prevenção

**Medidas Corretivas:**
- 🛠️ **Correção** das vulnerabilidades
- 🔄 **Restauração** dos serviços
- 📊 **Validação** da correção
- 📝 **Documentação** das mudanças

**Medidas Preventivas:**
- 📚 **Treinamento** adicional
- 🔧 **Melhorias** nos processos
- 🛡️ **Fortalecimento** da segurança
- 📋 **Atualização** de políticas

### Templates de Comunicação

#### Para a ANPD

```
COMUNICAÇÃO DE INCIDENTE DE SEGURANÇA

Controlador: Universidade de Mogi das Cruzes
CNPJ: XX.XXX.XXX/XXXX-XX
DPO: [Nome] - lgpd@umc.br

Data do Incidente: DD/MM/AAAA HH:MM
Data da Detecção: DD/MM/AAAA HH:MM
Categoria: [1-Crítico/2-Alto/3-Médio]

Descrição: [Descrição clara e objetiva]

Dados Afetados: [Tipos e quantidade]
Titulares Impactados: [Número e perfil]

Medidas Adotadas:
- [Lista das medidas tomadas]

Medidas Preventivas:
- [Lista das melhorias implementadas]

Responsável: [Nome e contato]
```

#### Para os Titulares

```
NOTIFICAÇÃO DE INCIDENTE DE SEGURANÇA

Caro(a) [Nome],

Informamos que ocorreu um incidente de segurança 
que pode ter afetado seus dados pessoais no 
Sistema Prodmais UMC.

O QUE ACONTECEU:
[Descrição clara e simples do incidente]

DADOS AFETADOS:
[Lista específica dos dados impactados]

MEDIDAS TOMADAS:
[Ações para correção e prevenção]

SUAS OPÇÕES:
- Acessar seus dados: [link]
- Exercer seus direitos: lgpd@umc.br
- Suporte: (11) 4798-7000

CONTATO:
lgpd@umc.br | (11) 4798-7000

Atenciosamente,
Encarregado de Proteção de Dados
Universidade de Mogi das Cruzes
```

---

## Documentação e Registros

### Registro de Atividades de Tratamento (RAT)

#### Estrutura do RAT UMC

**Seção 1 - Identificação do Controlador:**
- 🏢 **Nome:** Universidade de Mogi das Cruzes
- 📄 **CNPJ:** XX.XXX.XXX/XXXX-XX
- 📧 **Contato:** lgpd@umc.br
- 🛡️ **DPO:** [Nome e contato]

**Seção 2 - Finalidades do Tratamento:**
- 🎯 **Gestão** de programas de pós-graduação
- 📊 **Elaboração** de relatórios CAPES
- 📈 **Análise** de produtividade acadêmica
- 🤝 **Facilitação** de colaborações interinstitucionais

**Seção 3 - Categorias de Dados:**
- 👤 **Dados de identificação** dos pesquisadores
- 🎓 **Dados acadêmicos** e profissionais
- 📚 **Dados de produção científica**
- 🎯 **Dados de orientações** e bancas

**Seção 4 - Categorias de Titulares:**
- 👨‍🏫 **Docentes** permanentes e colaboradores
- 👨‍🎓 **Discentes** de mestrado e doutorado
- 🎓 **Egressos** dos programas
- 🤝 **Pesquisadores** colaboradores externos

### Política de Retenção

#### Prazos de Retenção por Categoria

**Dados de Vinculação Ativa:**
- ⏰ **Prazo:** Durante toda a vinculação + 5 anos
- 🎯 **Finalidade:** Cumprimento de obrigações contratuais
- 📝 **Ação final:** Anonimização ou eliminação

**Dados de Produção Científica:**
- ⏰ **Prazo:** 10 anos após publicação
- 🎯 **Finalidade:** Preservação do patrimônio científico
- 📝 **Ação final:** Anonimização

**Dados de Orientações:**
- ⏰ **Prazo:** 20 anos após defesa
- 🎯 **Finalidade:** Comprovação de titulação
- 📝 **Ação final:** Eliminação de dados pessoais

**Logs de Auditoria:**
- ⏰ **Prazo:** 5 anos
- 🎯 **Finalidade:** Compliance e investigação
- 📝 **Ação final:** Eliminação segura

#### Processo de Anonimização

**Técnicas Utilizadas:**
- 🔄 **Generalização:** Categorização de dados específicos
- 🎯 **Supressão:** Remoção de identificadores diretos
- 🔀 **Perturbação:** Adição de ruído estatístico
- 🔗 **Desvinculação:** Quebra de links entre dados

**Validação da Anonimização:**
- 📊 **Teste** de re-identificação
- 🔍 **Análise** de risco de inferência
- 👥 **Revisão** por especialista
- 📝 **Documentação** do processo

### Auditoria e Compliance

#### Cronograma de Auditorias

**Auditoria Interna (Trimestral):**
- 🔍 **Revisão** de controles de acesso
- 📊 **Validação** de indicadores de compliance
- 📝 **Verificação** de documentação
- 🎯 **Teste** de procedimentos

**Auditoria Externa (Anual):**
- 🏢 **Empresa** especializada em LGPD
- 📋 **Escopo** completo do sistema
- 📊 **Relatório** detalhado de conformidade
- 📝 **Plano** de ação para melhorias

#### Evidências de Compliance

**Documentação Obrigatória:**
- 📋 **DPIA** atualizada anualmente
- 📊 **RAT** revisado semestralmente
- 📝 **Políticas** atualizadas
- 🔍 **Logs** de auditoria completos

**Certificações e Conformidade:**
- 🛡️ **ISO 27001** (em processo)
- 📋 **Auditoria LGPD** anual
- 🔒 **Testes** de penetração semestrais
- 📊 **Relatórios** de vulnerabilidade

---

## Checklist de Conformidade

### ✅ Checklist para Coordenadores

#### Gestão de Dados

```
📋 ANTES DE SOLICITAR DADOS:
□ Finalidade clara e específica definida
□ Base legal identificada
□ Minimização dos dados aplicada
□ Período de retenção definido
□ Medidas de segurança planejadas

📤 DURANTE A COLETA:
□ Informações sobre tratamento fornecidas
□ Consentimento obtido quando necessário
□ Dados coletados limitados ao necessário
□ Qualidade dos dados verificada
□ Registros de coleta mantidos

📊 NO USO DOS DADOS:
□ Uso limitado às finalidades declaradas
□ Acesso restrito a pessoas autorizadas
□ Medidas de segurança implementadas
□ Logs de acesso mantidos
□ Compartilhamento documentado

🗑️ AO FINAL DO PERÍODO:
□ Dados eliminados ou anonimizados
□ Processo de eliminação documentado
□ Backup seguro eliminado
□ Confirmação de eliminação obtida
□ Registros de eliminação mantidos
```

#### Relatórios CAPES

```
📊 PREPARAÇÃO DO RELATÓRIO:
□ Dados validados e atualizados
□ Docentes vinculados confirmados
□ Período de análise definido
□ Critérios de inclusão claros
□ Autorização para uso obtida

📝 GERAÇÃO DO RELATÓRIO:
□ Dados anonimizados quando possível
□ Informações limitadas ao necessário
□ Qualidade dos dados verificada
□ Revisão técnica realizada
□ Controle de versão implementado

📤 ENVIO E COMPARTILHAMENTO:
□ Destinatários autorizados confirmados
□ Canal seguro utilizado
□ Cópia de segurança mantida
□ Logs de envio registrados
□ Prazo de retenção definido
```

### ✅ Checklist para Docentes

#### Upload de Currículos

```
📄 PREPARAÇÃO DO LATTES:
□ Currículo atualizado com dados recentes
□ Informações pessoais desnecessárias removidas
□ Dados de produção científica conferidos
□ Vínculos institucionais atualizados
□ Arquivo XML gerado corretamente

📤 UPLOAD NO SISTEMA:
□ Política de privacidade lida
□ Termos de uso aceitos
□ Programa correto selecionado
□ Finalidades do tratamento compreendidas
□ Upload realizado com sucesso

✅ VALIDAÇÃO DOS DADOS:
□ Dados importados conferidos
□ Inconsistências corrigidas
□ Duplicatas removidas
□ Classificações validadas
□ Aprovação final confirmada
```

#### Gestão de Orientandos

```
👥 COLETA DE DADOS:
□ Dados necessários limitados ao essencial
□ Finalidades claramente comunicadas
□ Base legal identificada
□ Consentimento obtido quando necessário
□ Registros de consentimento mantidos

🔒 PROTEÇÃO DOS DADOS:
□ Acesso restrito aos dados
□ Canais seguros utilizados
□ Backup seguro realizado
□ Compartilhamento limitado
□ Logs de acesso mantidos

📊 USO DOS DADOS:
□ Uso limitado à orientação acadêmica
□ Dados mantidos atualizados
□ Qualidade verificada regularmente
□ Correções realizadas quando necessário
□ Período de retenção respeitado
```

### ✅ Checklist para Administradores

#### Segurança do Sistema

```
🔒 CONTROLE DE ACESSO:
□ Princípio do menor privilégio aplicado
□ Autenticação multifator habilitada
□ Senhas robustas exigidas
□ Acessos revisados trimestralmente
□ Logs de acesso monitorados

🛡️ PROTEÇÃO DE DADOS:
□ Criptografia implementada
□ Backup criptografado e testado
□ Firewall configurado corretamente
□ Antivírus atualizado
□ Patches de segurança aplicados

📊 MONITORAMENTO:
□ SIEM configurado e funcionando
□ Alertas de segurança ativos
□ Logs de auditoria completos
□ Métricas de performance monitoradas
□ Incidentes documentados
```

#### Gestão de Dados

```
💾 ARMAZENAMENTO:
□ Dados classificados adequadamente
□ Localização dos dados documentada
□ Acesso controlado e monitorado
□ Backup regular realizado
□ Teste de recuperação executado

🔄 PROCESSAMENTO:
□ Logs de processamento mantidos
□ Erros identificados e corrigidos
□ Performance monitorada
□ Validação de qualidade realizada
□ Relatórios de status gerados

🗑️ ELIMINAÇÃO:
□ Política de retenção aplicada
□ Eliminação segura realizada
□ Anonimização quando apropriada
□ Registros de eliminação mantidos
□ Confirmação de eliminação obtida
```

### ✅ Checklist para DPO

#### Compliance LGPD

```
📋 DOCUMENTAÇÃO:
□ DPIA atualizada anualmente
□ RAT mantido atualizado
□ Políticas revisadas regularmente
□ Procedimentos documentados
□ Evidências de compliance coletadas

🔍 AUDITORIA:
□ Auditoria interna trimestral
□ Auditoria externa anual
□ Indicadores de compliance monitorados
□ Não conformidades identificadas
□ Planos de ação implementados

📞 RELACIONAMENTO:
□ Canal LGPD funcionando
□ Solicitações respondidas no prazo
□ Comunicação com ANPD quando necessário
□ Treinamento da equipe realizado
□ Conscientização da comunidade promovida
```

#### Gestão de Incidentes

```
🚨 PREPARAÇÃO:
□ Plano de resposta atualizado
□ Equipe de resposta treinada
□ Templates de comunicação prontos
□ Canais de comunicação testados
□ Procedimentos de escalação definidos

🔍 DETECÇÃO:
□ Monitoramento 24/7 ativo
□ Alertas configurados
□ Logs de auditoria analisados
□ Relatórios de incidentes recebidos
□ Classificação inicial realizada

📝 RESPOSTA:
□ Contenção imediata executada
□ Investigação realizada
□ Comunicações enviadas
□ Medidas corretivas implementadas
□ Lições aprendidas documentadas
```

---

## Contatos e Recursos

### Equipe LGPD UMC

**Encarregado de Proteção de Dados (DPO):**
- 👤 **Nome:** Prof. Dr. [Nome]
- 📧 **Email:** lgpd@umc.br
- 📞 **Telefone:** (11) 4798-7000 ramal 1234
- 🏢 **Local:** Prédio da Reitoria, sala 205

**Comitê de Proteção de Dados:**
- 📧 **Email:** comite.lgpd@umc.br
- 📅 **Reuniões:** Primeira quinta-feira do mês
- 🏢 **Local:** Sala de reuniões da Pró-Reitoria

**Suporte Técnico:**
- 📧 **Email:** suporte.prodmais@umc.br
- 📞 **Telefone:** (11) 4798-7000 ramal 5678
- ⏰ **Horário:** Segunda a Sexta, 8h às 18h

### Recursos Externos

**ANPD - Autoridade Nacional de Proteção de Dados:**
- 🌐 **Site:** https://www.gov.br/anpd
- 📧 **Email:** anpd@anpd.gov.br
- 📞 **Telefone:** (61) 2029-5600

**Ministério Público Federal:**
- 🌐 **Site:** http://www.mpf.mp.br
- 📞 **Telefone:** 127 (Disque Direitos Humanos)

### Documentação Adicional

**Leis e Regulamentações:**
- 📄 **LGPD:** Lei 13.709/2018
- 📄 **LAI:** Lei 12.527/2011
- 📄 **Marco Civil:** Lei 12.965/2014

**Guias da ANPD:**
- 📚 **Guia Orientativo** sobre Tratamento de Dados Pessoais
- 📚 **Guia de Boas Práticas** para Pequenos Agentes
- 📚 **Guia de Segurança** da Informação

---

**Documento atualizado em:** 15 de março de 2025  
**Versão:** 1.0  
**Próxima revisão:** 15 de março de 2026  
**Responsável:** DPO UMC - lgpd@umc.br