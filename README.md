# Login com Facebook

[![GitHub version](https://badge.fury.io/gh/thalysonrodrigues%2Flogin-facebook.svg)](https://badge.fury.io/gh/thalysonrodrigues%2Flogin-facebook)
[![Software License](https://img.shields.io/apm/l/vim-mode.svg)](https://github.com/thalysonrodrigues/login-facebook/blob/master/LICENSE)

> Template **fullstack** para criar usuários, fazer login com dados criados ou através de OAuth com o Facebook. Este template foi criado com o esqueleto do micro framework zend expressive. Para mais informações sobre a estrutura e configuração acesse: https://docs.zendframework.com/zend-expressive/

## Por que este modelo?

Este modelo tem o intuito de facilitar a criação de um blog, site, ou quaisquer aplicações web que necessitem de autenticação de usuários utilizando da abstração do **facebook** ou autenticações **jwt**.

## Importante

*Nota:* Este modelo é simples, portanto revise a estrutura de diretórios criados e a segurança envolvida na sua aplicação. Este modelo não fornece nenhuma garantia de segurança para sua aplicação apenas que seja desenvolvida de uma maneira mais rápida.

## Estrutura de diretórios do código fonte

```
* src/
  * App
    * src/
      # tudo que for pertencente ao seu núcleo
      * Core
        # arquivos que construam seu dominio como factories
        * Domain
          # factories para serviços
          * Service
        # factories de middlewares  
        * Factory
        * Infrastructure
          # factories para repositórios
          * Repository
      # tudo que for pertencente ao seu problema de dominio
      * Domain
        # documentos ou entidades do seu dominio
        * Documents
        # ações relacionadas ao seu problema de domínio
        * Handler
          # acões especificas para usuários
          * User
        # serviços que compõem o seu dominio
        * Service
          # exceções para serviços
          * Exception
        # valores de objetos para suas entidades/documentos
        * Value
          * Exception
      # ações que não são especificas
      * Handler
      * Infrastructure
      # seus repositórios e interfaces
        * Repository
      # middlewares padrões para aplicação
      * Middleware
    # estrutura padrão do zend expressive
    * templates/
```

## Infraestrutura

Este modelo utiliza do php7 rodando em cima de um container com nginx linkado ao mongodb. Revise as versões utilizadas em `docker-compose.yml`.

## Créditos

* Thalyson Alexandre Rodrigues de Sousa
    - [Github](https://github.com/thalysonrodrigues)
    - Email: *tha.motog@gmail.com*

## Licença

The MIT License (MIT). Please see [License File](https://github.com/thalysonrodrigues/login-facebook/blob/master/LICENSE) for more information.