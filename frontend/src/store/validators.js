import {
    required,
    email,
    helpers,
  } from "@vuelidate/validators";

export const required$ = helpers.withMessage('Este campo é obrigatório', required);
export const email$ = helpers.withMessage("Informe um endereço de e-mail válido", email);