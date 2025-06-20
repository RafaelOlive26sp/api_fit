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
- Pusher (WebSocket)
- Deploy: Railway

### 🎨 Front-end (Vue 3)
- Vue.js 3
- Vuetify 3
- Vue Router
- Axios
- Pusher JS
- Deploy: Vercel

---
### 📚 Nota de Desenvolvimento

> Este módulo está em desenvolvimento ativo como parte do processo de aprendizado e implementação de WebSockets. Estamos explorando e expandindo os recursos gradualmente para garantir uma implementação robusta e eficiente.

---

## 🔌 WebSocket com Pusher

### 📡 Visão Geral
O FuncionalFit implementa comunicação em tempo real usando **Pusher** para proporcionar uma experiência mais dinâmica e interativa aos usuários, garantindo notificações instantâneas e atualizações em tempo real.

### ⚡ Funcionalidades em Tempo Real
- **Notificações Privadas**: Sistema de canais privados para notificações direcionadas a usuários específicos
- **Notificações de Turma**: Alunos recebem atualizações instantâneas quando professores modificam informações da turma
- **Comunicação Segura**: Autenticação de canais privados garantindo que apenas usuários autorizados recebam notificações específicas

### 🔐 Canais Privados
O sistema utiliza **canais privados do Pusher** para garantir que as notificações sejam entregues apenas aos usuários corretos:
- `private-user.{user_id}` - Canal privado para notificações específicas do usuário
- `private-class.{class_id}` - Canal privado para atualizações de turma específica
- Sistema de autorização customizado no Laravel para validar acesso aos canais

## 🔑 Obtendo as Credenciais do Pusher

Para utilizar o Pusher, você precisa criar uma conta e obter as credenciais necessárias:

1. **Criar Conta**: Acesse [https://pusher.com/](https://pusher.com/) e crie uma conta gratuita
2. **Criar Aplicação**: No dashboard, clique em "Create App"
3. **Configurar Aplicação**:
- **App Name**: Nome da sua aplicação (ex: FuncionalFit)
- **Cluster**: Escolha o cluster mais próximo (ex: `mt1` para América do Sul)
- **Tech Stack**: Selecione "Laravel" como backend e "Vue.js" como frontend
4. **Obter Credenciais**: Na aba "App Keys", você encontrará:
- `app_id` - ID único da aplicação
- `key` - Chave pública (usada no frontend)
- `secret` - Chave secreta (usada no backend)
- `cluster` - Região do servidor

> 📋 **Plano Gratuito**: O Pusher oferece até 200.000 mensagens/dia e 100 conexões simultâneas no plano gratuito, suficiente para desenvolvimento e pequenos projetos.

### Configuração do Ambiente (.env)

### 🛠️ Configuração WebSocket

```bash

# Instalação do Pusher
composer require pusher/pusher-php-server

# Configuração do ambiente (.env)

BROADCAST_DRIVER=pusher
PUSHER_APP_ID=seu_pusher_app_id
PUSHER_APP_KEY=sua_pusher_app_key
PUSHER_APP_SECRET=seu_pusher_app_secret
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

```
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
- Gerenciamento de eventos e canais com Pusher




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
