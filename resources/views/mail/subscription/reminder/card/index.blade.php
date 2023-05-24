<center>
  <style>
    p {
      margin: 0px !important;
    }

    .s-table {
      max-width: 500px;
      margin: 0auto;
      font-family: Arial, Helvetica, sans-serif;
    }

    .s-td {
      text-align: left;
    }

    .s-logo {
      padding: 10px;
    }

    .s-title {
      margin-top: 50px;
      font-weight: 600;
    }

    .signature-mail {
      margin-top: 50px;
      margin-bottom: 50px;
    }

    .signature-body {
      font-size: 1rem;
      line-height: 1.25rem;
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .button-subscription-container {
      padding: 10px 0px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .button-subscription {
      border-radius: 0.375rem;
      padding: 10px 25px;
      background-color: #16a34a;
      color: white;
      cursor: pointer;
      text-decoration: none !important;
    }

    .footer-info {
      border-top: 1px solid #d1d5db;
      padding-top: 15px;
      color: #9ca3af;
      font-size: 0.875rem;
      line-height: 1.25rem;
    }
  </style>

  <table class="s-table" width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
      <td width="100%" class="s-td">
        <div class="s-logo">
          <a class="navbar-brand logo" href="#"><img src="https://static-images.solucoesinova.com.br/admin/9f42ce29-f78a-42d8-8916-9202480e406f.png" class="" alt="" width="130" id="logotype"></a>

          <div>
            <h1 class="s-title">Lembrete de pagamento de sua assinatura</h1>
          </div>

          <div>
            <div class="signature-body">
              <p>
                Gostaríamos de lembrá-lo(a) que sua assinatura de serviço conosco está prestes a vencer.
              </p>

              <p>
                Conforme o acordo de prestação de serviços firmado entre nós, o pagamento recorrente da mensalidade
                no valor de R$ {{ moneyFormat($amount) }} será debitado do seu cartão no dia {{ $duedate }}
                para garantir a continuidade do acesso aos nossos serviços.
              </p>

              <p>
                Caso já tenha efetuado o pagamento, por gentileza, desconsidere este e-mail.
                Caso contrário, pedimos que faça o pagamento o mais breve possível para evitar
                a interrupção do serviço.
              </p>

              <p>
                Caso tenha alguma dúvida ou dificuldade em efetuar o pagamento, nossa equipe está à disposição
                para ajudá-lo(a). Agradecemos a preferência e esperamos continuar atendendo suas expectativas.
              </p>
            </div>

            <div class="signature-mail">
              <p>Atenciosamente,</p>
              <b>Equipe Inova</b>
            </div>

            <p class="footer-info">Esta mensagem foi enviada para porque você possui uma assinatura ativa.</p>
          </div>
        </div>
      </td>
    </tr>
  </table>
</center>
