<?php

/**
 * Configuração Específica para Universidade de Mogi das Cruzes (UMC)
 * Sistema Prodmais - Implementação Institucional
 * 
 * Este arquivo contém configurações específicas para os 4 Programas de 
 * Pós-Graduação da UMC conforme objetivos do projeto PIVIC 2025.
 */

return [
    // ================================
    // INFORMAÇÕES INSTITUCIONAIS UMC
    // ================================
    'institution' => [
        'name' => 'Universidade de Mogi das Cruzes',
        'short_name' => 'UMC',
        'logo_url' => '/img/logo_umc.png',
        'website' => 'https://www.umc.br',
        'contact_email' => 'pos-graduacao@umc.br',
        'address' => 'Av. Dr. Cândido Xavier de Almeida e Souza, 200 - Mogi das Cruzes/SP'
    ],

    // ================================
    // PROGRAMAS DE PÓS-GRADUAÇÃO UMC
    // ================================
    'postgraduate_programs' => [
        'biotecnologia' => [
            'name' => 'Biotecnologia',
            'code' => 'PPG-BIO',
            'level' => ['mestrado', 'doutorado'],
            'coordinator' => '',
            'email' => 'biotecnologia@umc.br',
            'areas_concentracao' => [
                'Biotecnologia Aplicada à Saúde',
                'Biotecnologia Ambiental',
                'Biotecnologia Industrial'
            ],
            'linhas_pesquisa' => [
                'Biologia Molecular e Celular',
                'Biotecnologia e Meio Ambiente',
                'Desenvolvimento de Produtos Biotecnológicos'
            ]
        ],
        'engenharia_biomedica' => [
            'name' => 'Engenharia Biomédica',
            'code' => 'PPG-EBM',
            'level' => ['mestrado', 'doutorado'],
            'coordinator' => '',
            'email' => 'biomedica@umc.br',
            'areas_concentracao' => [
                'Bioengenharia',
                'Engenharia Clínica',
                'Processamento de Sinais Biomédicos'
            ],
            'linhas_pesquisa' => [
                'Instrumentação Biomédica',
                'Biomateriais e Engenharia de Tecidos',
                'Processamento de Imagens Médicas'
            ]
        ],
        'politicas_publicas' => [
            'name' => 'Políticas Públicas',
            'code' => 'PPG-PP',
            'level' => ['mestrado'],
            'coordinator' => '',
            'email' => 'politicas@umc.br',
            'areas_concentracao' => [
                'Análise de Políticas Públicas',
                'Gestão Pública',
                'Políticas Sociais'
            ],
            'linhas_pesquisa' => [
                'Políticas de Saúde',
                'Políticas Educacionais',
                'Políticas de Desenvolvimento Regional'
            ]
        ],
        'ciencia_tecnologia_saude' => [
            'name' => 'Ciência e Tecnologia em Saúde',
            'code' => 'PPG-CTS',
            'level' => ['mestrado', 'doutorado'],
            'coordinator' => '',
            'email' => 'ctsaude@umc.br',
            'areas_concentracao' => [
                'Inovação Tecnológica em Saúde',
                'Epidemiologia e Saúde Coletiva',
                'Gestão em Saúde'
            ],
            'linhas_pesquisa' => [
                'Tecnologias Diagnósticas',
                'Sistemas de Informação em Saúde',
                'Avaliação de Tecnologias em Saúde'
            ]
        ]
    ],

    // ================================
    // CONFIGURAÇÕES LGPD ESPECÍFICAS
    // ================================
    'lgpd' => [
        'enabled' => true,
        'dpo_contact' => 'dpo@umc.br',
        'data_controller' => 'Universidade de Mogi das Cruzes',
        'legal_basis' => 'Art. 7º, §4º da LGPD - dados manifestamente públicos',
        'retention_period' => 'Conforme regulamento CAPES',
        'consent_required' => false, // dados públicos da Plataforma Lattes
        'audit_enabled' => true,
        'dpia_required' => true,
        'anonymization_levels' => [
            'public' => 'Dados públicos sem anonimização',
            'restricted' => 'Dados com identificação restrita',
            'anonymous' => 'Dados totalmente anonimizados'
        ]
    ],

    // ================================
    // FILTROS ESPECÍFICOS UMC
    // ================================
    'custom_filters' => [
        'programa_ppg' => [
            'label' => 'Programa de Pós-Graduação',
            'field' => 'programa_ppg',
            'type' => 'select',
            'options' => [
                'biotecnologia' => 'Biotecnologia',
                'engenharia_biomedica' => 'Engenharia Biomédica',
                'politicas_publicas' => 'Políticas Públicas',
                'ciencia_tecnologia_saude' => 'Ciência e Tecnologia em Saúde'
            ]
        ],
        'linha_pesquisa' => [
            'label' => 'Linha de Pesquisa',
            'field' => 'linha_pesquisa',
            'type' => 'select',
            'dependent_on' => 'programa_ppg'
        ],
        'campus' => [
            'label' => 'Campus',
            'field' => 'campus',
            'type' => 'select',
            'options' => [
                'mogi_cruzes' => 'Mogi das Cruzes',
                'vila_olimpia' => 'Vila Olímpia'
            ]
        ],
        'indexacao' => [
            'label' => 'Base de Indexação',
            'field' => 'indexacao',
            'type' => 'multiselect',
            'options' => [
                'scopus' => 'Scopus',
                'wos' => 'Web of Science',
                'scielo' => 'SciELO',
                'pubmed' => 'PubMed',
                'qualis' => 'Qualis CAPES',
                'nacional' => 'Base Nacional',
                'internacional' => 'Base Internacional'
            ]
        ],
        'nivel_formacao' => [
            'label' => 'Nível de Formação',
            'field' => 'nivel_formacao',
            'type' => 'select',
            'options' => [
                'mestrado' => 'Mestrado',
                'doutorado' => 'Doutorado',
                'pos_doutorado' => 'Pós-Doutorado'
            ]
        ]
    ],

    // ================================
    // MÉTRICAS INSTITUCIONAIS
    // ================================
    'institutional_metrics' => [
        'capes_indicators' => [
            'producao_intelectual' => [
                'weight' => 0.35,
                'sub_indicators' => [
                    'artigos_periodicos',
                    'livros_capitulos',
                    'trabalhos_eventos'
                ]
            ],
            'formacao_recursos_humanos' => [
                'weight' => 0.35,
                'sub_indicators' => [
                    'teses_dissertacoes',
                    'orientacoes_andamento',
                    'supervisoes_pos_doc'
                ]
            ],
            'impacto_sociedade' => [
                'weight' => 0.10,
                'sub_indicators' => [
                    'produtos_tecnicos',
                    'patentes',
                    'transferencia_tecnologia'
                ]
            ],
            'internacionalizacao' => [
                'weight' => 0.20,
                'sub_indicators' => [
                    'colaboracoes_internacionais',
                    'publicacoes_internacionais',
                    'intercambios'
                ]
            ]
        ],
        'quality_indicators' => [
            'h_index_medio',
            'citacoes_por_docente',
            'percentual_qualis_a',
            'colaboracoes_interinstitucionais'
        ]
    ],

    // ================================
    // INTEGRAÇÕES ESPECÍFICAS
    // ================================
    'integrations' => [
        'brcris' => [
            'enabled' => true,
            'api_url' => 'https://brcris.ibict.br/api',
            'institution_id' => 'UMC',
            'sync_frequency' => 'daily'
        ],
        'sucupira' => [
            'enabled' => true,
            'program_codes' => [
                '31075010001P0', // Exemplo para Biotecnologia
                '31075010002P7', // Exemplo para Eng. Biomédica
                '31075010003P3', // Exemplo para Políticas Públicas
                '31075010004P0'  // Exemplo para C&T em Saúde
            ]
        ],
        'repositorio_umc' => [
            'enabled' => true,
            'url' => 'https://repositorio.umc.br',
            'oai_pmh' => 'https://repositorio.umc.br/oai'
        ]
    ],

    // ================================
    // CONFIGURAÇÕES DE RELATÓRIOS
    // ================================
    'reports' => [
        'capes_autoavaliacao' => [
            'template_path' => '/templates/capes_autoavaliacao.php',
            'periods' => ['trienal', 'quadrienal'],
            'sections' => [
                'proposta_programa',
                'corpo_docente',
                'corpo_discente',
                'producao_intelectual',
                'insercao_social'
            ]
        ],
        'relatorio_quadrienal' => [
            'template_path' => '/templates/relatorio_quadrienal.php',
            'metrics_required' => [
                'producao_bibliografica',
                'producao_tecnica',
                'orientacoes_concluidas',
                'projetos_pesquisa'
            ]
        ],
        'dashboard_coordenacao' => [
            'template_path' => '/templates/dashboard_coordenacao.php',
            'widgets' => [
                'producao_mensal',
                'ranking_docentes',
                'colaboracoes_externas',
                'impacto_citations'
            ]
        ]
    ],

    // ================================
    // CONFIGURAÇÕES DE VALIDAÇÃO
    // ================================
    'validation' => [
        'technical_tests' => [
            'data_integrity' => true,
            'performance_metrics' => true,
            'security_compliance' => true,
            'lgpd_compliance' => true
        ],
        'functional_tests' => [
            'user_experience' => true,
            'coordinator_approval' => true,
            'faculty_feedback' => true
        ],
        'institutional_tests' => [
            'ethics_committee' => true,
            'legal_review' => true,
            'dpia_assessment' => true
        ]
    ],

    // ================================
    // CONFIGURAÇÕES DE ACESSO
    // ================================
    'access_control' => [
        'roles' => [
            'coordenador_ppg' => [
                'permissions' => ['view_all_program_data', 'export_reports', 'manage_faculty'],
                'programs' => [] // será preenchido dinamicamente
            ],
            'docente_permanente' => [
                'permissions' => ['view_own_data', 'update_profile', 'export_own_data'],
                'programs' => [] // será preenchido dinamicamente
            ],
            'secretario_ppg' => [
                'permissions' => ['view_program_data', 'export_basic_reports'],
                'programs' => [] // será preenchido dinamicamente
            ],
            'administrador_sistema' => [
                'permissions' => ['full_access'],
                'programs' => ['all']
            ]
        ],
        'authentication' => [
            'ldap_enabled' => false, // para implementação futura
            'local_auth' => true,
            'session_timeout' => 3600
        ]
    ],

    // ================================
    // CONFIGURAÇÕES DE BACKUP UMC
    // ================================
    'backup' => [
        'enabled' => true,
        'frequency' => 'daily',
        'retention_policy' => [
            'daily' => 30,   // 30 dias
            'weekly' => 12,  // 12 semanas
            'monthly' => 12, // 12 meses
            'yearly' => 5    // 5 anos
        ],
        'notification_email' => 'ti@umc.br',
        'include_personal_data' => false // LGPD compliance
    ]
];