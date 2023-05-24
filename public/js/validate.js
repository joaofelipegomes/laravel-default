function validateCNPJ(cnpj) {
  cnpj = cnpj.replace(/[^\d]+/g, '');

  if (cnpj.length !== 14) {
    return false;
  }

  if (/^(\d)\1+$/.test(cnpj)) {
    return false;
  }

  let sum = 0;
  let weight = 2;
  for (let i = 11; i >= 0; i--) {
    sum += parseInt(cnpj.charAt(i)) * weight;
    weight = weight === 9 ? 2 : weight + 1;
  }
  let rest = sum % 11;
  let verifyingDigit = rest < 2 ? 0 : 11 - rest;
  if (parseInt(cnpj.charAt(12)) !== verifyingDigit) {
    return false;
  }

  sum = 0;
  weight = 2;
  for (let i = 12; i >= 0; i--) {
    sum += parseInt(cnpj.charAt(i)) * weight;
    weight = weight === 9 ? 2 : weight + 1;
  }
  rest = sum % 11;
  verifyingDigit = rest < 2 ? 0 : 11 - rest;
  if (parseInt(cnpj.charAt(13)) !== verifyingDigit) {
    return false;
  }

  return true;
}

function validateCPF(cpf) {
  cpf = cpf.replace(/[^\d]+/g, '');

  if (cpf.length !== 11) {
    return false;
  }

  if (/^(\d)\1+$/.test(cpf)) {
    return false;
  }

  let sum = 0;
  for (let i = 0; i < 9; i++) {
    sum += parseInt(cpf.charAt(i)) * (10 - i);
  }
  let rest = sum % 11;
  let verifyingDigit = rest < 2 ? 0 : 11 - rest;
  if (parseInt(cpf.charAt(9)) !== verifyingDigit) {
    return false;
  }

  sum = 0;
  for (let i = 0; i < 10; i++) {
    sum += parseInt(cpf.charAt(i)) * (11 - i);
  }
  rest = sum % 11;
  verifyingDigit = rest < 2 ? 0 : 11 - rest;
  if (parseInt(cpf.charAt(10)) !== verifyingDigit) {
    return false;
  }

  return true;
}
