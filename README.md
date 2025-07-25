# 🏠 Sistema Amsillote - Pesquisa de Mercado Imobiliário

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC34A?style=for-the-badge&logo=alpine.js&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

**Sistema completo de gestão imobiliária com pesquisa de mercado, vistorias e controle de tarefas**

[Instalação](#-instalação) • [Funcionalidades](#-funcionalidades) • [Tecnologias](#-tecnologias) • [Screenshots](#-screenshots) • [Contribuição](#-contribuição)

</div>

---

## 📋 Sobre o Projeto

O **Sistema Amsillote** é uma aplicação web completa desenvolvida em Laravel para gestão de pesquisas de mercado imobiliário. O sistema oferece funcionalidades avançadas para controle de imóveis, vistorias, agenda, clientes e relatórios, com sistema robusto de permissões e roles.

### ✨ Destaques

- 🏘️ **Gestão Completa de Imóveis** - Cadastro detalhado com fotos, localização e características
- 📊 **Pesquisa de Mercado** - Análise de preços e tendências do mercado imobiliário
- 📋 **Sistema de Vistorias** - Controle completo de vistorias técnicas
- 👥 **Gestão de Clientes** - CRM integrado com validação de CPF
- 📅 **Agenda Inteligente** - Controle de compromissos e eventos
- 🛡️ **Sistema de Permissões** - Controle granular de acesso usando Spatie Permission
- 📱 **Interface Responsiva** - Design moderno com TailwindCSS
- 📄 **Relatórios em PDF** - Geração automática de relatórios e documentos

---

## 🚀 Funcionalidades

### 🏠 **Módulo de Imóveis**

- ✅ Cadastro completo com características detalhadas
- ✅ Upload múltiplo de fotos com compressão automática
- ✅ Geolocalização e mapas integrados
- ✅ Cálculo automático de valores de mercado
- ✅ Exportação em PDF individual e em lote
- ✅ Sistema de busca avançada

### 👤 **Gestão de Usuários**

- ✅ Autenticação segura com Laravel Breeze
- ✅ Sistema de roles e permissões granulares
- ✅ Validação robusta de CPF (único no sistema)
- ✅ Interface elegante de registro com validação em tempo real
- ✅ Perfis diferenciados (Admin, Supervisor, Técnico, Cliente)

### 📋 **Sistema de Vistorias**

- ✅ Formulário completo de vistoria técnica
- ✅ Upload de fotos e documentos
- ✅ Geração automática de relatórios
- ✅ Controle de status e acompanhamento
- ✅ Integração com agenda

### 📅 **Agenda e Compromissos**

- ✅ Calendário interativo
- ✅ Agendamento de vistorias
- ✅ Notificações e lembretes
- ✅ Controle de equipe técnica

### 📊 **Controle de Tarefas**

- ✅ Kanban board para organização
- ✅ Priorização e categorização
- ✅ Atribuição para membros da equipe
- ✅ Acompanhamento de progresso
- ✅ Relatórios de produtividade

### 🛒 **Portal do Cliente (Amostra)**

- ✅ Interface exclusiva para clientes
- ✅ Sistema de carrinho para amostras
- ✅ Busca e filtros avançados
- ✅ Acesso controlado por permissões

---

## 🛠️ Tecnologias

### Backend

- **Laravel 12.x** - Framework PHP robusto
- **PHP 8.2+** - Linguagem de programação
- **MySQL** - Banco de dados relacional
- **Spatie Permission** - Sistema de permissões e roles
- **Intervention Image** - Processamento de imagens
- **DOMPDF/MPDF** - Geração de PDFs

### Frontend

- **TailwindCSS 3.x** - Framework CSS utilitário
- **Alpine.js** - Framework JavaScript reativo
- **Blade Templates** - Engine de templates do Laravel
- **Vite** - Build tool moderno

### Bibliotecas Adicionais

- **Carbon** - Manipulação de datas
- **Laravel Breeze** - Autenticação
- **Faker** - Geração de dados fake para testes

---

## 📦 Instalação

### Pré-requisitos

- PHP 8.2 ou superior
- Composer
- Node.js e NPM
- MySQL 8.0+
- Git

### Passo a passo

1. **Clone o repositório**

```bash
git clone https://github.com/seu-usuario/sistema-amsillote.git
cd sistema-amsillote
```

2. **Instale as dependências PHP**

```bash
composer install
```

3. **Instale as dependências JavaScript**

```bash
npm install
```

4. **Configure o ambiente**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure o banco de dados**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=amsillote
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

6. **Execute as migrações**

```bash
php artisan migrate
```

7. **Rode os seeders (opcional)**

```bash
php artisan db:seed
```

8. **Crie o link simbólico para storage**

```bash
php artisan storage:link
```

9. **Compile os assets**

```bash
npm run build
# ou para desenvolvimento
npm run dev
```

10. **Inicie o servidor**

```bash
php artisan serve
```

Acesse: `http://localhost:8000`

---

## 👤 Sistema de Usuários

### Roles Disponíveis

| Role                | Descrição                       | Permissões                    |
| ------------------- | ------------------------------- | ----------------------------- |
| **Administrador**   | Acesso total ao sistema         | Todas as permissões           |
| **Supervisor**      | Gestão de equipe e relatórios   | Visualizar, criar, editar     |
| **Técnico**         | Execução de vistorias e tarefas | Vistorias, tarefas atribuídas |
| **Cliente Amostra** | Acesso ao portal de amostras    | Consulta de imóveis           |

### Usuário Padrão

- **Email:** admin@amsillote.com
- **Senha:** password
- **Role:** Administrador

---

## 🗂️ Estrutura do Projeto

```
├── app/
│   ├── Http/Controllers/          # Controllers da aplicação
│   ├── Models/                    # Models Eloquent
│   ├── Helpers/                   # Classes auxiliares
│   └── Rules/                     # Regras de validação customizadas
├── database/
│   ├── migrations/                # Migrações do banco
│   └── seeders/                   # Seeders para popular dados
├── resources/
│   ├── views/                     # Templates Blade
│   ├── css/                       # Estilos CSS
│   └── js/                        # JavaScript
├── routes/
│   ├── web.php                    # Rotas web
│   └── auth.php                   # Rotas de autenticação
└── config/
    └── amsillote.php              # Configurações do sistema
```

---

## 🔧 Configuração

### Configurações do Sistema

O arquivo `config/amsillote.php` contém as principais configurações:

```php
return [
    'system_name' => 'Sistema Amsillote',
    'company_name' => 'Amsillote',
    'description' => 'Sistema de Pesquisa de Mercado',
    'version' => '1.0.0',
    'logo' => [
        'main' => 'img/logo.png',
        'mini' => 'img/logomini.png',
    ],
    // ... outras configurações
];
```

### Validação de CPF

O sistema possui validação robusta de CPF:

- Validação matemática completa
- Verificação de unicidade no banco
- Formatação automática (máscara)
- Limpeza automática antes do armazenamento

---

## 🧪 Testes

```bash
# Executar todos os testes
php artisan test

# Executar testes específicos
php artisan test --filter=UserTest

# Executar com coverage
php artisan test --coverage
```

---

## 📈 Performance

### Otimizações Implementadas

- ✅ Lazy loading de relacionamentos Eloquent
- ✅ Cache de consultas frequentes
- ✅ Compressão automática de imagens
- ✅ Minificação de assets com Vite
- ✅ Paginação em listagens grandes

### Recomendações para Produção

- Configure o Redis para cache e sessões
- Use um CDN para assets estáticos
- Configure o Horizon para filas
- Implemente backup automático do banco

---

## 🔒 Segurança

- ✅ Validação CSRF em formulários
- ✅ Sanitização de inputs
- ✅ Hash seguro de senhas
- ✅ Middleware de autenticação
- ✅ Sistema de permissões granulares
- ✅ Validação de uploads de arquivos

---

## 📚 Documentação Adicional

- [Guia de Permissões](SPATIE-PERMISSION-GUIDE.md)
- [Como usar Permissões](COMO_USAR_PERMISSOES.md)
- [Implementação Finalizada](IMPLEMENTACAO_FINALIZADA.md)
- [Sistema de Registro](SISTEMA_REGISTRO_AMSILLOTE.md)

---

## 🤝 Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

### Padrões de Código

- Siga os padrões PSR-12
- Use nomes descritivos para variáveis e métodos
- Comente código complexo
- Escreva testes para novas funcionalidades

---

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

## 📞 Contato

**Desenvolvedor:** Rafael Barbosa  
**Email:** contato@amsillote.com.br  
**LinkedIn:** [Seu LinkedIn]  
**GitHub:** [Seu GitHub]

---

## 🎯 Roadmap

### Versão 1.1

- [ ] API REST completa
- [ ] App mobile (React Native)
- [ ] Sistema de notificações push
- [ ] Dashboard com gráficos avançados

### Versão 1.2

- [ ] Integração com WhatsApp Business
- [ ] Sistema de assinatura digital
- [ ] BI e analytics avançados
- [ ] Módulo financeiro

---

## ⭐ Agradecimentos

- [Laravel](https://laravel.com) - Framework PHP fantástico
- [TailwindCSS](https://tailwindcss.com) - CSS framework incrível
- [Spatie](https://spatie.be) - Pacotes Laravel de alta qualidade
- [Alpine.js](https://alpinejs.dev) - JavaScript reativo simples

---

<div align="center">

**⭐ Se este projeto foi útil, deixe uma estrela!**

Feito com ❤️ por [Rafael Barbosa](https://github.com/seu-usuario)

</div>

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
