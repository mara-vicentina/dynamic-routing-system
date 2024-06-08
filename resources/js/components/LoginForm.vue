<template>
    <BContainer class="d-flex justify-content-center align-items-center vh-100">
      <BCard class="w-50">
        <BForm @submit.stop.prevent="handleSubmit">
          <BRow>
            <BCol>
              <img src="../../../public/img/dynamic.png" class="main-img"/>
            </BCol>
          </BRow>
            <p class="text-center main-color mt-3">
              Insira as credenciais para acessar sua conta.
            </p>
          <BFormGroup label="E-mail*" label-for="email" class="main-color">
            <BFormInput
              id="email"
              v-model="email"
              type="email"
              placeholder="Insira o e-mail"
              required
            ></BFormInput>
          </BFormGroup>
          
          <BFormGroup label="Password*" label-for="password" class="mt-3 main-color">
            <BFormInput
              id="password"
              v-model="password"
              type="password"
              placeholder="Insira a senha"
              required
            ></BFormInput>
          </BFormGroup>
          
          <BButton type="submit" variant="primary" class="w-100 mt-3">Login</BButton>
          <BAlert v-if="showError" variant="danger" :model-value="true" class="mt-3">E-mail ou senha incorreto(s).</BAlert>
        </BForm>
      </BCard>
    </BContainer>
</template>
  
<script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
        showError: false
      };
    },
    methods: {
      // Manipula o envio do formulário de login
      handleSubmit() {
        axios.post('/api/login', {
          email: this.email,
          password: this.password
        }).then((response) => {
          // Se o login for bem-sucedido, armazena o token e redireciona para o dashboard
          if (response.data.token) {
            localStorage.setItem('token', response.data.token);
            this.$router.push({ name: 'dashboard' });
          }
        }).catch((err) => {
          // Exibe mensagem de erro se o login falhar
          this.showError = true;
        });
      }
    }
  };
</script>
  
<style scoped>
    .main-color {
        color: #3E84BD;
    }

    button {
      background-color: #3E84BD;
      border: none;
    }

    button:hover {
      background-color: #3E65BD;
    }
    .main-img {
      width: auto;
      height: 80px;
      margin: auto;
      display: block;
    }
</style>