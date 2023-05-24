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
      background-color: #2563eb;
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
            <h1 class="s-title">Lembrete de pagamento pendente da sua assinatura</h1>
          </div>

          <div>
            <div class="signature-body">
              <p>
                Estamos entrando em contato para lembrá-lo sobre o pagamento pendente da sua assinatura conosco.
              </p>

              <p>
                Conforme nosso acordo, a sua assinatura deve ser paga mensalmente até a data de vencimento.
                No entanto, verificamos que o pagamento ainda não foi realizado.
              </p>

              <p>
                Gostaríamos de ressaltar a importância do pagamento em dia para que possamos
                continuar fornecendo nossos serviços e manter a qualidade que você espera de nós.
                Você também pode gerenciar sua assinatura clicando em Gerenciar assinatura:
              </p>

              <div class="button-subscription-container">
                <div>
                  <a class="button-subscription" href="{{ $uri }}">Gerenciar assinatura</a>
                </div>
              </div>

              <p>
                Se por acaso houver qualquer problema com relação ao pagamento,
                pedimos que entre em contato conosco o mais breve possível
                para que possamos encontrar uma solução adequada juntos.
              </p>

              <p>
                Agradecemos pela sua atenção e esperamos solucionar essa pendência o quanto antes.
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
