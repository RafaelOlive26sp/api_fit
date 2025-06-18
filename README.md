# 📅 FuncionalFit – Sistema de Agendamento de Aulas Funcionais

Sistema completo de agendamento e gestão de aulas em grupo, desenvolvido com **Laravel (API)** e **Vue 3 + Vuetify (front-end)**, pensado para **professores de funcional** que querem organizar suas turmas com praticidade, atenção individualizada e foco na experiência do aluno.

---

## 🚀 Demonstração


🔗 **Front-end em produção Cliente**: [https://new-landing-seven.vercel.app/](https://new-landing-seven.vercel.app/)  
🔗 **Front-end em produção DashBoard**: [https://dash-teacher-fit.vercel.app/login](https://dash-teacher-fit.vercel.app/login)  
📦 **Repositório front-end Cliente**: [https://github.com/RafaelOlive26sp/newLanding](https://github.com/RafaelOlive26sp/newLanding)  
📦 **Repositório front-end DashBoard**: [https://github.com/RafaelOlive26sp/dashTeacher_fit](https://github.com/RafaelOlive26sp/dashTeacher_fit)

📦 **Repositório back-end Api**: [https://github.com/RafaelOlive26sp/api_fit](https://github.com/RafaelOlive26sp/api_fit)


---

## 🎯 Problema que o sistema resolve

Muitos professores de funcional ainda usam **WhatsApp e planilhas manuais** para organizar agendamentos, controlar pagamentos e lidar com faltas ou reagendamentos. Isso gera confusão, perda de dados e muito retrabalho.

---

## 💡 Solução

O **FuncionalFit** oferece uma interface simples e poderosa para:

- 📋 Cadastrar alunos com histórico físico e dados médicos
- 🗓️ Gerenciar horários semanais com regras de presença e faltas
- 👨‍🏫 Organizar turmas de até 5 alunos por nível de condicionamento
- 💰 Acompanhar pagamentos mensais
- 📊 Gerar relatórios por aluno, turma e mês
- 🔐 Controlar permissões com autenticação e políticas de acesso

---

## 🛠️ Tecnologias utilizadas

### Back-end (Laravel)
- Laravel 11
- Sanctum (autenticação)
- Policies e Form Requests
- MySQL
- Migrations + Seeders
- Laravel Reverb (WebSocket)
- Deploy: Railway


### Front-end (Vue 3)
- Vue 3 (Composition API)
- Vue Router & Vuex
- Vuetify 3 (UI)
- Axios
- Deploy: RailWay

---
### 📚 Nota de Desenvolvimento
> Este módulo está em desenvolvimento ativo como parte do processo de aprendizado e implementação de WebSockets. Estamos explorando e expandindo os recursos gradualmente para garantir uma implementação robusta e eficiente.

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

### 🛠️ Configuração WebSocket

# Instalação do Reverb
composer require laravel/reverb
# Configuração do ambiente (.env)
REVERB_APP_ID=seu_app_id REVERB_APP_KEY=sua_app_key REVERB_APP_SECRET=seu_app_secret
# Iniciar servidor WebSocket
php artisan reverb:start

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
