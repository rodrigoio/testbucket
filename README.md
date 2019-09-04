# 99tests (provisório)

Seja bem vindo ao 99tests, uma ferramenta que visa auxiliar o processo de testes por meio da geração
de casos de testes funcionais.

## Sobre o 99tests (provisório)
Esta ferramenta tem por objetivo gerar casos de testes de forma automatizada, a partir da definição de uma especificação
em notação YAML. Esta especificação tem por objetivo determinar domínios de entrada, correlação entre campos de um 
formulário. Bem como regras de negócio e contextos.

Uma vez que temos uma especificação de forma concreta e não subjetiva, podemos aplicar diversas técnicas conhecidas de 
testes de software para gerar de fato os casos de testes. O escopo deste projeto se limita, por hora, a testes de 
alto nível, não tendo relação direta com o código da aplicação, mas sim com a especificação.

## Fases Previstas
Este projeto está em pleno desenvolvimento, e já temos algumas fases previstas e outras que ainda demandam mais
estudos e avaliações.
- Camada de especificação
- Utilitário para uso via terminal
- Camada de domínios nativos
- Camada de geradores de dados
- Camada de resultados e formatos de saídas
- Uso de casos de sucesso como precedentes para casos de testes atuais
- Testes de estado

Sendo que, atualmente todo o esforço está sendo voltado para a "camada de domínios nativos", temos também alguns esboços para [especificação do domínio de entrada](https://github.com/rodrigoio/99tests/blob/master/tests/Samples/add_user.yml)

#### Observações gerais
Compreendemos que tanto definições em camadas de especificação, geração de dados e saídas não serão completamente
atendidas, por tanto elaborar uma interface extensível é sempre a melhor abordagem.

#### Canais:
Caso tenha interesse neste projeto, mande-nos uma mensagem via [slack](https://join.slack.com/t/99testsgroup/shared_invite/enQtNzE1MjMxNjA0MjI0LTE5MDRkOGU3NGMwM2YzNzA2NzA0YmYzMzE5YjQ3MzE0YjY2NjFkNGExMDgyMjVjZTAxYWQ0Zjc2MTM1N2M2Njc). Toda crítica e sugestão é bem vinda, inclusive um nome melhor!
