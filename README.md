# 📅 FuncionalFit – Sistema de Agendamento de Aulas Funcionais

Sistema completo de agendamento e gestão de aulas em grupo, desenvolvido com **Laravel (API)** e **Vue 3 + Vuetify (front-end)**. Ideal para **professores de funcional** que desejam organizar suas turmas com praticidade, atenção individualizada e foco na experiência do aluno.

---

## 🚀 Demonstração

🔗 **Front-end (Cliente)**  
[https://new-landing-seven.vercel.app/](https://new-landing-seven.vercel.app/)

🔗 **Front-end (Dashboard)**  
[https://dash-teacher-fit.vercel.app/login](https://dash-teacher-fit.vercel.app/login)

📦 **Repositórios**
- 💻 [Front-end Cliente](https://github.com/RafaelOlive26sp/newLanding)
- 💼 [Front-end DashBoard](https://github.com/RafaelOlive26sp/dashTeacher_fit)
- 🔙 [Back-end API](https://github.com/RafaelOlive26sp/api_fit)

---

## 🎯 Problema

Professores de funcional ainda dependem de **WhatsApp, cadernos ou planilhas manuais** para controlar agendamentos, pagamentos e presenças — o que gera confusão, perda de dados e retrabalho.

---

## 💡 Solução

Com o **FuncionalFit**, é possível:

- 📋 Cadastrar alunos com histórico físico e dados médicos
- 🗓️ Gerenciar horários semanais com controle de faltas e presença
- 👥 Organizar turmas de até 5 alunos, divididas por nível
- 💰 Acompanhar mensalidades e pagamentos
- 📊 Gerar relatórios por aluno, turma e período
- 🔐 Controlar permissões com autenticação segura e policies

---

## ⚙️ Tecnologias

### 🔧 Back-end (Laravel)
- Laravel 11
- Sanctum (auth)
- Policies & Form Requests
- MySQL
- Migrations + Seeders
- Laravel Reverb (WebSocket)
- Deploy: Railway

### 🎨 Front-end (Vue 3)
- Vue.js 3
- Vuetify 3
- Vue Router
- Axios
- Deploy: Vercel

---
### 📚 Nota de Desenvolvimento
> Este módulo está em desenvolvimento ativo como parte do processo de aprendizado e implementação de WebSockets. Estou explorando e expandindo os recursos gradualmente para garantir uma implementação robusta e eficiente.

---


## 🔌 WebSocket com Laravel Reverb

### 📡 Visão Geral
O FuncionalFit implementa comunicação em tempo real usando Laravel Reverb para proporcionar uma experiência mais dinâmica e interativa aos usuários.

### ⚡ Funcionalidades em Tempo Real
- **Notificações de Turma**: Alunos recebem atualizações instantâneas quando professores modificam informações da turma
- **Em Desenvolvimento**:
    - [ ] Notificações de pagamento
    - [ ] Alertas de cancelamento de aula
    - [ ] Comunicação em tempo real entre professor e aluno

### 🛠️ Configuração WebSocket e Sistema de Filas

```bash
# Instalação do Reverb
composer require laravel/reverb

# Configuração do ambiente (.env)
REVERB_APP_ID=seu_app_id
REVERB_APP_KEY=sua_app_key
REVERB_APP_SECRET=seu_app_secret

# Iniciar servidor WebSocket
php artisan reverb:start

# Em outro terminal, iniciar o worker das filas
php artisan queue:work
```

> **⚠️ Importante**: O sistema utiliza dois processos que precisam estar rodando simultaneamente:
> 1. `reverb:start` - Servidor WebSocket para comunicação em tempo real
> 2. `queue:work` - Worker responsável por processar jobs em segundo plano, utilizando o driver `database` (MySQL). Ele consome os jobs da tabela `jobs`, executa a lógica associada (como disparar eventos WebSocket) e os remove após a execução bem-sucedida.

>
### 📝 Nota sobre o Sistema de Filas
Atualmente, o projeto utiliza o banco de dados MySQL como driver para o sistema de filas. Esta é uma configuração inicial que atende às necessidades atuais do projeto. Está nos planos futuros avaliar e possivelmente migrar para soluções mais robustas como Redis, que pode oferecer melhor performance em determinados cenários de uso.
#### Configuração Atual das Filas:
- **Driver**: Database (MySQL)
- **Tabelas**: `jobs` e `failed_jobs`
- **Futuras Melhorias Planejadas**:
    - [ ] Estudo e possível implementação do Redis
    - [ ] Otimização do processamento de filas
    - [ ] Implementação de monitoramento avançado de jobs


## 🧪 Próximos passos

- [ ] Área para reagendamento por parte do aluno
- [ ] Geração de faturas PDF
- [ ] Sistema de notificações por e-mail ou WhatsApp
- [ ] Dashboard com gráficos de frequência e pagamentos
- [ ] Expandir funcionalidades WebSocket:
    - [ ] Notificações instantâneas de pagamento
    - [ ] Sistema de presença em tempo real




## 🧠 Aprendizados durante o projeto

-- Organização da lógica com **Resource Controllers** no Laravel
- Uso avançado de **Policies** para controle de acesso
- Aplicação do conceito de SOLID, como SRP,DIP
- Criação de um **painel administrativo e responsivo** com Vuetify
- Manipulação segura de **dados sensíveis e relacionamentos complexos** no banco de dados
- Separação de responsabilidades entre front e API RESTful
- Implantação full-stack com Railway (API) e Vercel (front)
- **Implementação de WebSockets** para comunicação em tempo real
- Gerenciamento de eventos e canais com Laravel Reverb




---

## 🧪 Próximos passos

- [ ] Área para reagendamento por parte do aluno
- [ ] Geração de faturas PDF
- [ ] Sistema de notificações por e-mail ou WhatsApp
- [ ] Dashboard com gráficos de frequência e pagamentos

---

## 📥 Instalação local

### Back-end
```bash
git clone https://github.com/seunome/api-projeto.git
cd api-projeto
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
