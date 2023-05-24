var options = {
  onKeyPress: function (cpf, ev, el, op) {
    var masks = ['00.000.000/0000-00'];
    $('input[name="document-number"]').mask((cpf.length > 14) ? masks[1] : masks[0], op);
  }
}

var options_subscription = {
  onKeyPress: function (cpf, ev, el, op) {
    var masks = ['000.000.000-000', '00.000.000/0000-00'];
    $('input[name="subscription-document"]').mask((cpf.length > 14) ? masks[1] : masks[0], op);
  }
}

var options_document = {
  onKeyPress: function (cpf, ev, el, op) {
    var masks = ['000.000.000-000', '00.000.000/0000-00'];
    $('input[name="document-number-check"]').mask((cpf.length > 14) ? masks[1] : masks[0], op);
  }
}

$('input[name="zipcode"]').mask('00000-000');
$('input[name="phone"]').mask('(00) 0000-00009');
$('input[name="phone"]').blur(function(event) {
  if($(this).val().length == 15) {
    $('input[name="phone"]').mask('(00) 00000-0009');
  } else {
    $('input[name="phone"]').mask('(00) 0000-00009');
  }
});


// document number

$('input[name="document-number-check"]').val().length > 11 ? $('input[name="document-number-check"]').mask('00.000.000/0000-00', options_document) : $('input[name="document-number-check"]').mask('000.000.000-00#', options_document);
$('input[name="subscription-document"]').val().length > 11 ? $('input[name="subscription-document"]').mask('00.000.000/0000-00', options_subscription) : $('input[name="subscription-document"]').mask('000.000.000-00#', options_subscription);

$('input[name="due-date"]').mask('00/00/0000')
$('input[name="start-date"]').mask('00/00/0000')
$('input[name="end-date"]').mask('00/00/0000')
$('input[name="entered-at"]').mask('00/00/0000')

$('input[name="punched-start"]').mask('00/00/0000 00:00:00')
$('input[name="punched-end"]').mask('00/00/0000 00:00:00')

$('input[name="date"]').mask('00/00/0000 00:00:00')

$('input[name="days"]').maskMoney({
  suffix: " dias",
  precision: 0
})

$('input[name="amount"]').maskMoney({
  prefix: "R$ ",
  decimal: ",",
  thousands: "."
})

$('input[name="subscription-amount"]').maskMoney({
  prefix: "R$ ",
  decimal: ",",
  thousands: "."
})
