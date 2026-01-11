BEGIN;

DO $$
DECLARE
    -- 1. Variáveis para IDs dos Instrutores (UUID)
    v_inst_caroline UUID;
    v_inst_pierre   UUID;
    v_inst_davi     UUID;
    v_inst_douglas  UUID;
    v_inst_israel   UUID;
    v_inst_theo     UUID;
    v_inst_mirella  UUID;
    v_inst_genival  UUID;
    v_inst_higor    UUID;
    v_inst_roberta  UUID;

    -- 2. Variáveis para Origens (BIGINT/INTEGER pois parecem ser numéricos no seu banco)
    v_origin_frei   BIGINT;
    v_origin_fatima BIGINT;
    v_origin_paulo  BIGINT;
    v_origin_brand  BIGINT;

    -- 3. Variáveis para as Turmas (BIGINT/INTEGER)
    -- O erro "uuid: 6" indica que essas tabelas retornam números (1, 2... 6...)
    v_c_sensibilidade   BIGINT;
    v_c_diversidade     BIGINT;
    v_c_forca           BIGINT;
    v_c_conquista       BIGINT;
    v_c_futuro          BIGINT;
    v_c_confianca       BIGINT;
    v_c_cooperacao      BIGINT;
    v_c_coletividade    BIGINT;
    v_c_convivencia     BIGINT;
    v_c_luz             BIGINT;
    v_c_superacao       BIGINT;
    v_c_determinacao    BIGINT;

    -- 4. Variável auxiliar para relatórios (UUID)
    v_report_id UUID;
BEGIN

    -- ------------------------------------------------------------------
    -- 1. USUÁRIOS
    -- ------------------------------------------------------------------
    
    -- Admin e Manager
    INSERT INTO users (id, name, email, password, role, phone, cpf, email_verified_at, created_at, updated_at)
    VALUES 
    (gen_random_uuid(), 'Camila', 'camila@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'manager', '11999999999', '14809774465', NOW(), NOW(), NOW()),
    (gen_random_uuid(), 'Admin',  'admin@gmail.com',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin',   '11999999999', '14809774460', NOW(), NOW(), NOW())
    ON CONFLICT (email) DO NOTHING;

    -- Instrutores (Capturando IDs UUID)
    INSERT INTO users (id, name, email, password, role, phone, cpf, email_verified_at, created_at, updated_at) VALUES (gen_random_uuid(), 'Caroline', 'caroline@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', '11988887777', '11122233301', NOW(), NOW(), NOW()) ON CONFLICT (email) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_inst_caroline;
    INSERT INTO users (id, name, email, password, role, phone, cpf, email_verified_at, created_at, updated_at) VALUES (gen_random_uuid(), 'Pierre',   'pierre@gmail.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', '11988887777', '11122233302', NOW(), NOW(), NOW()) ON CONFLICT (email) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_inst_pierre;
    INSERT INTO users (id, name, email, password, role, phone, cpf, email_verified_at, created_at, updated_at) VALUES (gen_random_uuid(), 'Davi',     'davi@gmail.com',     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', '11988887777', '11122233303', NOW(), NOW(), NOW()) ON CONFLICT (email) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_inst_davi;
    INSERT INTO users (id, name, email, password, role, phone, cpf, email_verified_at, created_at, updated_at) VALUES (gen_random_uuid(), 'Douglas',  'douglas@gmail.com',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', '11988887777', '11122233304', NOW(), NOW(), NOW()) ON CONFLICT (email) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_inst_douglas;
    INSERT INTO users (id, name, email, password, role, phone, cpf, email_verified_at, created_at, updated_at) VALUES (gen_random_uuid(), 'Israel',   'israel@gmail.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', '11988887777', '11122233305', NOW(), NOW(), NOW()) ON CONFLICT (email) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_inst_israel;
    INSERT INTO users (id, name, email, password, role, phone, cpf, email_verified_at, created_at, updated_at) VALUES (gen_random_uuid(), 'Theo',     'theo@gmail.com',     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', '11988887777', '11122233306', NOW(), NOW(), NOW()) ON CONFLICT (email) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_inst_theo;
    INSERT INTO users (id, name, email, password, role, phone, cpf, email_verified_at, created_at, updated_at) VALUES (gen_random_uuid(), 'Mirella',  'mirella@gmail.com',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', '11988887777', '11122233307', NOW(), NOW(), NOW()) ON CONFLICT (email) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_inst_mirella;
    INSERT INTO users (id, name, email, password, role, phone, cpf, email_verified_at, created_at, updated_at) VALUES (gen_random_uuid(), 'Genival',  'genival@gmail.com',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', '11988887777', '11122233308', NOW(), NOW(), NOW()) ON CONFLICT (email) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_inst_genival;
    INSERT INTO users (id, name, email, password, role, phone, cpf, email_verified_at, created_at, updated_at) VALUES (gen_random_uuid(), 'Higor',    'higor@gmail.com',    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', '11988887777', '11122233309', NOW(), NOW(), NOW()) ON CONFLICT (email) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_inst_higor;
    INSERT INTO users (id, name, email, password, role, phone, cpf, email_verified_at, created_at, updated_at) VALUES (gen_random_uuid(), 'Roberta',  'roberta@gmail.com',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', '11988887777', '11122233310', NOW(), NOW(), NOW()) ON CONFLICT (email) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_inst_roberta;


    -- ------------------------------------------------------------------
    -- 2. ORIGENS DAS TURMAS
    -- ------------------------------------------------------------------
    -- Como a chave primária parece ser SERIAL (Inteiro), não passamos ID no insert.
    INSERT INTO school_class_origins (name, created_at, updated_at) VALUES ('Frei Damião', NOW(), NOW()) ON CONFLICT (name) DO NOTHING;
    INSERT INTO school_class_origins (name, created_at, updated_at) VALUES ('Fatima de Lira', NOW(), NOW()) ON CONFLICT (name) DO NOTHING;
    INSERT INTO school_class_origins (name, created_at, updated_at) VALUES ('Paulo Bandeira', NOW(), NOW()) ON CONFLICT (name) DO NOTHING;
    INSERT INTO school_class_origins (name, created_at, updated_at) VALUES ('Bradão Lima', NOW(), NOW()) ON CONFLICT (name) DO NOTHING;
    INSERT INTO school_class_origins (name, created_at, updated_at) VALUES ('Outro', NOW(), NOW()) ON CONFLICT (name) DO NOTHING;

    -- Seleciona IDs Numéricos
    SELECT id INTO v_origin_frei FROM school_class_origins WHERE name = 'Frei Damião';
    SELECT id INTO v_origin_fatima FROM school_class_origins WHERE name = 'Fatima de Lira';
    SELECT id INTO v_origin_paulo FROM school_class_origins WHERE name = 'Paulo Bandeira';
    SELECT id INTO v_origin_brand FROM school_class_origins WHERE name = 'Bradão Lima';


    -- ------------------------------------------------------------------
    -- 3. TURMAS (Salvando IDs Inteiros)
    -- ------------------------------------------------------------------
    -- O uso de RETURNING id aqui vai retornar o inteiro (ex: 1, 2, ... 6) e salvar nas variáveis BIGINT.
    
    -- Frei Damião
    INSERT INTO school_classes (name, school_class_origin_id, created_at, updated_at) VALUES ('Sensibilidade', v_origin_frei, NOW(), NOW()) ON CONFLICT (name) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_c_sensibilidade;
    INSERT INTO school_classes (name, school_class_origin_id, created_at, updated_at) VALUES ('Diversidade',   v_origin_frei, NOW(), NOW()) ON CONFLICT (name) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_c_diversidade;
    INSERT INTO school_classes (name, school_class_origin_id, created_at, updated_at) VALUES ('Força',         v_origin_frei, NOW(), NOW()) ON CONFLICT (name) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_c_forca;

    -- Fatima de Lira
    INSERT INTO school_classes (name, school_class_origin_id, created_at, updated_at) VALUES ('Conquista',     v_origin_fatima, NOW(), NOW()) ON CONFLICT (name) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_c_conquista;
    INSERT INTO school_classes (name, school_class_origin_id, created_at, updated_at) VALUES ('Futuro',        v_origin_fatima, NOW(), NOW()) ON CONFLICT (name) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_c_futuro;
    INSERT INTO school_classes (name, school_class_origin_id, created_at, updated_at) VALUES ('Confiança',     v_origin_fatima, NOW(), NOW()) ON CONFLICT (name) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_c_confianca; -- Aqui devia estar gerando o ID 6

    -- Paulo Bandeira
    INSERT INTO school_classes (name, school_class_origin_id, created_at, updated_at) VALUES ('Cooperação',    v_origin_paulo, NOW(), NOW()) ON CONFLICT (name) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_c_cooperacao;
    INSERT INTO school_classes (name, school_class_origin_id, created_at, updated_at) VALUES ('Coletividade',  v_origin_paulo, NOW(), NOW()) ON CONFLICT (name) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_c_coletividade;
    INSERT INTO school_classes (name, school_class_origin_id, created_at, updated_at) VALUES ('Convivência',   v_origin_paulo, NOW(), NOW()) ON CONFLICT (name) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_c_convivencia;

    -- Bradão Lima
    INSERT INTO school_classes (name, school_class_origin_id, created_at, updated_at) VALUES ('Luz',           v_origin_brand, NOW(), NOW()) ON CONFLICT (name) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_c_luz;
    INSERT INTO school_classes (name, school_class_origin_id, created_at, updated_at) VALUES ('Superação',     v_origin_brand, NOW(), NOW()) ON CONFLICT (name) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_c_superacao;
    INSERT INTO school_classes (name, school_class_origin_id, created_at, updated_at) VALUES ('Determinação',  v_origin_brand, NOW(), NOW()) ON CONFLICT (name) DO UPDATE SET updated_at = NOW() RETURNING id INTO v_c_determinacao;


    -- ------------------------------------------------------------------
    -- 4. RELATÓRIOS E AULAS
    -- ------------------------------------------------------------------

    -- Caroline
    v_report_id := gen_random_uuid();
    INSERT INTO workshop_reports (id, report_date, extra_activities, extra_activities_description, materials_provided, grid_provided, observations, feedback, instructor_id, created_at, updated_at) 
    VALUES (v_report_id, CURRENT_DATE - INTERVAL '10 days', false, NULL, true, true, 'Alunos muito participativos hoje.', 'A dinâmica de grupo funcionou muito bem.', v_inst_caroline, NOW(), NOW());
    
    INSERT INTO workshop_report_school_classes (id, time, workshop_theme, workshop_report_id, school_class_id, created_at, updated_at) VALUES 
    (gen_random_uuid(), '08:00', 'Artesanato', v_report_id, v_c_sensibilidade, NOW(), NOW()),
    (gen_random_uuid(), '09:30', 'Tecnologia', v_report_id, v_c_diversidade, NOW(), NOW()),
    (gen_random_uuid(), '10:15', 'Tecnologia', v_report_id, v_c_forca, NOW(), NOW()),
    (gen_random_uuid(), '11:00', 'Tecnologia', v_report_id, v_c_conquista, NOW(), NOW());

    v_report_id := gen_random_uuid();
    INSERT INTO workshop_reports (id, report_date, extra_activities, extra_activities_description, materials_provided, grid_provided, feedback, instructor_id, created_at, updated_at) 
    VALUES (v_report_id, CURRENT_DATE - INTERVAL '20 days', true, 'Dinâmica de quebra-gelo', true, true, 'Excelente evolução da turma.', v_inst_caroline, NOW(), NOW());
    
    INSERT INTO workshop_report_school_classes (id, time, workshop_theme, workshop_report_id, school_class_id, created_at, updated_at) VALUES 
    (gen_random_uuid(), '13:00', 'Dança', v_report_id, v_c_futuro, NOW(), NOW()),
    (gen_random_uuid(), '13:45', 'Música', v_report_id, v_c_confianca, NOW(), NOW()),
    (gen_random_uuid(), '14:30', 'Dança', v_report_id, v_c_cooperacao, NOW(), NOW()),
    (gen_random_uuid(), '15:15', 'Música', v_report_id, v_c_coletividade, NOW(), NOW());

    -- Pierre
    v_report_id := gen_random_uuid();
    INSERT INTO workshop_reports (id, report_date, instructor_id, feedback, created_at, updated_at) 
    VALUES (v_report_id, CURRENT_DATE - INTERVAL '5 days', v_inst_pierre, 'Excelente evolução da turma.', NOW(), NOW());
    
    INSERT INTO workshop_report_school_classes (id, time, workshop_theme, workshop_report_id, school_class_id, created_at, updated_at) VALUES 
    (gen_random_uuid(), '08:45', 'Fotografia', v_report_id, v_c_convivencia, NOW(), NOW()),
    (gen_random_uuid(), '13:45', 'Socialização', v_report_id, v_c_luz, NOW(), NOW());

    -- Davi
    v_report_id := gen_random_uuid();
    INSERT INTO workshop_reports (id, report_date, instructor_id, feedback, created_at, updated_at) 
    VALUES (v_report_id, CURRENT_DATE - INTERVAL '2 days', v_inst_davi, 'Atividade concluída com sucesso.', NOW(), NOW());
    
    INSERT INTO workshop_report_school_classes (id, time, workshop_theme, workshop_report_id, school_class_id, created_at, updated_at) VALUES 
    (gen_random_uuid(), '10:15', 'Robótica', v_report_id, v_c_superacao, NOW(), NOW()),
    (gen_random_uuid(), '15:15', 'Literatura', v_report_id, v_c_determinacao, NOW(), NOW());

    -- Douglas
    v_report_id := gen_random_uuid();
    INSERT INTO workshop_reports (id, report_date, instructor_id, feedback, created_at, updated_at) 
    VALUES (v_report_id, CURRENT_DATE - INTERVAL '12 days', v_inst_douglas, 'Alunos engajados.', NOW(), NOW());
    
    INSERT INTO workshop_report_school_classes (id, time, workshop_theme, workshop_report_id, school_class_id, created_at, updated_at) VALUES 
    (gen_random_uuid(), '08:00', 'Música', v_report_id, v_c_sensibilidade, NOW(), NOW()),
    (gen_random_uuid(), '09:30', 'Tecnologia', v_report_id, v_c_diversidade, NOW(), NOW());

    -- Israel
    v_report_id := gen_random_uuid();
    INSERT INTO workshop_reports (id, report_date, feedback, instructor_id, created_at, updated_at) 
    VALUES (v_report_id, CURRENT_DATE - INTERVAL '3 days', 'Excelente evolução da turma.', v_inst_israel, NOW(), NOW());
    
    INSERT INTO workshop_report_school_classes (id, time, workshop_theme, workshop_report_id, school_class_id, created_at, updated_at) VALUES 
    (gen_random_uuid(), '13:00', 'Dança', v_report_id, v_c_forca, NOW(), NOW()),
    (gen_random_uuid(), '14:30', 'Música', v_report_id, v_c_conquista, NOW(), NOW());

    -- Theo
    v_report_id := gen_random_uuid();
    INSERT INTO workshop_reports (id, report_date, feedback, instructor_id, created_at, updated_at) 
    VALUES (v_report_id, CURRENT_DATE - INTERVAL '8 days', 'Atividade concluida com sucesso.', v_inst_theo, NOW(), NOW());
    
    INSERT INTO workshop_report_school_classes (id, time, workshop_theme, workshop_report_id, school_class_id, created_at, updated_at) VALUES 
    (gen_random_uuid(), '08:45', 'Artesanato', v_report_id, v_c_futuro, NOW(), NOW()),
    (gen_random_uuid(), '10:15', 'Robótica', v_report_id, v_c_confianca, NOW(), NOW());

    -- Mirella
    v_report_id := gen_random_uuid();
    INSERT INTO workshop_reports (id, report_date, feedback, instructor_id, created_at, updated_at) 
    VALUES (v_report_id, CURRENT_DATE - INTERVAL '15 days', 'Alunos engajados.', v_inst_mirella, NOW(), NOW());
    
    INSERT INTO workshop_report_school_classes (id, time, workshop_theme, workshop_report_id, school_class_id, created_at, updated_at) VALUES 
    (gen_random_uuid(), '08:00', 'Fotografia', v_report_id, v_c_cooperacao, NOW(), NOW()),
    (gen_random_uuid(), '09:30', 'Socialização', v_report_id, v_c_coletividade, NOW(), NOW());

    -- Genival
    v_report_id := gen_random_uuid();
    INSERT INTO workshop_reports (id, report_date, feedback, instructor_id, created_at, updated_at) 
    VALUES (v_report_id, CURRENT_DATE - INTERVAL '4 days', 'Excelente trabalho.', v_inst_genival, NOW(), NOW());
    
    INSERT INTO workshop_report_school_classes (id, time, workshop_theme, workshop_report_id, school_class_id, created_at, updated_at) VALUES 
    (gen_random_uuid(), '13:00', 'Tecnologia', v_report_id, v_c_convivencia, NOW(), NOW());

    -- Higor
    v_report_id := gen_random_uuid();
    INSERT INTO workshop_reports (id, report_date, feedback, instructor_id, created_at, updated_at) 
    VALUES (v_report_id, CURRENT_DATE - INTERVAL '1 day', 'Relevante evolução da turma.', v_inst_higor, NOW(), NOW());
    
    INSERT INTO workshop_report_school_classes (id, time, workshop_theme, workshop_report_id, school_class_id, created_at, updated_at) VALUES 
    (gen_random_uuid(), '08:45', 'Música', v_report_id, v_c_luz, NOW(), NOW()),
    (gen_random_uuid(), '10:15', 'Dança', v_report_id, v_c_superacao, NOW(), NOW());

    -- Roberta
    v_report_id := gen_random_uuid();
    INSERT INTO workshop_reports (id, report_date, feedback, instructor_id, created_at, updated_at) 
    VALUES (v_report_id, CURRENT_DATE - INTERVAL '6 days', 'Produtividade alta.', v_inst_roberta, NOW(), NOW());
    
    INSERT INTO workshop_report_school_classes (id, time, workshop_theme, workshop_report_id, school_class_id, created_at, updated_at) VALUES 
    (gen_random_uuid(), '09:30', 'Literatura', v_report_id, v_c_determinacao, NOW(), NOW()),
    (gen_random_uuid(), '13:00', 'Artesanato', v_report_id, v_c_sensibilidade, NOW(), NOW());

END $$;

COMMIT;